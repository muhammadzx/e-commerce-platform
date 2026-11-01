<?php
declare(strict_types=1);
require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';
require_once __DIR__ . '/../../app/Core/AdminSupport.php';
$adminUser = require_admin_access();
require __DIR__ . '/../../config/connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (AdminSupport::verifyCsrf()) {
        $stmt = $db->prepare("UPDATE contact_us SET status = :status WHERE contact_id = :id");
        $stmt->execute(['status' => ($_POST['action'] ?? '') === 'resolve' ? 'resolved' : 'new', 'id' => (int) ($_POST['contact_id'] ?? 0)]);
        AdminSupport::flash('success', 'Request status updated.');
    } else AdminSupport::flash('error', 'Your session expired. Refresh and try again.');
    AdminSupport::redirect(nabta_public_url('admin/messages.php'));
}
$messages = $db->query('SELECT c.contact_id, c.message, c.status, u.full_name, u.email FROM contact_us c JOIN users u ON u.user_id=c.user_id ORDER BY c.contact_id DESC')->fetchAll(PDO::FETCH_ASSOC);
$csrfToken = AdminSupport::csrfToken(); $flash = AdminSupport::pullFlash();
require __DIR__ . '/../../app/Views/admin/messages.php';
