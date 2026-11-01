<?php
declare(strict_types=1);
final class AdminReview
{
    public function __construct(private PDO $db) {}
    public function all(string $query = '', int $rating = 0): array
    {
        $stmt = $this->db->prepare("SELECT r.*, u.full_name AS customer_name,
            COALESCE(p.name, c.name, 'Unavailable item') AS item_name,
            CASE WHEN r.pro_id IS NULL THEN 'Package' ELSE 'Product' END AS item_type
            FROM reviews r LEFT JOIN users u ON u.user_id = r.user_id
            LEFT JOIN product p ON p.pro_id = r.pro_id LEFT JOIN collections c ON c.collection_id = r.collection_id
            WHERE (:rating = 0 OR r.rating = :rating_value)
            AND (:empty_query = '' OR r.comment LIKE :comment OR u.full_name LIKE :customer OR p.name LIKE :product OR c.name LIKE :collection)
            ORDER BY r.created_at DESC, r.review_id DESC");
        $stmt->execute(['rating'=>$rating, 'rating_value'=>$rating, 'empty_query'=>$query,
            'comment'=>"%$query%", 'customer'=>"%$query%", 'product'=>"%$query%", 'collection'=>"%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function moderate(int $id, string $action): bool
    {
        if ($id < 1 || !in_array($action, ['hide','unhide','delete'], true)) return false;
        $stmt = $this->db->prepare($action === 'delete' ? 'DELETE FROM reviews WHERE review_id = :id' : 'UPDATE reviews SET is_hidden = :hidden WHERE review_id = :id');
        $values = ['id'=>$id];
        if ($action !== 'delete') $values['hidden'] = $action === 'hide' ? 1 : 0;
        $stmt->execute($values);
        return $stmt->rowCount() > 0;
    }
}
