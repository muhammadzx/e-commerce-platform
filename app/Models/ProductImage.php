<?php

class ProductImage
{
    private PDO $conn;

    public function __construct()
    {
        require_once __DIR__ . '/../Core/Database.php';
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getImagesByProductId($productId)
    {
        $sql = "SELECT image_id, pro_id, image_url, cloudinary_public_id, is_primary
                FROM product_images
                WHERE pro_id = ?
                ORDER BY is_primary DESC, image_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImage($imageId, $productId)
    {
        $sql = "SELECT image_id, pro_id, image_url, cloudinary_public_id, is_primary
                FROM product_images
                WHERE image_id = ? AND pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$imageId, $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addImage($productId, $imageUrl, $publicId, $isPrimary)
    {
        $sql = "INSERT INTO product_images
                    (pro_id, image_url, cloudinary_public_id, is_primary)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $productId,
            $imageUrl,
            $publicId,
            $isPrimary ? 1 : 0
        ]);
    }

    public function updateImage($imageId, $productId, $imageUrl, $publicId)
    {
        $sql = "UPDATE product_images
                SET image_url = ?, cloudinary_public_id = ?
                WHERE image_id = ? AND pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$imageUrl, $publicId, $imageId, $productId]);
    }

    public function setPrimaryImage($productId, $imageId)
    {
        $sql = "UPDATE product_images
                SET is_primary = CASE WHEN image_id = ? THEN 1 ELSE 0 END
                WHERE pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$imageId, $productId]);
    }

    public function deleteImageRecord($imageId, $productId)
    {
        $sql = "DELETE FROM product_images
                WHERE image_id = ? AND pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$imageId, $productId]);
    }
}
