<?php

// A collection is a set of products (collections_details) sold together
// with a percentage discount. Price = sum of its products - discount.
class Collection
{
    private PDO $conn;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    // Active collections with their products, prices and how many sets are in stock
    public function getActive(): array
    {
        $stmt = $this->conn->prepare(
            "SELECT collection_id, name, description, discount, image
             FROM collections
             WHERE status = 'active'
             ORDER BY collection_id DESC"
        );
        $stmt->execute();
        $collections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$collections) {
            return [];
        }

        $stmt = $this->conn->prepare(
            "SELECT d.collection_id, d.quantity, p.pro_id, p.name, p.price,
                    p.quantity AS stock, p.status
             FROM collections_details d
             INNER JOIN product p ON p.pro_id = d.pro_id
             ORDER BY d.id ASC"
        );
        $stmt->execute();

        $byCollection = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $byCollection[(int) $row["collection_id"]][] = $row;
        }

        foreach ($collections as &$collection) {
            $products = $byCollection[(int) $collection["collection_id"]] ?? [];

            $collection["products"] = $products;
            $collection = array_merge($collection, self::pricing($collection, $products));
        }
        unset($collection);

        return array_values(array_filter(
            $collections,
            static fn(array $c): bool => !empty($c["products"])
        ));
    }

    // Prices and available sets from a collection row and its products
    public static function pricing(array $collection, array $products): array
    {
        $original = 0.0;
        $available = PHP_INT_MAX;

        foreach ($products as $product) {
            $qty = max(1, (int) $product["quantity"]);

            $original += (float) $product["price"] * $qty;

            // Only the stock matters: a set with 0 available cannot be bought
            $sets = intdiv((int) $product["stock"], $qty);

            $available = min($available, $sets);
        }

        $discount = (float) $collection["discount"];
        $price = round($original * (1 - $discount / 100), 2);

        return [
            "original_price" => round($original, 2),
            "price" => $price,
            "saving" => round($original - $price, 2),
            "available_sets" => $products ? $available : 0
        ];
    }
}
