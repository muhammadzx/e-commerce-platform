<?php

require_once __DIR__ . "/../Core/Database.php";

class Category
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    // All categories with the number of products inside each one
    public function getAll(string $search = ""): array
    {
        $sql = "SELECT c.cat_id, c.name, c.description,
                       COUNT(p.pro_id) AS products_count
                FROM categories c
                LEFT JOIN product p ON p.cat_id = c.cat_id";
        $params = [];

        if ($search !== "") {
            $sql .= " WHERE c.name LIKE :s1 OR c.description LIKE :s2";
            $params[":s1"] = "%$search%";
            $params[":s2"] = "%$search%";
        }

        $sql .= " GROUP BY c.cat_id, c.name, c.description
                  ORDER BY c.cat_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $stmt = $this->conn->prepare(
            "SELECT cat_id, name, description FROM categories WHERE cat_id = :id LIMIT 1"
        );
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function nameExists(string $name, int $exceptId = 0): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM categories WHERE name = :name AND cat_id != :id"
        );
        $stmt->execute([":name" => $name, ":id" => $exceptId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(string $name, ?string $description): int
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO categories (name, description) VALUES (:name, :description)"
        );
        $stmt->execute([":name" => $name, ":description" => $description]);

        return (int) $this->conn->lastInsertId();
    }

    public function update(int $id, string $name, ?string $description): void
    {
        $stmt = $this->conn->prepare(
            "UPDATE categories SET name = :name, description = :description WHERE cat_id = :id"
        );
        $stmt->execute([
            ":name" => $name,
            ":description" => $description,
            ":id" => $id
        ]);
    }

    public function countProducts(int $id): int
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM product WHERE cat_id = :id"
        );
        $stmt->execute([":id" => $id]);

        return (int) $stmt->fetchColumn();
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE cat_id = :id");
        $stmt->execute([":id" => $id]);
    }
}
