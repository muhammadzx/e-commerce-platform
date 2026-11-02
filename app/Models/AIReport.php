<?php
require_once __DIR__ . '/../Core/AIReportResponse.php';

class AIReport
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getPeriodSummary($dateFrom, $dateTo)
    {
        $sql = "SELECT
                    COUNT(*) AS completed_orders,
                    COALESCE(SUM(total_price), 0) AS total_sales
                FROM cart
                WHERE status = 'completed'
                  AND created_at >= ?
                  AND created_at < DATE_ADD(?, INTERVAL 1 DAY)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$dateFrom, $dateTo]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getEarliestDate(): ?string
    {
        $value = $this->db->query("SELECT DATE(MIN(created_at)) FROM cart WHERE status = 'completed'")->fetchColumn();
        return $value ? (string)$value : null;
    }
    public function getItemsSummary($dateFrom, $dateTo)
    {
        $productsSql = "SELECT
                        product.name AS item_name,
                        SUM(cart_items.quantity) AS quantity_sold,
                        SUM(cart_items.unit_price_at_purchase * cart_items.quantity) AS sales
                    FROM cart_items
                    JOIN cart ON cart.cart_id = cart_items.cart_id
                    JOIN product ON product.pro_id = cart_items.pro_id
                    WHERE cart.status = 'completed'
                      AND cart.created_at >= ?
                      AND cart.created_at < DATE_ADD(?, INTERVAL 1 DAY)
                    GROUP BY product.pro_id, product.name
                    ORDER BY quantity_sold DESC";

        $productsStmt = $this->db->prepare($productsSql);
        $productsStmt->execute([$dateFrom, $dateTo]);
        $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

        $collectionsSql = "SELECT
                           collections.name AS item_name,
                           SUM(cart_items.quantity) AS quantity_sold,
                           SUM(cart_items.unit_price_at_purchase * cart_items.quantity) AS sales
                       FROM cart_items
                       JOIN cart ON cart.cart_id = cart_items.cart_id
                       JOIN collections
                           ON collections.collection_id = cart_items.collection_id
                       WHERE cart.status = 'completed'
                         AND cart.created_at >= ?
                         AND cart.created_at < DATE_ADD(?, INTERVAL 1 DAY)
                       GROUP BY collections.collection_id, collections.name
                       ORDER BY quantity_sold DESC";

        $collectionsStmt = $this->db->prepare($collectionsSql);
        $collectionsStmt->execute([$dateFrom, $dateTo]);
        $collections = $collectionsStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'products' => $products,
            'collections' => $collections
        ];
    }

    public function saveReport($userId, $title, $requestPrompt, $dateFrom, $dateTo, $reportContent)
    {
        AIReportResponse::assertContent($reportContent);
        $ownsTransaction = !$this->db->inTransaction();
        if ($ownsTransaction) $this->db->beginTransaction();
        try {
        $sql = "INSERT INTO reports_ai
            (user_id, title, request_prompt, date_from, date_to, report_content, generated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute([
            $userId,
            $title,
            $requestPrompt,
            $dateFrom,
            $dateTo,
            $reportContent
        ])) throw new RuntimeException('Report generation failed: the report could not be saved.');

        $reportId = $this->db->lastInsertId();
        if (!$reportId || !ctype_digit((string)$reportId) || (int)$reportId < 1) {
            throw new RuntimeException('Report generation failed: the saved report could not be verified.');
        }
        if ($ownsTransaction) $this->db->commit();
        return $reportId;
        } catch (Throwable $exception) {
            if ($ownsTransaction && $this->db->inTransaction()) $this->db->rollBack();
            throw $exception;
        }
    }

    public function getReportsByUser($userId)
    {
        $sql = "SELECT report_id, title, date_from, date_to, generated_at
            FROM reports_ai
            WHERE user_id = ?
            ORDER BY generated_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportById($reportId, $userId)
    {
        $sql = "SELECT report_id, title, date_from, date_to, report_content, generated_at
            FROM reports_ai
            WHERE report_id = ? AND user_id = ?
            LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$reportId, $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
