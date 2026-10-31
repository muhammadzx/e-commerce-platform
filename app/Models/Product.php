<?php

require_once __DIR__ . "/../Core/Database.php";

class Product
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Get all active products (with their category name)
    public function getAllProducts()
    {
        $sql = "SELECT
                    p.pro_id,
                    p.cat_id,
                    c.name AS category,
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
                LEFT JOIN categories c ON c.cat_id = p.cat_id
                WHERE p.status = 'active'
                ORDER BY p.pro_id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one product by its ID (with its category name)
    public function getProductById($id)
    {
        $sql = "SELECT
                    p.pro_id,
                    p.cat_id,
                    c.name AS category,
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
                LEFT JOIN categories c ON c.cat_id = p.cat_id
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













    // Get paginated products with search, category and sorting
public function getPaginatedProducts(
    int $limit,
    int $offset,
    string $search = "",
    string $category = "all",
    string $sort = "default"
) {
    $sql = "SELECT
                p.pro_id,
                p.cat_id,
                c.name AS category,
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
            LEFT JOIN categories c ON c.cat_id = p.cat_id
            WHERE p.status = 'active'";

    $params = [];

    if ($search !== "") {
        $sql .= " AND (
            p.name LIKE :search_name
            OR p.description LIKE :search_description
        )";

        $params[":search_name"] = "%$search%";
        $params[":search_description"] = "%$search%";
    }

    if ($category !== "all") {
        $sql .= " AND c.name = :category";
        $params[":category"] = $category;
    }

    switch ($sort) {
        case "price-low":
            $sql .= " ORDER BY p.price ASC, p.pro_id DESC";
            break;

        case "price-high":
            $sql .= " ORDER BY p.price DESC, p.pro_id DESC";
            break;

        case "name":
            $sql .= " ORDER BY p.name ASC, p.pro_id DESC";
            break;

        default:
            $sql .= " ORDER BY p.pro_id DESC";
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $this->conn->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }

    $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Count active products matching filters
public function countProducts(
    string $search = "",
    string $category = "all"
) {
    $sql = "SELECT COUNT(*)
            FROM product p
            LEFT JOIN categories c ON c.cat_id = p.cat_id
            WHERE p.status = 'active'";

    $params = [];

    if ($search !== "") {
        $sql .= " AND (
            p.name LIKE :search_name
            OR p.description LIKE :search_description
        )";

        $params[":search_name"] = "%$search%";
        $params[":search_description"] = "%$search%";
    }

    if ($category !== "all") {
        $sql .= " AND c.name = :category";
        $params[":category"] = $category;
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    return (int) $stmt->fetchColumn();
}






// Get categories that contain active products
public function getAllCategories()
{
    $sql = "SELECT DISTINCT c.name
            FROM categories c
            INNER JOIN product p ON p.cat_id = c.cat_id
            WHERE p.status = 'active'
            ORDER BY c.name ASC";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




public function getProductImages(int $productId)
{
    $sql = "SELECT image_id, image_url, is_primary
            FROM product_images
            WHERE pro_id = :product_id
            ORDER BY is_primary DESC, image_id ASC";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ":product_id" => $productId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}














public function getFrequentlyBoughtTogether(
    int $productId,
    int $limit = 3
): array {

    $sql = "
        SELECT
            p.*,
            COUNT(DISTINCT ci2.cart_id) AS times_bought_together

        FROM cart_items ci1

        JOIN cart c
            ON c.cart_id = ci1.cart_id

        JOIN cart_items ci2
            ON ci2.cart_id = ci1.cart_id

        JOIN product p
            ON p.pro_id = ci2.pro_id

        WHERE ci1.pro_id = :product_id
            AND ci2.pro_id <> :exclude_id
            AND c.status = 'completed'
            AND p.status = 'active'
            AND p.quantity > 0

        GROUP BY p.pro_id

        ORDER BY
            times_bought_together DESC,
            p.pro_id ASC

        LIMIT :limit
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindValue(
        ':product_id',
        $productId,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':exclude_id',
        $productId,
        PDO::PARAM_INT
    );

    $stmt->bindValue(
        ':limit',
        $limit,
        PDO::PARAM_INT
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}