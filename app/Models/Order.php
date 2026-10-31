<?php

require_once __DIR__ . "/../Core/Database.php";

// An "order" is a row in the `cart` table; its lines live in `cart_items`.
class Order
{
    private PDO $conn;

    // 'completed' is shown as "Delivered". The dashboard and reports count
    // sales with status = 'completed', so we keep that exact value.
    public const STATUSES = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    // All orders (newest first), optionally filtered by order #, customer name, email or status
    public function getAll(string $search = ""): array
    {
        $sql = "SELECT c.cart_id, c.user_id, c.created_at, c.total_price, c.delivery_fee,
                       c.delivery_address_at_order, c.payment_method, c.status,
                       u.full_name, u.email, u.phone,
                       d.code AS discount_code, d.discount_percentage
                FROM cart c
                LEFT JOIN users u ON u.user_id = c.user_id
                LEFT JOIN discount_codes d ON d.discount_code_id = c.discount_code_id";
        $params = [];

        if ($search !== "") {
            $number = ltrim($search, "#");

            $sql .= " WHERE c.cart_id = :id
                         OR u.full_name LIKE :s1
                         OR u.email LIKE :s2
                         OR c.status LIKE :s3";
            $params[":id"] = ctype_digit($number) ? (int) $number : 0;
            $params[":s1"] = "%$search%";
            $params[":s2"] = "%$search%";
            $params[":s3"] = "%$search%";
        }

        $sql .= " ORDER BY c.created_at DESC, c.cart_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $stmt = $this->conn->prepare(
            "SELECT cart_id, status, delivery_address_at_order, payment_method
             FROM cart WHERE cart_id = :id LIMIT 1"
        );
        $stmt->execute([":id" => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Order lines for many orders in one query. Returns [cart_id => [items...]]
    public function getItemsByOrderIds(array $orderIds): array
    {
        $orderIds = array_values(array_unique(array_map('intval', $orderIds)));

        if (!$orderIds) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($orderIds), '?'));

        $sql = "SELECT ci.cart_id, ci.quantity, ci.unit_price_at_purchase, ";
        $sql .= "COALESCE(p.name, col.name, 'Removed item') AS item_name, ";
        $sql .= "CASE WHEN ci.collection_id IS NOT NULL THEN 'Collection' ELSE 'Product' END AS item_type ";
        $sql .= "FROM cart_items ci ";
        $sql .= "LEFT JOIN product p ON p.pro_id = ci.pro_id ";
        $sql .= "LEFT JOIN collections col ON col.collection_id = ci.collection_id ";
        $sql .= "WHERE ci.cart_id IN ($placeholders) ";
        $sql .= "ORDER BY ci.cart_item_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($orderIds);

        $items = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $items[(int) $row['cart_id']][] = $row;
        }

        return $items;
    }

    // The admin can only change the status
    public function update(int $id, string $status): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE cart SET status = :status WHERE cart_id = :id"
        );

        return $stmt->execute([
            ":status" => $status,
            ":id" => $id
        ]);
    }

    // Removes the order together with its reviews and items (all or nothing)
    public function delete(int $id): bool
    {
        $this->conn->beginTransaction();

        try {
            // 1. Reviews written on this order's items
            $stmt = $this->conn->prepare(
                "DELETE FROM reviews
                 WHERE cart_item_id IN (
                     SELECT cart_item_id FROM cart_items WHERE cart_id = :id
                 )"
            );
            $stmt->execute([":id" => $id]);

            // 2. The order's items
            $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = :id");
            $stmt->execute([":id" => $id]);

            // 3. The order itself
            $stmt = $this->conn->prepare("DELETE FROM cart WHERE cart_id = :id");
            $stmt->execute([":id" => $id]);

            $this->conn->commit();

            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
}               