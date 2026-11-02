<?php
declare(strict_types=1);
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';
require_once __DIR__ . '/../../app/Core/AdminSupport.php';
require_once __DIR__ . '/../../app/Models/AdminCollection.php';
require_once __DIR__ . '/../../app/Core/CloudinaryUploader.php';
$adminUser = require_admin_access();
require __DIR__ . '/../../config/connection.php';
$model = new AdminCollection($db);
$editId = !empty($isEditRoute) ? (int)filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT) : 0;
$isEditing = !empty($isEditRoute);
$existing = $isEditing ? $model->find($editId) : null;
if ($isEditing && !$existing) {
    AdminSupport::flash('error','Package not found.');
    AdminSupport::redirect(nabta_public_url('admin/collections.php'));
}
$products = $model->products($editId);
$error = '';
$old = ['name'=>'','description'=>'','discount'=>'0','status'=>'active','selected'=>[],'quantities'=>[]];
if ($existing) $old = ['name'=>$existing['name'],'description'=>$existing['description'] ?? '', 'discount'=>$existing['discount'], 'status'=>$existing['status'], 'selected'=>array_keys($existing['items']), 'quantities'=>$existing['items']];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['name','description','discount','status'] as $key) $old[$key] = is_string($_POST[$key] ?? null) ? $_POST[$key] : '';
    $old['selected'] = is_array($_POST['selected'] ?? null) ? array_filter($_POST['selected'], 'is_scalar') : [];
    $old['quantities'] = is_array($_POST['quantities'] ?? null) ? array_filter($_POST['quantities'], 'is_scalar') : [];
    $uploaded = null;
    $uploader = null;
    try {
        if (!AdminSupport::verifyCsrf()) throw new InvalidArgumentException('Your session expired. Please try again.');
        $data = AdminCollection::validate($_POST);
        $validIds = array_map('intval', array_column($products,'pro_id'));
        if (array_diff(array_keys($data['items']),$validIds)) throw new InvalidArgumentException('Choose active products from the list.');
        $file = $_FILES['image'] ?? null;
        if ($file && ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
            $uploader = new CloudinaryUploader();
            $uploaded = $uploader->uploadImage($file);
        }
        $image = $uploaded['image_url'] ?? (!empty($_POST['remove_image']) ? null : ($existing['image'] ?? null));
        if ($isEditing) { $model->update($editId,$data,$image); $id=$editId; }
        else $id = $model->create($data,$image);
        AdminSupport::flash('success', 'Package' . ($isEditing ? ' updated successfully.' : ' created successfully.') . ($data['status'] === 'active' ? ' It is now visible in the storefront.' : ' It is saved as hidden.'));
        AdminSupport::redirect(nabta_public_url('admin/collections.php'));
    } catch (InvalidArgumentException $exception) {
        $error = $exception->getMessage();
    } catch (Throwable $exception) {
        error_log('Package save failed: ' . $exception->getMessage());
        $error = $uploaded === null && $uploader !== null ? 'The image could not be uploaded. Use JPG, PNG or WebP up to 5 MB and try again.' : 'The package could not be saved. Your entries are kept below; please try again.';
    }
    if ($uploaded && $uploader) $uploader->deleteImage($uploaded['public_id']);
}
$csrfToken = AdminSupport::csrfToken();
require __DIR__ . '/../../app/Views/admin/collection-create.php';
