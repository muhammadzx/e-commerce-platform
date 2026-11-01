<?php
declare(strict_types=1);
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';
require_once __DIR__ . '/../../app/Core/AdminSupport.php';
require_once __DIR__ . '/../../app/Models/AdminReview.php';
$adminUser = require_admin_access();
require __DIR__ . '/../../config/connection.php';
$reviewModel = new AdminReview($db);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!AdminSupport::verifyCsrf()) AdminSupport::flash('error', 'Your session expired. Refresh the page and try again.');
    else {
        $ok = $reviewModel->moderate((int) ($_POST['review_id'] ?? 0), (string) ($_POST['action'] ?? ''));
        AdminSupport::flash($ok ? 'success' : 'error', $ok ? 'Review updated successfully.' : 'The review could not be updated.');
    }
    AdminSupport::redirect(nabta_public_url('admin/reviews.php'));
}
$search = mb_substr(trim((string) ($_GET['q'] ?? '')), 0, 200);
$rating = max(0, min(5, (int) ($_GET['rating'] ?? 0)));
$reviews = $reviewModel->all($search, $rating);
$flash = AdminSupport::pullFlash();
$csrfToken = AdminSupport::csrfToken();
require __DIR__ . '/../../app/Views/admin/reviews.php';