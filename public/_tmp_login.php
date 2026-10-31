<?php
// TEMPORARY: logs you in as Sara (customer). Delete this file after testing.
require __DIR__ . '/../app/Views/bootstrap.php';
session_regenerate_id(true);
$_SESSION['user_id'] = 2;
$_SESSION['full_name'] = 'Sara Khaled';
$_SESSION['user_email'] = 'sara@example.com';
$_SESSION['role'] = 'customer';
$_SESSION['auth_time'] = time();
header('Location: index.php?page=products');
exit;
