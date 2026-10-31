<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';

$adminUser = require_admin_access();
$reportId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$reportId || $reportId < 1) {
    http_response_code(400);
    exit('Invalid report ID.');
}

require_once __DIR__ . '/../../app/Controllers/AIReportController.php';
$controller = new AIReportController();
$controller->download($reportId, $adminUser);
