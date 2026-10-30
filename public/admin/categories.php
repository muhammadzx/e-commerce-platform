<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../../app/Controllers/AdminCategoryController.php';

$controller = new AdminCategoryController();
$controller->handle();
