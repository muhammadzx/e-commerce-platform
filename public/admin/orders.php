<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../../app/Controllers/AdminOrderController.php';

$controller = new AdminOrderController();
$controller->handle();