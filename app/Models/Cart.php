<?php

require_once __DIR__ . "/Collection.php";

// The `cart` table holds both baskets and orders:
//   status = 'cart'    -> the basket the customer is still filling
//   status = 'pending' -> the customer confirmed it, it is now an order
// A basket line (cart_items) is either a product (pro_id) or a collection (collection_id).
class Cart
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Find the open basket of a user (optionally create it)
    private function getCartId(int $userId, bool $create = false): ?int
    {
        $stmt = $this->conn->prepare(
            "SELECT cart_id
             FROM cart
             WHERE user_id = :user_id AND status = 'cart'
             ORDER BY cart_id DESC
             LIMIT 1"
        );
        $stmt->execute([":user_id" => $userId]);

        $cartId = $stmt->fetchColumn();

        if ($cartId) {
            return (int) $cartId;
        }

        if (!$create) {
            return null;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO cart (user_id, delivery_address_at_order, status)
             VALUES (:user_id, '', 'cart')"
        );
        $stmt->execute([":user_id" => $userId]);

        return (int) $this->conn->lastInsertId();
    }

    // Active collection + its products (with price and stock). Null when unavailable.
    private function getCollectionParts(int $collectionId): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT collection_id, name, description, discount, image
             FROM collections
             WHERE collection_id = :id AND status = 'active'
             LIMIT 1"
        );
        $stmt->execute([":id" => $collectionId]);
        $collection = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$collection) {
            return null;
        }

        $stmt = $this->conn->prepare(
            "SELECT d.quantity, p.pro_id, p.name, p.price,
                    p.quantity AS stock, p.status
             FROM collections_details d
             INNER JOIN product p ON p.pro_id = d.pro_id
             WHERE d.collection_id = :id
             ORDER BY d.id ASC"
        );
        $stmt->execute([":id" => $collectionId]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$products) {
            return null;
        }

        return [
            "collection" => $collection,
            "products" => $products,
            "pricing" => Collection::pricing($collection, $products)
        ];
    }

    // Insert a new basket line or add to an existing one
    private function addLine(int $userId, string $column, int $id, int $quantity, float $price, int $maxQuantity): array
    {
        $cartId = $this->getCartId($userId, true);

        $stmt = $this->conn->prepare(
            "SELECT cart_item_id, quantity
             FROM cart_items
             WHERE cart_id = :cart_id AND {$column} = :id
             LIMIT 1"
        );
        $stmt->execute([":cart_id" => $cartId, ":id" => $id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        $newQuantity = $quantity + ($existing ? (int) $existing["quantity"] : 0);

        if ($newQuantity > $maxQuantity) {
            return [false, "Only {$maxQuantity} available in stock."];
        }

        if ($existing) {
            $stmt = $this->conn->prepare(
                "UPDATE cart_items
                 SET quantity = :quantity, unit_price_at_purchase = :price
                 WHERE cart_item_id = :id"
            );
            $stmt->execute([
                ":quantity" => $newQuantity,
                ":price" => $price,
                ":id" => $existing["cart_item_id"]
            ]);
        } else {
            $stmt = $this->conn->prepare(
                "INSERT INTO cart_items (cart_id, {$column}, quantity, unit_price_at_purchase)
                 VALUES (:cart_id, :id, :quantity, :price)"
            );
            $stmt->execute([
                ":cart_id" => $cartId,
                ":id" => $id,
                ":quantity" => $newQuantity,
                ":price" => $price
            ]);
        }

        return [true, "Added to your basket."];
    }

    // Add one product to the basket. Returns [success, message]
    public function addItem(int $userId, int $productId, int $quantity = 1): array
    {
        $stmt = $this->conn->prepare(
            "SELECT pro_id, name, price, quantity
             FROM product
             WHERE pro_id = :id AND status = 'active'
             LIMIT 1"
        );
        $stmt->execute([":id" => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return [false, "This product is not available."];
        }

        if ((int) $product["quantity"] < 1) {
            return [false, "This product is out of stock."];
        }

        return $this->addLine($userId, "pro_id", $productId, $quantity, (float) $product["price"], (int) $product["quantity"]);
    }

    // Add one collection (set) to the basket. Returns [success, message]
    public function addCollection(int $userId, int $collectionId, int $quantity = 1): array
    {
        $parts = $this->getCollectionParts($collectionId);

        if (!$parts) {
            return [false, "This package is not available."];
        }

        $sets = (int) $parts["pricing"]["available_sets"];

        if ($sets < 1) {
            return [false, "This package is out of stock."];
        }

        return $this->addLine($userId, "collection_id", $collectionId, $quantity, (float) $parts["pricing"]["price"], $sets);
    }

    // Basket lines (products and collections) with current price and stock
    public function getItems(int $userId): array
    {
        $cartId = $this->getCartId($userId);

        if (!$cartId) {
            return [];
        }

        $stmt = $this->conn->prepare(
            "SELECT
                ci.cart_item_id,
                ci.pro_id,
                ci.collection_id,
                ci.quantity,
                p.name,
                p.price,
                p.quantity AS stock,
                c.name AS category,
                (
                    SELECT pi.image_url
                    FROM product_images pi
                    WHERE pi.pro_id = p.pro_id AND pi.is_primary = 1
                    ORDER BY pi.image_id ASC
                    LIMIT 1
                ) AS image_url
             FROM cart_items ci
             INNER JOIN product p ON p.pro_id = ci.pro_id
             LEFT JOIN categories c ON c.cat_id = p.cat_id
             WHERE ci.cart_id = :cart_id"
        );
        $stmt->execute([":cart_id" => $cartId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->conn->prepare(
            "SELECT cart_item_id, collection_id, quantity
             FROM cart_items
             WHERE cart_id = :cart_id AND collection_id IS NOT NULL"
        );
        $stmt->execute([":cart_id" => $cartId]);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $line) {
            $parts = $this->getCollectionParts((int) $line["collection_id"]);

            if (!$parts) {
                // The collection was hidden after it was added: drop the line
                $this->removeItem($userId, (int) $line["cart_item_id"]);
                continue;
            }

            $items[] = [
                "cart_item_id" => $line["cart_item_id"],
                "pro_id" => null,
                "collection_id" => $line["collection_id"],
                "quantity" => $line["quantity"],
                "name" => $parts["collection"]["name"],
                "price" => $parts["pricing"]["price"],
                "stock" => $parts["pricing"]["available_sets"],
                "category" => "Package",
                "image_url" => $parts["collection"]["image"],
                "includes" => array_map(
                    static fn(array $p): string => $p["name"] . ((int) $p["quantity"] > 1 ? " × " . (int) $p["quantity"] : ""),
                    $parts["products"]
                )
            ];
        }

        usort($items, static fn(array $a, array $b): int => (int) $a["cart_item_id"] <=> (int) $b["cart_item_id"]);

        return $items;
    }

    // Number of units in the basket (for the bag icon)
    public function countItems(int $userId): int
    {
        $stmt = $this->conn->prepare(
            "SELECT COALESCE(SUM(ci.quantity), 0)
             FROM cart c
             INNER JOIN cart_items ci ON ci.cart_id = c.cart_id
             WHERE c.user_id = :user_id AND c.status = 'cart'"
        );
        $stmt->execute([":user_id" => $userId]);

        return (int) $stmt->fetchColumn();
    }

    // Update quantities: [cart_item_id => quantity]. Quantity 0 removes the line.
    public function updateQuantities(int $userId, array $quantities): void
    {
        $cartId = $this->getCartId($userId);

        if (!$cartId) {
            return;
        }

        foreach ($this->getItems($userId) as $item) {
            $id = (int) $item["cart_item_id"];

            if (!isset($quantities[$id])) {
                continue;
            }

            $quantity = (int) $quantities[$id];

            if ($quantity < 1) {
                $this->removeItem($userId, $id);
                continue;
            }

            $quantity = min($quantity, max(1, (int) $item["stock"]));

            $stmt = $this->conn->prepare(
                "UPDATE cart_items
                 SET quantity = :quantity, unit_price_at_purchase = :price
                 WHERE cart_item_id = :id AND cart_id = :cart_id"
            );
            $stmt->execute([
                ":quantity" => $quantity,
                ":price" => $item["price"],
                ":id" => $id,
                ":cart_id" => $cartId
            ]);
        }
    }

    public function removeItem(int $userId, int $cartItemId): void
    {
        $cartId = $this->getCartId($userId);

        if (!$cartId) {
            return;
        }

        $stmt = $this->conn->prepare(
            "DELETE FROM cart_items
             WHERE cart_item_id = :id AND cart_id = :cart_id"
        );
        $stmt->execute([":id" => $cartItemId, ":cart_id" => $cartId]);
    }

    // Orders of a customer (every cart that is not the open basket), newest first
    public function getOrders(int $userId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT
                c.cart_id,
                c.created_at,
                c.total_price,
                c.status,
                COALESCE(SUM(ci.quantity), 0) AS units,
                GROUP_CONCAT(
                    CONCAT(COALESCE(p.name, col.name), IF(ci.quantity > 1, CONCAT(' × ', ci.quantity), ''))
                    ORDER BY ci.cart_item_id SEPARATOR ', '
                ) AS summary
             FROM cart c
             LEFT JOIN cart_items ci ON ci.cart_id = c.cart_id
             LEFT JOIN product p ON p.pro_id = ci.pro_id
             LEFT JOIN collections col ON col.collection_id = ci.collection_id
             WHERE c.user_id = :user_id AND c.status <> 'cart'
             GROUP BY c.cart_id, c.created_at, c.total_price, c.status
             ORDER BY c.created_at DESC, c.cart_id DESC"
        );
        $stmt->execute([":user_id" => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Saved details of the customer, used to pre-fill the checkout form
    public function getCustomer(int $userId): array
    {
        $stmt = $this->conn->prepare(
            "SELECT full_name, email, phone, address
             FROM users
             WHERE user_id = :id
             LIMIT 1"
        );
        $stmt->execute([":id" => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Turn the basket into an order. Returns [success, message, orderId]
    public function placeOrder(int $userId, array $delivery): array
    {
        $this->conn->beginTransaction();

        try {
            $stmt = $this->conn->prepare(
                "SELECT cart_id
                 FROM cart
                 WHERE user_id = :user_id AND status = 'cart'
                 ORDER BY cart_id DESC
                 LIMIT 1
                 FOR UPDATE"
            );
            $stmt->execute([":user_id" => $userId]);
            $cartId = (int) $stmt->fetchColumn();

            if (!$cartId) {
                $this->conn->rollBack();
                return [false, "Your basket is empty.", null];
            }

            $stmt = $this->conn->prepare(
                "SELECT cart_item_id, pro_id, collection_id, quantity
                 FROM cart_items
                 WHERE cart_id = :cart_id
                 FOR UPDATE"
            );
            $stmt->execute([":cart_id" => $cartId]);
            $lines = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$lines) {
                $this->conn->rollBack();
                return [false, "Your basket is empty.", null];
            }

            // Lock every product involved (in id order) so stock cannot change
            $productIds = [];

            foreach ($lines as $line) {
                if ($line["collection_id"] !== null) {
                    $parts = $this->getCollectionParts((int) $line["collection_id"]);

                    foreach ($parts["products"] ?? [] as $product) {
                        $productIds[(int) $product["pro_id"]] = true;
                    }
                } else {
                    $productIds[(int) $line["pro_id"]] = true;
                }
            }

            $productIds = array_keys($productIds);
            sort($productIds);

            if ($productIds) {
                $marks = implode(",", array_fill(0, count($productIds), "?"));
                $stmt = $this->conn->prepare(
                    "SELECT pro_id FROM product WHERE pro_id IN ({$marks}) ORDER BY pro_id FOR UPDATE"
                );
                $stmt->execute($productIds);
            }

            // Fresh prices and stock, now that the rows are locked
            $need = $status = $stock = $names = [];
            $linePrices = [];
            $total = 0.0;

            foreach ($lines as $line) {
                $quantity = (int) $line["quantity"];

                if ($line["collection_id"] !== null) {
                    $parts = $this->getCollectionParts((int) $line["collection_id"]);

                    if (!$parts) {
                        $this->conn->rollBack();
                        return [false, "A package in your basket is no longer available. Please update your basket.", null];
                    }

                    $name = $parts["collection"]["name"];
                    $price = (float) $parts["pricing"]["price"];

                    foreach ($parts["products"] as $product) {
                        $id = (int) $product["pro_id"];
                        $need[$id] = ($need[$id] ?? 0) + $quantity * (int) $product["quantity"];
                        // Products inside a collection are checked by stock only
                        $stock[$id] = (int) $product["stock"];
                        $names[$id] = $product["name"];
                    }
                } else {
                    $stmt = $this->conn->prepare(
                        "SELECT pro_id, name, price, quantity, status FROM product WHERE pro_id = :id"
                    );
                    $stmt->execute([":id" => $line["pro_id"]]);
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!$product) {
                        $this->conn->rollBack();
                        return [false, "A product in your basket is no longer available. Please update your basket.", null];
                    }

                    $id = (int) $product["pro_id"];
                    $name = $product["name"];
                    $price = (float) $product["price"];
                    $need[$id] = ($need[$id] ?? 0) + $quantity;
                    $status[$id] = $product["status"];
                    $stock[$id] = (int) $product["quantity"];
                    $names[$id] = $name;
                }

                $linePrices[(int) $line["cart_item_id"]] = $price;
                $total += $price * $quantity;
            }

            foreach ($need as $id => $units) {
                if (($status[$id] ?? "active") !== "active" || $stock[$id] < $units) {
                    $this->conn->rollBack();
                    return [false, $names[$id] . " is no longer available in that quantity. Please update your basket.", null];
                }
            }

            $updateItem = $this->conn->prepare(
                "UPDATE cart_items SET unit_price_at_purchase = :price WHERE cart_item_id = :id"
            );

            foreach ($linePrices as $itemId => $price) {
                $updateItem->execute([":price" => number_format($price, 2, ".", ""), ":id" => $itemId]);
            }

            $updateStock = $this->conn->prepare(
                "UPDATE product
                 SET quantity = quantity - :units_out,
                     count_selling = count_selling + :units_sold
                 WHERE pro_id = :id"
            );

            foreach ($need as $id => $units) {
                $updateStock->execute([":units_out" => $units, ":units_sold" => $units, ":id" => $id]);
            }

            $stmt = $this->conn->prepare(
                "UPDATE cart
                 SET status = 'pending',
                     total_price = :total,
                     delivery_fee = 0,
                     delivery_address_at_order = :address,
                     delivery_name = :name,
                     delivery_phone = :phone,
                     payment_method = 'cash_on_delivery',
                     created_at = NOW()
                 WHERE cart_id = :cart_id"
            );
            $stmt->execute([
                ":total" => number_format($total, 2, ".", ""),
                ":address" => $delivery["address"],
                ":name" => $delivery["name"],
                ":phone" => $delivery["phone"],
                ":cart_id" => $cartId
            ]);

            $this->conn->commit();

            return [true, "Your order has been placed.", $cartId];
        } catch (Throwable $exception) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            error_log("Nabta place order error: " . $exception->getMessage());

            return [false, "We could not place your order. Please try again.", null];
        }
    }
}
