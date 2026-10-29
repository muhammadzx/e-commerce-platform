<?php

class Dashboard{
private $db;
public function __construct(PDO $db){
$this->db=$db;
}

public function getAdminData($id){
$sql ="SELECT `full_name`,`role` FROM `users` WHERE user_id = ?";
$stmt = $this->db->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch();
return $user;
}

public function getOverviewStats()
{
    $today = date('Y-m-d');

    $salesSql = "SELECT COALESCE(SUM(total_price), 0)
                 FROM cart
                 WHERE status = 'completed'
                 AND DATE(created_at) = ?";

    $salesStmt = $this->db->prepare($salesSql);
    $salesStmt->execute([$today]);
    $todaySales = (float) $salesStmt->fetchColumn();

    $ordersSql = "SELECT COUNT(*)
                  FROM cart
                  WHERE status IN ('pending', 'processing')";

    $ordersStmt = $this->db->prepare($ordersSql);
    $ordersStmt->execute();
    $ordersInMotion = (int) $ordersStmt->fetchColumn();

    $productsSql = "SELECT
                        COALESCE(SUM(count_selling), 0) AS units_sold,
                        COUNT(DISTINCT CASE
                            WHEN count_selling > 0 THEN cat_id
                        END) AS product_families,
                        SUM(CASE
                            WHEN status = 'active' THEN 1
                            ELSE 0
                        END) AS active_products
                    FROM product";

    $productsStmt = $this->db->prepare($productsSql);
    $productsStmt->execute();
    $products = $productsStmt->fetch(PDO::FETCH_ASSOC);

    return [
        'today_sales' => $todaySales,
        'orders_in_motion' => $ordersInMotion,
        'units_sold' => (int) $products['units_sold'],
        'product_families' => (int) $products['product_families'],
        'active_products' => (int) $products['active_products']
    ];
}
public function getWeeklySales(){
     $sql = "SELECT DATE(created_at) AS sale_date,
                   SUM(total_price) AS daily_sales
            FROM cart
            WHERE status = 'completed'
              AND created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
              AND created_at < DATE_ADD(CURDATE(), INTERVAL 1 DAY)
            GROUP BY DATE(created_at)
            ORDER BY sale_date";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getSalesByCategory()
{
    $sql = "SELECT categories.name AS category_name,
                   SUM(cart_items.unit_price_at_purchase * cart_items.quantity) AS category_sales
            FROM cart_items
            JOIN cart ON cart.cart_id = cart_items.cart_id
            JOIN product ON product.pro_id = cart_items.pro_id
            JOIN categories ON categories.cat_id = product.cat_id
            WHERE cart.status = 'completed'
            GROUP BY categories.name";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT COALESCE(SUM(cart_items.unit_price_at_purchase * cart_items.quantity), 0)
            FROM cart_items
            JOIN cart ON cart.cart_id = cart_items.cart_id
            WHERE cart.status = 'completed'
              AND cart_items.collection_id IS NOT NULL";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $collectionSales = (float) $stmt->fetchColumn();

    if ($collectionSales > 0) {
        $sales[] = [
            'category_name' => 'Collections',
            'category_sales' => $collectionSales
        ];
    }
    
    usort($sales, function ($a, $b) {
    return (float) $b['category_sales'] <=> (float) $a['category_sales'];
});

return $sales;
}

public function getTopSellingCategory()
{
    $categories = $this->getSalesByCategory();

    if (empty($categories)) {
        return null;
    }

    $topCategory = $categories[0];

    foreach ($categories as $category) {
        if ($category['category_sales'] > $topCategory['category_sales']) {
            $topCategory = $category;
        }
    }

    return $topCategory;
}
public function getDashboardNotes()
{
    $notes = [];

    $sql = "SELECT name, quantity
            FROM product
            WHERE status = 'active'
            ORDER BY quantity ASC
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $notes['lowest_stock'] = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT name, count_selling
            FROM product
            WHERE status = 'active'
            ORDER BY count_selling DESC
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $notes['best_seller'] = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT COUNT(*)
            FROM product
            WHERE status = 'active'
              AND quantity < 20";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $notes['low_stock_count'] = (int) $stmt->fetchColumn();

    return $notes;
}

public function getBestSellingItems()
{
    $productsSql = "SELECT
                        pro_id AS item_id,
                        name AS item_name,
                        'Product' AS item_type,
                        count_selling AS quantity_sold
                    FROM product
                    WHERE status = 'active'";

    $productsStmt = $this->db->prepare($productsSql);
    $productsStmt->execute();
    $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);


    $collectionsSql = "SELECT
                           collections.collection_id AS item_id,
                           collections.name AS item_name,
                           'Collection' AS item_type,
                           COALESCE(SUM(
                               CASE
                                   WHEN cart.status = 'completed'
                                   THEN cart_items.quantity
                                   ELSE 0
                               END
                           ), 0) AS quantity_sold
                       FROM collections
                       LEFT JOIN cart_items
                           ON cart_items.collection_id = collections.collection_id
                       LEFT JOIN cart
                           ON cart.cart_id = cart_items.cart_id
                       WHERE collections.status = 'active'
                       GROUP BY collections.collection_id, collections.name";

    $collectionsStmt = $this->db->prepare($collectionsSql);
    $collectionsStmt->execute();
    $collections = $collectionsStmt->fetchAll(PDO::FETCH_ASSOC);


    $items = array_merge($products, $collections);

    usort($items, function ($a, $b) {
        return (int) $b['quantity_sold'] <=> (int) $a['quantity_sold'];
    });

    return $items;
}

public function getOrdersByStatus()
{
    $sql = "SELECT status, COUNT(*) AS order_count
            FROM cart
            GROUP BY status
            ORDER BY order_count DESC";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}

// $db = new Dashboard($db);
// $db->getSalesByCategory();


?>