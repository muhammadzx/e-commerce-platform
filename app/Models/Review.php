<?php
require_once __DIR__ . "/../Core/Database.php";

class Review
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function getByProduct(int $proId): array
    {
        // Assumes users has a `name` column. Change u.name if yours differs
        // (e.g. full_name, first_name). Falls back to "Customer" if it fails.
        try {
            $stmt = $this->conn->prepare(
                "SELECT r.rating, r.comment, r.created_at, u.name AS reviewer_name
                 FROM reviews r
                 LEFT JOIN users u ON u.user_id = r.user_id
                 WHERE r.pro_id = :id
                 ORDER BY r.review_id DESC"
            );
            $stmt->execute([":id" => $proId]);
        } catch (PDOException $e) {
            $stmt = $this->conn->prepare(
                "SELECT rating, comment, created_at, 'Customer' AS reviewer_name
                 FROM reviews WHERE pro_id = :id ORDER BY review_id DESC"
            );
            $stmt->execute([":id" => $proId]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSummary(int $proId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) AS total, COALESCE(AVG(rating), 0) AS average
             FROM reviews WHERE pro_id = :id"
        );
        $stmt->execute([":id" => $proId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}