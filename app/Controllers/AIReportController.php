<?php
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Models/AIReport.php';

class AIReportController
{
    public function index(?array $adminUser = null)
    {
        $userId = (int) ($adminUser['user_id'] ?? $_SESSION['user_id'] ?? 0);
        $reportTitle = '';
        $reportId = null;
        require __DIR__ . '/../../config/connection.php';
        $reportModel = new AIReport($db);
        $reportContent = '';
        $reportHtml = '';

        $requestedReportId = filter_input(
            INPUT_GET,
            'report_id',
            FILTER_VALIDATE_INT
        );

        if ($requestedReportId) {
            $savedReport = $reportModel->getReportById($requestedReportId, $userId);

            if ($savedReport) {
                $reportId = (int) $savedReport['report_id'];
                $reportTitle = $savedReport['title'];
                $reportContent = $savedReport['report_content'];
                $markdown = str_replace('\\|', '|', $reportContent);

                $environment = new \League\CommonMark\Environment\Environment([
                    'html_input' => 'escape',
                    'allow_unsafe_links' => false
                ]);

                $environment->addExtension(
                    new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension()
                );

                $environment->addExtension(
                    new \League\CommonMark\Extension\Table\TableExtension()
                );

                $converter = new \League\CommonMark\MarkdownConverter($environment);
                $reportHtml = $converter->convert($markdown)->getContent();
                $dateFrom = $savedReport['date_from'];
                $dateTo = $savedReport['date_to'];
            }
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateFrom = trim($_POST['date_from'] ?? '');
            $dateTo = trim($_POST['date_to'] ?? '');
            $requestPrompt = trim($_POST['request_prompt'] ?? '');
            $reportTitle = trim($_POST['report_title'] ?? '');
            $message = '';




            if (
                $reportTitle === '' ||
                $dateFrom === '' ||
                $dateTo === '' ||
                $requestPrompt === ''
            ) {
                $message = 'Please fill in all fields.';
            } elseif (
                !DateTime::createFromFormat('Y-m-d', $dateFrom) ||
                !DateTime::createFromFormat('Y-m-d', $dateTo)
            ) {
                $message = 'Please enter valid dates.';
            } elseif ($dateTo < $dateFrom) {
                $message = 'The end date must be after or equal to the start date.';
            } elseif ($dateFrom > date('Y-m-d') || $dateTo > date('Y-m-d')) {
                $message = 'Report dates cannot be in the future.';
            } else {
                $message = 'The form data is valid.';
            }



            $summary = $reportModel->getPeriodSummary($dateFrom, $dateTo);
            $items = $reportModel->getItemsSummary($dateFrom, $dateTo);
            $productSalesTotal = 0;

            foreach ($items['products'] as $product) {
                $productSalesTotal += (float) $product['sales'];
            }

            $collectionSalesTotal = 0;

            foreach ($items['collections'] as $collection) {
                $collectionSalesTotal += (float) $collection['sales'];
            }

            $itemizedSalesTotal = round(
                $productSalesTotal + $collectionSalesTotal,
                2
            );

            $orderSalesTotal = (float) $summary['total_sales'];

            $difference = round(
                $orderSalesTotal - $itemizedSalesTotal,
                2
            );
            $reportData = [
                'period' => [
                    'from' => $dateFrom,
                    'to' => $dateTo
                ],
                'summary' => $summary,
                'products' => $items['products'],
                'packages' => $items['collections'],
                'verified_calculations' => [
                    'product_sales_total' => round($productSalesTotal, 2),
                    'package_sales_total' => round($collectionSalesTotal, 2),
                    'itemized_sales_total' => $itemizedSalesTotal,
                    'completed_orders_sales_total' => round($orderSalesTotal, 2),
                    'reconciliation_difference' => $difference
                ]
            ];

            $aiPrompt = "
                You are a store data analyst.
                Analyze the store data below for the selected period.
                Follow the administrator's request, and base your conclusions only on the provided data.
                Administrator's request:
                $requestPrompt
                Store data:
                " . json_encode(
                $reportData,
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            );
            $reportContent = $this->generateWithGemini($aiPrompt);

            $reportContent = str_replace('\|', '|', $reportContent);

            $environment = new \League\CommonMark\Environment\Environment([
                'html_input' => 'escape',
                'allow_unsafe_links' => false
            ]);

            $environment->addExtension(
                new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension()
            );

            $environment->addExtension(
                new \League\CommonMark\Extension\Table\TableExtension()
            );

            $converter = new \League\CommonMark\MarkdownConverter($environment);

            $reportHtml = $converter->convert($reportContent)->getContent();

            $reportHtml = $converter->convert($reportContent)->getContent();
            $reportId = $reportModel->saveReport(
                $userId,
                $reportTitle,
                $requestPrompt,
                $dateFrom,
                $dateTo,
                $reportContent
            );
            header('Location: ' . nabta_public_url('admin/ai_reports.php') . '?report_id=' . $reportId);
            exit;

        }

