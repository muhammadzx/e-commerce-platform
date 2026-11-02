<?php
declare(strict_types=1);
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';
require_once __DIR__ . '/../../app/Core/AdminSupport.php';
require_once __DIR__ . '/../../app/Models/AdminCollection.php';
$adminUser = require_admin_access();
require __DIR__ . '/../../config/connection.php';
$model = new AdminCollection($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!AdminSupport::verifyCsrf()) AdminSupport::flash('error', 'Your session expired. Refresh and try again.');
    elseif (($_POST['action'] ?? '') === 'delete') {
        try {
            $id = filter_var($_POST['package_id'] ?? 0,FILTER_VALIDATE_INT);
            $ok = $id && $id > 0 && $model->delete($id);
            AdminSupport::flash($ok ? 'success' : 'error', $ok ? 'Package removed. Existing order records have been preserved.' : 'Package not found.');
        } catch (Throwable $exception) {
            error_log('Package deletion failed: '.$exception->getMessage());
            AdminSupport::flash('error','The package could not be removed. Please try again.');
        }
    }
    AdminSupport::redirect(nabta_public_url('admin/collections.php'));
}
$collections = $model->all();
$csrfToken = AdminSupport::csrfToken();
$flash = AdminSupport::pullFlash();
require __DIR__ . '/../../app/Views/admin/collections.php';
