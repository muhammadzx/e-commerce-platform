<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';

$adminUser = require_admin_access();
ob_start();
require_once __DIR__ . '/../../app/Controllers/AIReportController.php';

$controller = new AIReportController();
$controller->index($adminUser);
