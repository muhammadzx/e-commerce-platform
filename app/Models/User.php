<?php

require_once __DIR__ . '/Collection.php';

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

    // Added: Find user by email for authentication
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT user_id, full_name, email, password, phone, address, role, status
             FROM users WHERE email = :email LIMIT 1"
        );
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user !== false ? $user : null;
    }

    // Password hash of one user (to check the current password)
    public function getPasswordHash(int $id): ?string
    {
        $stmt = $this->conn->prepare("SELECT password FROM users WHERE user_id = :id LIMIT 1");
        $stmt->execute([":id" => $id]);
        $hash = $stmt->fetchColumn();

        return $hash === false ? null : (string) $hash;
    }

    // The customer edits only their own contact details (never role or status)
    public function updateProfile(int $id, array $data): void
    {
        $stmt = $this->conn->prepare(
            "UPDATE users
             SET full_name = :name, email = :email, phone = :phone, address = :address
             WHERE user_id = :id"
        );
        $stmt->execute([
            ":name" => $data["full_name"],
            ":email" => $data["email"],
            ":phone" => $data["phone"],
            ":address" => $data["address"],
            ":id" => $id
        ]);
    }

    // Products and collections the user saved. Collections get their live price from Collection::pricing()
    public function getWishlist(int $id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT
                w.wishlist_id, w.pro_id, w.collection_id,
                p.name AS product_name, p.price AS product_price,
                p.quantity AS product_stock, p.status AS product_status,
                (
                    SELECT pi.image_url FROM product_images pi
                    WHERE pi.pro_id = p.pro_id
                    ORDER BY pi.is_primary DESC, pi.image_id ASC
                    LIMIT 1
                ) AS product_image,
                c.name AS collection_name, c.discount, c.image AS collection_image, c.status AS collection_status
             FROM wishlist w
             LEFT JOIN product p ON p.pro_id = w.pro_id
             LEFT JOIN collections c ON c.collection_id = w.collection_id
             WHERE w.user_id = :id
             ORDER BY w.wishlist_id DESC"
        );
        $stmt->execute([":id" => $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $parts = $this->conn->prepare(
            "SELECT d.quantity, p.price, p.quantity AS stock, p.status
             FROM collections_details d
             INNER JOIN product p ON p.pro_id = d.pro_id
             WHERE d.collection_id = :cid"
        );

        $items = [];

        foreach ($rows as $row) {
            if ($row["collection_id"] !== null) {
                $parts->execute([":cid" => $row["collection_id"]]);
                $pricing = Collection::pricing(["discount" => $row["discount"]], $parts->fetchAll(PDO::FETCH_ASSOC));

                $items[] = [
                    "wishlist_id" => (int) $row["wishlist_id"],
                    "type" => "Collection",
                    "name" => $row["collection_name"],
                    "price" => $pricing["price"],
                    "in_stock" => $row["collection_status"] === "active" && $pricing["available_sets"] > 0,
                    "image" => $row["collection_image"],
                    "url" => "index.php?page=home#bundles"
                ];
            } else {
                $items[] = [
                    "wishlist_id" => (int) $row["wishlist_id"],
                    "type" => "Product",
                    "name" => $row["product_name"],
                    "price" => (float) $row["product_price"],
                    "in_stock" => $row["product_status"] === "active" && (int) $row["product_stock"] > 0,
                    "image" => $row["product_image"],
                    "url" => "index.php?page=product&id=" . (int) $row["pro_id"]
                ];
            }
        }

        return $items;
    }

    public function removeFromWishlist(int $userId, int $wishlistId): void
    {
        $stmt = $this->conn->prepare("DELETE FROM wishlist WHERE wishlist_id = :id AND user_id = :user_id");
        $stmt->execute([":id" => $wishlistId, ":user_id" => $userId]);
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
            ":phone" => $data["phone"] ?? null,
            ":address" => $data["address"] ?? null,
            ":role" => $data["role"] ?? 'customer',
            ":status" => $data["status"] ?? 'active'
        ]);

        return (int) $this->conn->lastInsertId();
    }

    // Added: Update password hash when rehashing is needed
    public function updatePasswordHash(int $id, string $passwordHash): void
    {
        $stmt = $this->conn->prepare(
            "UPDATE users SET password = :password WHERE user_id = :id"
        );
        $stmt->execute([
            ":password" => $passwordHash,
            ":id" => $id
        ]);
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

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute([":id" => $id]);
    }

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