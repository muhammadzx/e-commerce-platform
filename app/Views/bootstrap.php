<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Security.php';

start_secure_session();
security_headers();
enforce_session_timeout();
