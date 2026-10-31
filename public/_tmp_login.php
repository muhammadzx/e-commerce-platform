<?php
// TEMPORARY - for local testing only. Delete before sharing the project.
// Opens a session as Sara (customer, user_id 2). ?u=1 = admin (Mohammad).
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../app/Views/bootstrap.php';

$userId = (int) ($_GET['u'] ?? 2);

session_regenerate_id(true);
$_SESSION['user_id'] = $userId;
$_SESSION['role'] = $userId === 1 ? 'admin' : 'customer';
$_SESSION['_last_activity'] = time();

header('Location: ' . nabta_public_url('index.php?page=home'));
exit;
