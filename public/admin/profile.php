<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';

// Keep the legacy admin URL working while using the shared, session-scoped account page.
require_admin_access();
header('Location: ' . nabta_public_url('index.php?page=profile'));
exit;
