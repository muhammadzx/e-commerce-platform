<?php
// Sets $navCartCount: units in the signed-in customer's basket (0 for guests).
// Used by the nav bar basket icon, which cart.js keeps up to date.
require_once __DIR__ . '/../../Models/Cart.php';

$navCartCount = 0;

if (function_exists('is_authenticated') && is_authenticated()) {
    try {
        $navCartCount = (static function (): int {
            require __DIR__ . '/../../../config/connection.php';

            return (new Cart($db))->countItems((int) $_SESSION['user_id']);
        })();
    } catch (Throwable $exception) {
        $navCartCount = 0;
    }
}
