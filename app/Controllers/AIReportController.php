<?php
require_once __DIR__ . '/../Models/AIReport.php';

class AIReportController
{
    public function index()
    {
        require __DIR__ . '/../../config/connection.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateFrom = trim($_POST['date_from'] ?? '');
            $dateTo = trim($_POST['date_to'] ?? '');
            $requestPrompt = trim($_POST['request_prompt'] ?? '');

            $message = '';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($dateFrom === '' || $dateTo === '' || $requestPrompt === '') {
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
            }
            
        }
        
        require __DIR__ . "/../Views/admin/ai_reports.php";
    }
}

?>