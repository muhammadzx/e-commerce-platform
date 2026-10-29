
<?php

require_once __DIR__ . "/../core/Database.php";

class Product
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Get all active products
    public function getAllProducts()
    {
        $sql = "SELECT
                    p.pro_id,
                    p.cat_id,
                    p.name,
                    p.description,
                    p.price,
                    p.quantity,
                    p.count_selling,
                    p.status,
                    (
                        SELECT pi.image_url
                        FROM product_images pi
                        WHERE pi.pro_id = p.pro_id
                          AND pi.is_primary = 1
                        ORDER BY pi.image_id ASC
                        LIMIT 1
                    ) AS image_url
                FROM product p
                WHERE p.status = 'active'
                ORDER BY p.pro_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one product by its ID
    public function getProductById($id)
    {
        $sql = "SELECT
                    p.pro_id,
                    p.cat_id,
                    p.name,
                    p.description,
                    p.price,
                    p.quantity,
                    p.count_selling,
                    p.status,
                    (
                        SELECT pi.image_url
                        FROM product_images pi
                        WHERE pi.pro_id = p.pro_id
                          AND pi.is_primary = 1
                        ORDER BY pi.image_id ASC
                        LIMIT 1
                    ) AS image_url
                FROM product p
                WHERE p.pro_id = :id
                  AND p.status = 'active'
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":id" => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get related products from the same category
    public function getRelatedProducts($categoryId, $productId)
    {
        $sql = "SELECT
                    p.pro_id,
                    p.cat_id,
                    p.name,
                    p.description,
                    p.price,
                    p.quantity,
                    p.status,
                    (
                        SELECT pi.image_url
                        FROM product_images pi
                        WHERE pi.pro_id = p.pro_id
                          AND pi.is_primary = 1
                        ORDER BY pi.image_id ASC
                        LIMIT 1
                    ) AS image_url
                FROM product p
                WHERE p.cat_id = :category_id
                  AND p.pro_id != :product_id
                  AND p.status = 'active'
                ORDER BY p.pro_id DESC
                LIMIT 4";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":category_id" => $categoryId,
            ":product_id" => $productId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
