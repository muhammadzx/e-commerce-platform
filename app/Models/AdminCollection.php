<?php
declare(strict_types=1);
require_once __DIR__ . '/Collection.php';

final class AdminCollection
{
    public function __construct(private PDO $db) {}

    public function products(int $packageId = 0): array
    {
        $stmt = $this->db->prepare("SELECT p.pro_id, p.name, p.status, p.price, p.quantity AS stock, c.name AS category,
            (SELECT image_url FROM product_images i WHERE i.pro_id=p.pro_id ORDER BY is_primary DESC, image_id ASC LIMIT 1) AS image_url
            FROM product p LEFT JOIN categories c ON c.cat_id=p.cat_id
            WHERE p.status='active' OR p.pro_id IN (SELECT pro_id FROM collections_details WHERE collection_id=:package_id)
            ORDER BY p.name, p.pro_id");
        $stmt->execute(['package_id'=>$packageId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM collections WHERE collection_id=? AND status <> 'deleted'");
        $stmt->execute([$id]);
        $package = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$package) return null;
        $stmt = $this->db->prepare('SELECT pro_id,quantity FROM collections_details WHERE collection_id=? ORDER BY id');
        $stmt->execute([$id]);
        $package['items'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        return $package;
    }

    public function all(): array
    {
        $collections = $this->db->query("SELECT * FROM collections WHERE status <> 'deleted' ORDER BY collection_id DESC")->fetchAll(PDO::FETCH_ASSOC);
        $details = $this->db->query('SELECT d.*, p.name, p.price, p.quantity AS stock, p.status,
            (SELECT image_url FROM product_images i WHERE i.pro_id=p.pro_id ORDER BY is_primary DESC, image_id ASC LIMIT 1) AS image_url
            FROM collections_details d JOIN product p ON p.pro_id=d.pro_id ORDER BY d.id')->fetchAll(PDO::FETCH_ASSOC);
        $grouped = [];
        foreach ($details as $detail) $grouped[(int)$detail['collection_id']][] = $detail;
        foreach ($collections as &$collection) {
            $collection['products'] = $grouped[(int)$collection['collection_id']] ?? [];
            $collection = array_merge($collection, Collection::pricing($collection, $collection['products']));
            foreach ($collection['products'] as $product) if ($product['status'] !== 'active') $collection['available_sets'] = 0;
        }
        unset($collection);
        return $collections;
    }

    public static function validate(array $input): array
    {
        $name = is_string($input['name'] ?? null) ? trim($input['name']) : '';
        $description = is_string($input['description'] ?? null) ? trim($input['description']) : '';
        $discount = filter_var($input['discount'] ?? '', FILTER_VALIDATE_FLOAT);
        $status = $input['status'] ?? '';
        if (mb_strlen($name) < 2 || mb_strlen($name) > 150) throw new InvalidArgumentException('Package name must contain 2 to 150 characters.');
        if (mb_strlen($description) > 5000) throw new InvalidArgumentException('Description must not exceed 5000 characters.');
        if ($discount === false || !is_finite($discount) || $discount < 0 || $discount > 99) throw new InvalidArgumentException('Discount must be between 0 and 99 percent.');
        if (!in_array($status, ['active','inactive'], true)) throw new InvalidArgumentException('Choose a valid visibility.');
        $ids = $input['selected'] ?? [];
        $quantities = $input['quantities'] ?? [];
        if (!is_array($ids) || !$ids || count($ids) > 100 || !is_array($quantities)) throw new InvalidArgumentException('Select at least one product, up to 100 products.');
        $items = [];
        foreach ($ids as $rawId) {
            $id = filter_var($rawId, FILTER_VALIDATE_INT);
            $qty = $id ? filter_var($quantities[$id] ?? '', FILTER_VALIDATE_INT) : false;
            if (!$id || $id < 1 || !$qty || $qty < 1 || $qty > 999) throw new InvalidArgumentException('Each selected product needs a quantity from 1 to 999.');
            if (isset($items[$id])) throw new InvalidArgumentException('A product can only be selected once.');
            $items[$id] = $qty;
        }
        return ['name'=>$name,'description'=>$description,'discount'=>round($discount,2),'status'=>$status,'items'=>$items];
    }

    public function create(array $data, ?string $image = null): int
    {
        $ownsTransaction = !$this->db->inTransaction();
        if ($ownsTransaction) $this->db->beginTransaction();
        try {
            $ids = array_keys($data['items']);
            $stmt = $this->db->prepare('SELECT pro_id FROM product WHERE status=\'active\' AND pro_id IN (' . implode(',', array_fill(0,count($ids),'?')) . ') ORDER BY pro_id FOR UPDATE');
            $stmt->execute($ids);
            if (count($stmt->fetchAll()) !== count($ids)) throw new InvalidArgumentException('A selected product is no longer available. Refresh the page and select active products.');
            $stmt = $this->db->prepare('INSERT INTO collections (name,description,discount,image,status) VALUES (:name,:description,:discount,:image,:status)');
            $stmt->execute(['name'=>$data['name'],'description'=>$data['description'],'discount'=>$data['discount'],'image'=>$image,'status'=>$data['status']]);
            $id = (int)$this->db->lastInsertId();
            $stmt = $this->db->prepare('INSERT INTO collections_details (collection_id,pro_id,quantity) VALUES (?,?,?)');
            foreach ($data['items'] as $productId=>$quantity) $stmt->execute([$id,$productId,$quantity]);
            if ($ownsTransaction) $this->db->commit();
            return $id;
        } catch (Throwable $error) {
            if ($ownsTransaction && $this->db->inTransaction()) $this->db->rollBack();
            throw $error;
        }
    }

    public function update(int $id, array $data, ?string $image): void
    {
        $ownsTransaction = !$this->db->inTransaction();
        if ($ownsTransaction) $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("SELECT collection_id FROM collections WHERE collection_id=? AND status <> 'deleted' FOR UPDATE");
            $stmt->execute([$id]);
            if (!$stmt->fetchColumn()) throw new InvalidArgumentException('This package no longer exists.');
            $stmt = $this->db->prepare('SELECT pro_id FROM collections_details WHERE collection_id=?');
            $stmt->execute([$id]);
            $existingIds = array_map('intval', $stmt->fetchAll(PDO::FETCH_COLUMN));
            $ids = array_keys($data['items']);
            $stmt = $this->db->prepare('SELECT pro_id,status FROM product WHERE pro_id IN (' . implode(',',array_fill(0,count($ids),'?')) . ') ORDER BY pro_id FOR UPDATE');
            $stmt->execute($ids);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($products) !== count($ids)) throw new InvalidArgumentException('A selected product no longer exists. Refresh the page and try again.');
            foreach ($products as $product) {
                if ($product['status'] !== 'active' && (!in_array((int)$product['pro_id'],$existingIds,true) || $data['status'] === 'active')) {
                    throw new InvalidArgumentException('Remove or replace inactive products before publishing. You can keep them when saving the package as hidden.');
                }
            }
            $stmt = $this->db->prepare('UPDATE collections SET name=:name,description=:description,discount=:discount,image=:image,status=:status WHERE collection_id=:id');
            $stmt->execute(['name'=>$data['name'],'description'=>$data['description'],'discount'=>$data['discount'],'image'=>$image,'status'=>$data['status'],'id'=>$id]);
            $stmt = $this->db->prepare('DELETE FROM collections_details WHERE collection_id=?');
            $stmt->execute([$id]);
            $stmt = $this->db->prepare('INSERT INTO collections_details (collection_id,pro_id,quantity) VALUES (?,?,?)');
            foreach ($data['items'] as $productId=>$quantity) $stmt->execute([$id,$productId,$quantity]);
            if ($ownsTransaction) $this->db->commit();
        } catch (Throwable $error) {
            if ($ownsTransaction && $this->db->inTransaction()) $this->db->rollBack();
            throw $error;
        }
    }

    public function delete(int $id): bool
    {
        // Keep foreign keys, purchased prices and historical order records intact.
        $stmt = $this->db->prepare("UPDATE collections SET status='deleted' WHERE collection_id=? AND status <> 'deleted'");
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}
