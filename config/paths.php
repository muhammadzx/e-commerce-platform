<?php
/** Resolve only existing local assets; never expose stale database image paths. */
function nabta_image_url(?string $value, int $width = 1200): string
{
    $value = trim((string) $value);
    if ($value === '') return '';
    if (preg_match('~^https?://~i', $value)) {
        if (preg_match('~^(https://res\.cloudinary\.com/[^/]+/image/upload/)(?!s--)(.+)$~', $value, $m)) {
            return $m[1] . 'f_auto,q_auto,c_limit,w_' . max(160, min(1800, $width)) . '/' . $m[2];
        }
        return $value;
    }
    $value = ltrim(str_replace('\\', '/', $value), '/');
    $public = realpath(__DIR__ . '/../public');
    foreach (array_unique([$value, 'assets/img/' . $value]) as $candidate) {
        $file = realpath($public . '/' . $candidate);
        if ($file && str_starts_with($file, $public . DIRECTORY_SEPARATOR) && is_file($file)) {
            return nabta_public_url(str_replace(DIRECTORY_SEPARATOR, '/', substr($file, strlen($public) + 1)));
        }
    }
    return '';
}

function nabta_image_srcset(?string $value): string
{
    if (!str_starts_with((string) $value, 'https://res.cloudinary.com/')) return '';
    return implode(', ', array_map(static fn($w) => nabta_image_url($value, $w) . ' ' . $w . 'w', [320, 640, 960, 1440]));
}

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
