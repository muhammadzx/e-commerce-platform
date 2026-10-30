<?php

require_once __DIR__ . '/../../app/Controllers/AIReportController.php';

$reportId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$reportId) {
    http_response_code(400);
    exit('Invalid report ID.');
}

$controller = new AIReportController();
$controller->download($reportId);