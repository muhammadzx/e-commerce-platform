<?php

// Small helpers shared by the admin pages: session, CSRF token and flash messages.
class AdminSupport
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function e($value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function csrfToken(): string
    {
        self::start();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrf(): bool
    {
        self::start();

        $sent = $_POST['csrf_token'] ?? '';

        return is_string($sent)
            && !empty($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $sent);
    }

    // type: "success" or "error"
    public static function flash(string $type, string $message): void
    {
        self::start();
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    public static function pullFlash(): ?array
    {
        self::start();

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        return $flash;
    }

    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
