<?php
declare(strict_types=1);

require __DIR__ . '/../app/Views/bootstrap.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

try {
    $database = new Database();
    (new AuthController($database->connect()))->login();
} catch (Throwable $exception) {
    error_log('Nabta login controller error: ' . $exception->getMessage());
    http_response_code(500);
    $pageTitle = 'Sign in';
    $isRegister = false;
    $error = 'The sign-in service is temporarily unavailable. Please check the database configuration and try again.';
    require __DIR__ . '/../app/Views/login.php';
}
