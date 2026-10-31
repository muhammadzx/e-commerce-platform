<?php

require_once __DIR__ . "/../Core/Database.php";

class Wishlist
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    // Get all wishlist items for a specific user
    public function getByUserId(int $userId): array
    {
        $sql = "
            SELECT
                w.wishlist_id,
                w.user_id,
                w.pro_id,
                w.collection_id,

                p.name AS product_name,
                p.description AS product_description,
                p.price AS product_price,
                p.quantity AS product_quantity,
                p.status AS product_status,

                col.name AS collection_name,
                col.description AS collection_description,
                col.discount AS collection_discount,
                col.image AS collection_image,
                col.status AS collection_status,

                pi.image_url AS product_image

            FROM wishlist w

            LEFT JOIN product p
                ON p.pro_id = w.pro_id

            LEFT JOIN collections col
                ON col.collection_id = w.collection_id

            LEFT JOIN product_images pi
                ON pi.pro_id = p.pro_id
                AND pi.is_primary = 1

            WHERE w.user_id = :user_id

            ORDER BY w.wishlist_id DESC
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":user_id" => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a product to wishlist
    public function addProduct(int $userId, int $productId): bool
    {
        // Prevent duplicate wishlist item
        $check = $this->conn->prepare(
            "SELECT wishlist_id
             FROM wishlist
             WHERE user_id = :user_id
             AND pro_id = :pro_id
             LIMIT 1"
        );

        $check->execute([
            ":user_id" => $userId,
            ":pro_id" => $productId
        ]);

        if ($check->fetch()) {
            return false;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO wishlist
                (user_id, pro_id, collection_id)
             VALUES
                (:user_id, :pro_id, NULL)"
        );

        return $stmt->execute([
            ":user_id" => $userId,
            ":pro_id" => $productId
        ]);
    }

    // Add a collection to wishlist
    public function addCollection(int $userId, int $collectionId): bool
    {
        // Prevent duplicate wishlist item
        $check = $this->conn->prepare(
            "SELECT wishlist_id
             FROM wishlist
             WHERE user_id = :user_id
             AND collection_id = :collection_id
             LIMIT 1"
        );

        $check->execute([
            ":user_id" => $userId,
            ":collection_id" => $collectionId
        ]);

        if ($check->fetch()) {
            return false;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO wishlist
                (user_id, pro_id, collection_id)
             VALUES
                (:user_id, NULL, :collection_id)"
        );

        return $stmt->execute([
            ":user_id" => $userId,
            ":collection_id" => $collectionId
        ]);
    }

    // Check if a product already exists in wishlist
    public function hasProduct(int $userId, int $productId): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT wishlist_id
             FROM wishlist
             WHERE user_id = :user_id
             AND pro_id = :pro_id
             LIMIT 1"
        );

        $stmt->execute([
            ":user_id" => $userId,
            ":pro_id" => $productId
        ]);

        return (bool) $stmt->fetch();
    }

    // Check if a collection already exists in wishlist
    public function hasCollection(int $userId, int $collectionId): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT wishlist_id
             FROM wishlist
             WHERE user_id = :user_id
             AND collection_id = :collection_id
             LIMIT 1"
        );

        $stmt->execute([
            ":user_id" => $userId,
            ":collection_id" => $collectionId
        ]);

        return (bool) $stmt->fetch();
    }

    // Delete a wishlist item
    public function delete(int $userId, int $wishlistId): bool
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM wishlist
             WHERE wishlist_id = :wishlist_id
             AND user_id = :user_id"
        );

        $stmt->execute([
            ":wishlist_id" => $wishlistId,
            ":user_id" => $userId
        ]);

        return $stmt->rowCount() > 0;
    }
}