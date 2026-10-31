<?php
require_once __DIR__ . '/../../config/paths.php';
// require __DIR__ . '/../../app/Views/admin/products.php';

require_once __DIR__ . '/../../app/Controllers/AdminProductController.php';

$controller = new AdminProductController();
$controller->index();