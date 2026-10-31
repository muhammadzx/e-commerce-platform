<?php

class User
{
    private PDO $conn;

    public const ROLES = ['customer', 'admin'];
    public const STATUSES = ['active', 'suspended'];

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // All users, optionally filtered by name / email / phone
    public function getAll(string $search = ""): array
    {
        $sql = "SELECT user_id, full_name, email, phone, address, role, status
                FROM users";
        $params = [];

        if ($search !== "") {
            $sql .= " WHERE full_name LIKE :s1
                         OR email LIKE :s2
                         OR phone LIKE :s3";
            $params[":s1"] = "%$search%";
            $params[":s2"] = "%$search%";
            $params[":s3"] = "%$search%";
        }

        $sql .= " ORDER BY user_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $stmt = $this->conn->prepare(
            "SELECT user_id, full_name, email, phone, address, role, status
             FROM users WHERE user_id = :id LIMIT 1"
        );
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists(string $email, int $exceptId = 0): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :id"
        );
        $stmt->execute([":email" => $email, ":id" => $exceptId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(array $data): int
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (full_name, email, password, phone, address, role, status)
             VALUES (:name, :email, :password, :phone, :address, :role, :status)"
        );

        $stmt->execute([
            ":name" => $data["full_name"],
            ":email" => $data["email"],
            ":password" => password_hash($data["password"], PASSWORD_DEFAULT),
            ":phone" => $data["phone"],
            ":address" => $data["address"],
            ":role" => $data["role"],
            ":status" => $data["status"]
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Password is only changed when a new one is provided
    public function update(int $id, array $data): void
    {
        $sql = "UPDATE users
                SET full_name = :name,
                    email = :email,
                    phone = :phone,
                    address = :address,
                    role = :role,
                    status = :status";

        $params = [
            ":name" => $data["full_name"],
            ":email" => $data["email"],
            ":phone" => $data["phone"],
            ":address" => $data["address"],
            ":role" => $data["role"],
            ":status" => $data["status"],
            ":id" => $id
        ];

        if (!empty($data["password"])) {
            $sql .= ", password = :password";
            $params[":password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE user_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    // Throws PDOException (code 23000) when the user has orders, reviews, etc.
    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute([":id" => $id]);
    }

    // True when no other active admin exists besides this user
    public function isLastActiveAdmin(int $id): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM users
             WHERE role = 'admin' AND status = 'active' AND user_id != :id"
        );
        $stmt->execute([":id" => $id]);

        return (int) $stmt->fetchColumn() === 0;
    }
}
