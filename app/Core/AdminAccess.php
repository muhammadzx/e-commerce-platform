<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../Core/Security.php';

function require_admin_access(): array
{
    static $currentAdmin = null;

    if (is_array($currentAdmin)) {
        return $currentAdmin;
    }

    require_once __DIR__ . '/../Views/bootstrap.php';

    if (!is_authenticated()) {
        $_SESSION['auth_notice'] = 'Please sign in to continue.';
        header('Location: ' . nabta_public_url('login.php'));
        exit;
    }

    require __DIR__ . '/../../config/connection.php';

    $stmt = $db->prepare(
        'SELECT user_id, full_name, email, phone, address, role, status
         FROM users WHERE user_id = :id LIMIT 1'
    );
    $stmt->execute(['id' => (int) $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || $user['status'] !== 'active') {
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['auth_notice'] = 'Please sign in to continue.';
        header('Location: ' . nabta_public_url('login.php'));
        exit;
    }

    if ($user['role'] !== 'admin') {
        http_response_code(403);
        exit('You do not have permission to access this page.');
    }

    $_SESSION['user_id'] = (int) $user['user_id'];
    $_SESSION['full_name'] = (string) $user['full_name'];
    $_SESSION['user_email'] = (string) $user['email'];
    $_SESSION['role'] = (string) $user['role'];

    $currentAdmin = $user;
    $GLOBALS['admin_user'] = $currentAdmin;

    return $currentAdmin;
}
