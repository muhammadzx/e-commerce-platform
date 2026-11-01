<?php
require_once __DIR__ . "/../Core/Database.php";

class Review
{
    private PDO $conn;

    public function __construct()
    {
        require __DIR__ . '/../../config/connection.php';
        $this->conn = $db;
    }

    public function getByProduct(int $proId): array
    {
        // Assumes users has a `name` column. Change u.name if yours differs
        // (e.g. full_name, first_name). Falls back to "Customer" if it fails.
        try {
            $stmt = $this->conn->prepare(
                "SELECT r.rating, r.comment, r.created_at, u.full_name AS reviewer_name
                 FROM reviews r
                 LEFT JOIN users u ON u.user_id = r.user_id
                 WHERE r.pro_id = :id AND r.is_hidden = 0
                 ORDER BY r.review_id DESC"
            );
            $stmt->execute([":id" => $proId]);
        } catch (PDOException $e) {
            $stmt = $this->conn->prepare(
                "SELECT rating, comment, created_at, 'Customer' AS reviewer_name
                 FROM reviews WHERE pro_id = :id AND is_hidden = 0 ORDER BY review_id DESC"
            );
            $stmt->execute([":id" => $proId]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get the 3 highest-rated reviews for a product
public function getTopReviews(int $proId): array
{
    $sql = "SELECT
                r.rating,
                r.comment,
                r.created_at,
                u.full_name AS reviewer_name
            FROM reviews r
            LEFT JOIN users u
                ON u.user_id = r.user_id
            WHERE r.pro_id = :id AND r.is_hidden = 0
            ORDER BY
                r.rating DESC,
                r.created_at DESC,
                r.review_id DESC
            LIMIT 3";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ":id" => $proId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getSummary(int $proId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) AS total, COALESCE(AVG(rating), 0) AS average
             FROM reviews WHERE pro_id = :id AND is_hidden = 0"
        );
        $stmt->execute([":id" => $proId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }





    
    // Check if user purchased this product
    public function hasPurchased(int $userId, int $productId): bool
    {
        $sql = "SELECT COUNT(*)
                FROM cart c
                INNER JOIN cart_items ci
                    ON c.cart_id = ci.cart_id
                WHERE c.user_id = :user_id
                  AND ci.pro_id = :pro_id
                  AND c.status = 'completed'";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":user_id" => $userId,
            ":pro_id" => $productId
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    // Check if user already reviewed this product
    public function hasReviewed(int $userId, int $productId): bool
    {
        $sql = "SELECT COUNT(*)
                FROM reviews
                WHERE user_id = :user_id
                  AND pro_id = :pro_id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":user_id" => $userId,
            ":pro_id" => $productId
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }



    
public function createReview(
    int $userId,
    int $productId,
    int $rating,
    string $comment
): bool {

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        return false;
    }

    // Check if user purchased the product
    if (!$this->hasPurchased($userId, $productId)) {
        return false;
    }

    // Check if user already reviewed the product
    if ($this->hasReviewed($userId, $productId)) {
        return false;
    }

    // Find the purchased cart item
    $sql = "SELECT ci.cart_item_id
            FROM cart_items ci
            INNER JOIN cart c
                ON ci.cart_id = c.cart_id
            WHERE c.user_id = :user_id
              AND ci.pro_id = :pro_id
              AND c.status = 'completed'
            ORDER BY ci.cart_item_id ASC
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ":user_id" => $userId,
        ":pro_id" => $productId
    ]);

    $cartItemId = $stmt->fetchColumn();

    if (!$cartItemId) {
        return false;
    }

    // Insert review
    $sql = "INSERT INTO reviews
                (user_id, pro_id, cart_item_id, rating, comment, created_at)
            VALUES
                (:user_id, :pro_id, :cart_item_id, :rating, :comment, NOW())";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        ":user_id" => $userId,
        ":pro_id" => $productId,
        ":cart_item_id" => $cartItemId,
        ":rating" => $rating,
        ":comment" => trim($comment)
    ]);
}


}