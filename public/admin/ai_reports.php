<?php
require_once __DIR__ . '/../../config/paths.php';
ob_start();
require_once __DIR__ . "/../../app/Controllers/AIReportController.php";

$controller = new AIReportController();
$controller->index();