<?php

$envPath = dirname(__DIR__) . '/.env';
if (!is_readable($envPath)) {
    throw new RuntimeException('Project .env file was not found.');
}

$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);
if ($env === false) {
    throw new RuntimeException('Could not read the project .env file.');
}

return [
    'cloud_name' => $env['CLOUDINARY_CLOUD_NAME'] ?? '',
    'api_key' => $env['CLOUDINARY_API_KEY'] ?? '',
    'api_secret' => $env['CLOUDINARY_API_SECRET'] ?? ''
];
