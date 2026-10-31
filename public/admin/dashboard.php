<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';

$adminUser = require_admin_access();
require_once __DIR__ . '/../../app/Controllers/AdminController.php';

$controller = new AdminController();
$controller->index();
