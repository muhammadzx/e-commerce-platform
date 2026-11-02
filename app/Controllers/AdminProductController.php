<?php

require_once __DIR__ . '/../Models/AdminProduct.php';
require_once __DIR__ . '/../Models/ProductImage.php';
require_once __DIR__ . '/../Core/CloudinaryUploader.php';

class AdminProductController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productModel = new AdminProduct();
        $imageModel = new ProductImage();
        $message = $_SESSION['flash_message'] ?? '';
        $messageType = $_SESSION['flash_type'] ?? '';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            if ($action === 'hide') {
                $productId = $this->readId($_POST['product_id'] ?? '');
                $ok = $productId && $productModel->hideProduct($productId);
                $this->redirect($ok ? 'Product hidden successfully.' : 'Could not hide the product.', $ok ? 'success' : 'error');
            }

            if ($action === 'set_primary_image') {
                $productId = $this->readId($_POST['product_id'] ?? '');
                $imageId = $this->readId($_POST['image_id'] ?? '');
                $image = ($productId && $imageId) ? $imageModel->getImage($imageId, $productId) : false;
                $ok = $image && $imageModel->setPrimaryImage($productId, $imageId);
                $this->redirect($ok ? 'Primary image updated.' : 'Could not change the primary image.', $ok ? 'success' : 'error', $productId);
            }

            if ($action === 'delete_image') {
                $this->deleteProductImage($imageModel, $_POST);
            }

            if ($action === 'replace_image') {
                $this->replaceProductImage($imageModel, $_POST, $_FILES['replacement_image'] ?? []);
            }

            if ($action === 'add' || $action === 'update') {
                error_log(
    "NABTA UPLOAD DEBUG: " .
    print_r($_FILES, true)
);
                $productId = $this->readId($_POST['product_id'] ?? '');
                $catId = $this->readId($_POST['cat_id'] ?? '');
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
                $quantity = filter_var($_POST['quantity'] ?? '', FILTER_VALIDATE_INT);

                if (!$catId || $name === '' || $price === false || $price <= 0 ||
                    $quantity === false || $quantity < 0 ||
                    ($action === 'update' && !$productId)) {
                    $message = 'Please check the product information and try again.';
                    $messageType = 'error';
                } else {
                    if ($action === 'add') {
                        $imageProductId = $productModel->addProduct($catId, $name, $description, $price, $quantity);
                        $saved = $imageProductId !== false && $imageProductId > 0;
                        $successMessage = 'Product added successfully.';
                    } else {
                        $saved = $productModel->updateProduct($productId, $catId, $name, $description, $price, $quantity);
                        $imageProductId = $productId;
                        $successMessage = 'Product updated successfully.';
                    }

                    if ($saved) {
                        try {
                            $this->saveUploadedImages($imageModel, $imageProductId, $_FILES['images'] ?? []);
                            $this->redirect(
                                $successMessage,
                                'success',
                                $action === 'update' ? $productId : null
                            );
                        } catch (Throwable $error) {
                            error_log($error->getMessage());
                            $this->redirect(
                                'Product was saved, but an image could not be uploaded.',
                                'error',
                                $action === 'update' ? $productId : null
                            );
                        }
                    }

                    $message = 'The product could not be saved.';
                    $messageType = 'error';
                }
            }
        }

        $readFilter = static fn(string $key): string => is_string($_GET[$key] ?? null) ? trim($_GET[$key]) : '';
        $search = mb_substr($readFilter('search'), 0, 200);
        $filters = ['search'=>$search, 'category'=>max(0, (int)$readFilter('category')),
            'stock'=>$readFilter('stock'), 'sort'=>$readFilter('sort') ?: 'newest',
            'min_price'=>$readFilter('min_price'), 'max_price'=>$readFilter('max_price')];
        $filterError = '';
        foreach (['min_price','max_price'] as $key) {
            if ($filters[$key] !== '' && (!is_numeric($filters[$key]) || !is_finite((float)$filters[$key]) || (float)$filters[$key] < 0 || (float)$filters[$key] > 99999999.99)) {
                $filterError = 'Enter valid, non-negative prices.';
                $filters[$key] = '';
            }
        }
        if ($filters['min_price'] !== '' && $filters['max_price'] !== '' && (float)$filters['min_price'] > (float)$filters['max_price']) $filterError = 'Minimum price must not exceed maximum price.';
        if (!in_array($filters['stock'], ['', 'in', 'low', 'out'], true)) $filters['stock'] = '';
        if (!in_array($filters['sort'], ['newest','name','price_low','price_high','stock_low'], true)) $filters['sort'] = 'newest';
        $products = $filterError === '' ? $productModel->filterProducts($filters) : [];
        $categories = $productModel->getCategoriesForAdmin();

        $productImages = [];
        foreach ($products as $product) {
            $productId = (int) $product['pro_id'];
            $productImages[$productId] = $imageModel->getImagesByProductId($productId);
        }

        require __DIR__ . '/../Views/admin/products.php';
    }

    private function saveUploadedImages(ProductImage $imageModel, int $productId, array $files)
    {
        if (empty($files['name']) || !is_array($files['name']) || !isset($files['error'])) {
            return;
        }

        $hasUpload = false;
        foreach ($files['error'] as $errorCode) {
            if ($errorCode !== UPLOAD_ERR_NO_FILE) {
                $hasUpload = true;
                break;
            }
        }
        if (!$hasUpload) {
            return;
        }

        $uploader = new CloudinaryUploader();
        $isPrimary = empty($imageModel->getImagesByProductId($productId));

        foreach ($files['name'] as $index => $name) {
            $errorCode = $files['error'][$index] ?? UPLOAD_ERR_NO_FILE;
            if ($errorCode === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $file = [
                'name' => $name,
                'type' => $files['type'][$index] ?? '',
                'tmp_name' => $files['tmp_name'][$index] ?? '',
                'error' => $errorCode,
                'size' => $files['size'][$index] ?? 0
            ];

            $uploaded = $uploader->uploadImage($file);
            if (!$imageModel->addImage($productId, $uploaded['image_url'], $uploaded['public_id'], $isPrimary)) {
                $uploader->deleteImage($uploaded['public_id']);
                throw new RuntimeException('Could not save the uploaded image record.');
            }
            $isPrimary = false;
        }
    }

    private function deleteProductImage(ProductImage $imageModel, array $post)
    {
        $productId = $this->readId($post['product_id'] ?? '');
        $imageId = $this->readId($post['image_id'] ?? '');
        $image = ($productId && $imageId) ? $imageModel->getImage($imageId, $productId) : false;

        if (!$image) {
            $this->redirect('Image not found.', 'error', $productId);
        }

        if (!empty($image['cloudinary_public_id'])) {
            $uploader = new CloudinaryUploader();
            if (!$uploader->deleteImage($image['cloudinary_public_id'])) {
                $this->redirect('Could not delete the image from Cloudinary.', 'error', $productId);
            }
        }

        if (!$imageModel->deleteImageRecord($imageId, $productId)) {
            $this->redirect('Could not remove the image record.', 'error', $productId);
        }

        if ((int) $image['is_primary'] === 1) {
            $remaining = $imageModel->getImagesByProductId($productId);
            if (!empty($remaining)) {
                $imageModel->setPrimaryImage($productId, (int) $remaining[0]['image_id']);
            }
        }

        $this->redirect('Image removed successfully.', 'success', $productId);
    }

    private function replaceProductImage(ProductImage $imageModel, array $post, array $file)
    {
        $productId = $this->readId($post['product_id'] ?? '');
        $imageId = $this->readId($post['image_id'] ?? '');
        $oldImage = ($productId && $imageId) ? $imageModel->getImage($imageId, $productId) : false;

        if (!$oldImage || empty($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $this->redirect('Choose a valid replacement image.', 'error', $productId);
        }

        $uploader = new CloudinaryUploader();
        try {
            $newImage = $uploader->uploadImage($file);
        } catch (Throwable $error) {
            error_log($error->getMessage());
            $this->redirect('Could not upload the replacement image.', 'error', $productId);
        }

        $updated = $imageModel->updateImage($imageId, $productId, $newImage['image_url'], $newImage['public_id']);
        if (!$updated) {
            $uploader->deleteImage($newImage['public_id']);
            $this->redirect('Could not replace the image record.', 'error', $productId);
        }

        $oldDeleted = empty($oldImage['cloudinary_public_id']) || $uploader->deleteImage($oldImage['cloudinary_public_id']);
        $this->redirect(
            $oldDeleted ? 'Image replaced successfully.' : 'Image replaced, but the old Cloudinary image could not be removed.',
            $oldDeleted ? 'success' : 'error',
            $productId
        );
    }

    private function readId($value)
    {
        $id = filter_var($value, FILTER_VALIDATE_INT);
        return $id !== false && $id > 0 ? $id : false;
    }

    private function redirect($message, $type, $editProductId = null)
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
        $destination = 'products.php';
        if (is_int($editProductId) && $editProductId > 0) {
            $destination .= '?edit_product=' . $editProductId;
        }
        header('Location: ' . $destination);
        exit;
    }
}
