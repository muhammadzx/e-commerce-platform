<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../../app/Controllers/AdminCustomerController.php';

$controller = new AdminCustomerController();
$controller->handle();
