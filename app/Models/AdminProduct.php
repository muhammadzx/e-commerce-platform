<?php

require_once __DIR__ . '/../Core/Database.php';

/** Admin-only product queries, kept separate from the storefront Product model. */
class AdminProduct
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllProductsForAdmin(): array
    {
        $sql = "SELECT p.pro_id, p.cat_id, c.name AS category, p.name,
                       p.description, p.price, p.quantity, p.count_selling, p.status,
                       (SELECT pi.image_url FROM product_images pi
                        WHERE pi.pro_id = p.pro_id AND pi.is_primary = 1
                        ORDER BY pi.image_id ASC LIMIT 1) AS image_url
                FROM product p
                LEFT JOIN categories c ON c.cat_id = p.cat_id
                WHERE p.status = 'active'
                ORDER BY p.pro_id DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProducts(string $search): array
    {
        $sql = "SELECT p.pro_id, p.cat_id, c.name AS category, p.name,
                       p.description, p.price, p.quantity, p.count_selling, p.status,
                       (SELECT pi.image_url FROM product_images pi
                        WHERE pi.pro_id = p.pro_id AND pi.is_primary = 1
                        ORDER BY pi.image_id ASC LIMIT 1) AS image_url
                FROM product p
                LEFT JOIN categories c ON c.cat_id = p.cat_id
                WHERE p.status = 'active'
                  AND (p.name LIKE :name OR p.description LIKE :description OR c.name LIKE :category)
                ORDER BY p.pro_id DESC";
        $stmt = $this->conn->prepare($sql);
        $term = '%' . $search . '%';
        $stmt->execute([':name' => $term, ':description' => $term, ':category' => $term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoriesForAdmin(): array
    {
        $stmt = $this->conn->query("SELECT cat_id, name FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct(int $catId, string $name, string $description, float $price, int $quantity)
    {
        $sql = "INSERT INTO product (cat_id, name, description, price, quantity, status)
                VALUES (:cat_id, :name, :description, :price, :quantity, 'active')";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([
            ':cat_id' => $catId,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':quantity' => $quantity
        ]);
        return $ok ? (int) $this->conn->lastInsertId() : false;
    }

    public function updateProduct(int $productId, int $catId, string $name, string $description, float $price, int $quantity): bool
    {
        $sql = "UPDATE product
                SET cat_id = :cat_id, name = :name, description = :description,
                    price = :price, quantity = :quantity
                WHERE pro_id = :product_id AND status = 'active'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':cat_id' => $catId,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':quantity' => $quantity,
            ':product_id' => $productId
        ]);
    }

    public function hideProduct(int $productId): bool
    {
        $stmt = $this->conn->prepare("UPDATE product SET status = 'inactive' WHERE pro_id = ? AND status = 'active'");
        return $stmt->execute([$productId]);
    }
}
