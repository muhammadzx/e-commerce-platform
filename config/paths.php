<?php
if (!function_exists('nabta_project_base_url')) {
    function nabta_project_base_url(): string
    {
        $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));

        foreach (['/public/', '/app/', '/config/'] as $segment) {
            $position = strpos($scriptName, $segment);
            if ($position !== false) {
                return str_replace(' ', '%20', substr($scriptName, 0, $position));
            }
        }

        return '';
    }
}

if (!function_exists('nabta_public_url')) {
    function nabta_public_url(string $path = ''): string
    {
        $projectBase = nabta_project_base_url();
        $publicBase = $projectBase === '' ? '' : $projectBase . '/public';
        $path = ltrim($path, '/');

        return rtrim($publicBase, '/') . ($path === '' ? '' : '/' . $path);
    }
}

if (!function_exists('nabta_project_url')) {
    function nabta_project_url(string $path = ''): string
    {
        $path = ltrim($path, '/');
        $base = nabta_project_base_url();

        return rtrim($base, '/') . ($path === '' ? '' : '/' . $path);
    }
}
