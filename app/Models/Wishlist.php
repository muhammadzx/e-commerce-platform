<?php

require_once __DIR__ . "/../Core/Database.php";

// A wishlist row points to either a product (pro_id) or a collection (collection_id).
class Wishlist
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    // All saved items of a user (newest first)
    public function getByUser(int $userId): array
    {
        return $this->fetchItems($userId, 0);
    }

    // One saved item, only if it belongs to this user
    public function findForUser(int $wishlistId, int $userId)
    {
        $rows = $this->fetchItems($userId, $wishlistId);

        return $rows[0] ?? false;
    }

    private function fetchItems(int $userId, int $wishlistId): array
    {
        $sql = "SELECT w.wishlist_id, w.pro_id, w.collection_id, ";
        $sql .= "COALESCE(p.name, col.name) AS name, ";
        $sql .= "cat.name AS category, ";
        $sql .= "p.price AS product_price, p.quantity AS stock, p.status AS product_status, ";
        $sql .= "col.discount, col.status AS collection_status, ";
        $sql .= "(SELECT SUM(p2.price * cd.quantity) FROM collections_details cd ";
        $sql .= "INNER JOIN product p2 ON p2.pro_id = cd.pro_id ";
        $sql .= "WHERE cd.collection_id = col.collection_id) AS collection_base_price, ";
        $sql .= "(SELECT COUNT(*) FROM collections_details cd3 ";
        $sql .= "INNER JOIN product p3 ON p3.pro_id = cd3.pro_id ";
        $sql .= "WHERE cd3.collection_id = col.collection_id ";
        $sql .= "AND (p3.status <> 'active' OR p3.quantity < cd3.quantity)) AS unavailable_parts, ";
        $sql .= "COALESCE((SELECT pi.image_url FROM product_images pi WHERE pi.pro_id = p.pro_id ";
        $sql .= "ORDER BY pi.is_primary DESC, pi.image_id ASC LIMIT 1), col.image) AS image_url ";
        $sql .= "FROM wishlist w ";
        $sql .= "LEFT JOIN product p ON p.pro_id = w.pro_id ";
        $sql .= "LEFT JOIN categories cat ON cat.cat_id = p.cat_id ";
        $sql .= "LEFT JOIN collections col ON col.collection_id = w.collection_id ";
        $sql .= "WHERE w.user_id = :user ";

        $params = [":user" => $userId];

        if ($wishlistId > 0) {
            $sql .= "AND w.wishlist_id = :wid ";
            $params[":wid"] = $wishlistId;
        }

        $sql .= "ORDER BY w.wishlist_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        $items = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $items[] = $this->decorate($row);
        }

        return $items;
    }

    // Adds the final price, the discount label and an "available" flag to a row
    private function decorate(array $row): array
    {
        $row['name'] = $row['name'] ?? 'Removed item';

        if ($row['collection_id'] !== null) {
            $base = $row['collection_base_price'];
            $discount = (float) $row['discount'];

            $row['price'] = $base === null
                ? 0.0
                : round((float) $base * (1 - $discount / 100), 2);
            $row['discount_label'] = $discount > 0
                ? rtrim(rtrim(number_format($discount, 2, '.', ''), '0'), '.')
                : '';
            $row['available'] = $row['collection_status'] === 'active'
                && $base !== null
                && (int) $row['unavailable_parts'] === 0;
            $row['category'] = 'Collection';
        } else {
            $row['price'] = (float) $row['product_price'];
            $row['discount_label'] = '';
            $row['available'] = $row['product_status'] === 'active'
                && (int) $row['stock'] > 0;
            $row['category'] = $row['category'] ?: 'Product';
        }

        return $row;
    }

    public function has(int $userId, int $productId): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM wishlist WHERE user_id = :user AND pro_id = :pro"
        );
        $stmt->execute([":user" => $userId, ":pro" => $productId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function productExists(int $productId): bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM product WHERE pro_id = :id");
        $stmt->execute([":id" => $productId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    // Adds the product if it is not saved yet, removes it if it is.
    // Returns true when the product is in the wishlist after the call.
    public function toggleProduct(int $userId, int $productId): bool
    {
        if ($this->has($userId, $productId)) {
            $stmt = $this->conn->prepare(
                "DELETE FROM wishlist WHERE user_id = :user AND pro_id = :pro"
            );
            $stmt->execute([":user" => $userId, ":pro" => $productId]);

            return false;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO wishlist (user_id, pro_id, collection_id) VALUES (:user, :pro, NULL)"
        );
        $stmt->execute([":user" => $userId, ":pro" => $productId]);

        return true;
    }

    public function remove(int $wishlistId, int $userId): bool
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM wishlist WHERE wishlist_id = :id AND user_id = :user"
        );

        return $stmt->execute([":id" => $wishlistId, ":user" => $userId]);
    }

    // Number of units in the user's current basket (shown on the bag icon)
    public function basketCount(int $userId): int
    {
        $sql = "SELECT COALESCE(SUM(ci.quantity), 0) ";
        $sql .= "FROM cart c ";
        $sql .= "INNER JOIN cart_items ci ON ci.cart_id = c.cart_id ";
        $sql .= "WHERE c.user_id = :user AND c.status = 'pending'";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":user" => $userId]);

        return (int) $stmt->fetchColumn();
    }

    // Puts one unit of a wishlist item into the user's basket.
    // The basket is the user's cart row with status 'pending'.
    // $item must come from findForUser() so the price is the server's price.
    // Returns [true|false, message].
    public function addToBasket(int $userId, array $item): array
    {
        if (!$item['available']) {
            return [false, 'This item is currently unavailable.'];
        }

        $isCollection = $item['collection_id'] !== null;
        $column = $isCollection ? 'collection_id' : 'pro_id';
        $refId = $isCollection ? (int) $item['collection_id'] : (int) $item['pro_id'];

        $this->conn->beginTransaction();

        try {
            $cartId = $this->findOrCreateBasket($userId);

            $stmt = $this->conn->prepare(
                "SELECT cart_item_id, quantity FROM cart_items
                 WHERE cart_id = :cart AND $column = :ref LIMIT 1"
            );
            $stmt->execute([":cart" => $cartId, ":ref" => $refId]);
            $line = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($line) {
                // Do not put more units of a product in the basket than we have in stock
                if (!$isCollection && (int) $line['quantity'] + 1 > (int) $item['stock']) {
                    $this->conn->rollBack();

                    return [false, 'No more stock available for this product.'];
                }

                $stmt = $this->conn->prepare(
                    "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_item_id = :id"
                );
                $stmt->execute([":id" => $line['cart_item_id']]);
            } else {
                $stmt = $this->conn->prepare(
                    "INSERT INTO cart_items (cart_id, pro_id, collection_id, quantity, unit_price_at_purchase)
                     VALUES (:cart, :pro, :col, 1, :price)"
                );
                $stmt->execute([
                    ":cart" => $cartId,
                    ":pro" => $isCollection ? null : $refId,
                    ":col" => $isCollection ? $refId : null,
                    ":price" => $item['price']
                ]);
            }

            $this->refreshBasketTotal($cartId);

            $this->conn->commit();

            return [true, '"' . $item['name'] . '" was added to your basket.'];
        } catch (PDOException $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            error_log('Add to basket failed: ' . $e->getMessage());

            return [false, 'Unable to add this item to your basket.'];
        }
    }

    private function findOrCreateBasket(int $userId): int
    {
        $stmt = $this->conn->prepare(
            "SELECT cart_id FROM cart
             WHERE user_id = :user AND status = 'pending'
             ORDER BY cart_id DESC LIMIT 1"
        );
        $stmt->execute([":user" => $userId]);
        $cartId = $stmt->fetchColumn();

        if ($cartId) {
            return (int) $cartId;
        }

        // The address is required by the table, it is filled in at checkout
        $stmt = $this->conn->prepare(
            "INSERT INTO cart (user_id, delivery_address_at_order, status, total_price, delivery_fee)
             VALUES (:user, '', 'pending', 0, 0)"
        );
        $stmt->execute([":user" => $userId]);

        return (int) $this->conn->lastInsertId();
    }

    private function refreshBasketTotal(int $cartId): void
    {
        $sql = "UPDATE cart c SET c.total_price = ";
        $sql .= "(SELECT COALESCE(SUM(ci.unit_price_at_purchase * ci.quantity), 0) ";
        $sql .= "FROM cart_items ci WHERE ci.cart_id = :c1) + c.delivery_fee ";
        $sql .= "WHERE c.cart_id = :c2";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":c1" => $cartId, ":c2" => $cartId]);
    }
}