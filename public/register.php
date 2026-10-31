<?php
declare(strict_types=1);

require __DIR__ . '/../app/Views/bootstrap.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

try {
    $database = new Database();
    (new AuthController($database->connect()))->register();
} catch (Throwable $exception) {
    error_log('Nabta registration controller error: ' . $exception->getMessage());
    http_response_code(500);
    $pageTitle = 'Create account';
    $isRegister = true;
    $error = 'The registration service is temporarily unavailable. Please check the database configuration and try again.';
    require __DIR__ . '/../app/Views/register.php';
}
