
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

    public function getAllProducts()
    {
        $sql = "SELECT * FROM product
                WHERE status = 'active'
                ORDER BY pro_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