        $reportHistory = $reportModel->getReportsByUser($userId);

        require __DIR__ . "/../Views/admin/ai_reports.php";
    }
    private function generateWithGemini($prompt)
    {
        $apiKey = require __DIR__ . '/../../config/gemini.php';

        //$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent';
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite:generateContent';

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-goog-api-key: ' . $apiKey
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($curl);
            curl_close($curl);
            return 'cURL error: ' . $error;
        }

        curl_close($curl);

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            return 'HTTP ' . $httpCode . ': ' .
                ($result['error']['message'] ?? 'Unknown Gemini error');
        }

        return $result['candidates'][0]['content']['parts'][0]['text']
            ?? 'Gemini returned an empty response.';
    }

    public function download($reportId, ?array $adminUser = null)
    {
        $userId = (int) ($adminUser['user_id'] ?? $_SESSION['user_id'] ?? 0);
        require __DIR__ . '/../../config/connection.php';

        $reportModel = new AIReport($db);
        $report = $reportModel->getReportById($reportId, $userId);

        if (!$report) {
            http_response_code(404);
            exit('Report not found.');
        }

        require_once __DIR__ . '/../../vendor/autoload.php';

        $markdown = str_replace('\|', '|', $report['report_content']);

        $environment = new \League\CommonMark\Environment\Environment([
            'html_input' => 'escape',
            'allow_unsafe_links' => false
        ]);

        $environment->addExtension(
            new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension()
        );

        $environment->addExtension(
            new \League\CommonMark\Extension\Table\TableExtension()
        );

        $converter = new \League\CommonMark\MarkdownConverter($environment);
        $reportHtml = $converter->convert($markdown)->getContent();

        $title = htmlspecialchars($report['title'], ENT_QUOTES, 'UTF-8');

        $html = '
    <!doctype html>
    <html>
    <head>
      <meta charset="UTF-8">
      <style>
        body {
          font-family: "DejaVu Sans", sans-serif;
          color: #24352a;
          font-size: 12px;
          line-height: 1.6;
        }
        h1, h2, h3 { color: #31583d; }
        table {
          width: 100%;
          border-collapse: collapse;
          margin: 14px 0;
        }
        th, td {
          border: 1px solid #ccd5c8;
          padding: 7px;
          text-align: left;
        }
        th { background: #e9efe5; }
        blockquote { color: #526657; }
      </style>
    </head>
    <body>
      <h1>' . $title . '</h1>
      <p>Reporting period: '
            . htmlspecialchars($report['date_from'], ENT_QUOTES, 'UTF-8')
            . ' to '
            . htmlspecialchars($report['date_to'], ENT_QUOTES, 'UTF-8')
            . '</p>
      ' . $reportHtml . '
    </body>
    </html>';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdf = $dompdf->output();

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/pdf');
        header(
            'Content-Disposition: attachment; filename="nabta-report-'
            . (int) $report['report_id']
            . '.pdf"'
        );
        header('Content-Length: ' . strlen($pdf));

        echo $pdf;
        exit;

    }

}

?>
