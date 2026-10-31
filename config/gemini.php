<?php

$envPath = dirname(__DIR__) . '/.env';
$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

$key = trim($env['GEMINI_API_KEY'] ?? '');

if ($key === '') {
    throw new RuntimeException('Gemini API key is missing.');
}

return $key;