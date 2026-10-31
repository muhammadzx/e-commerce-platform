<?php
// Floating bag icon with the number of items in the basket.
// Needs the session (bootstrap.php) and the Cart model.
require_once __DIR__ . '/../../Models/Cart.php';

$cartLinkCount = 0;

if (function_exists('is_authenticated') && is_authenticated()) {
    try {
        // Closure keeps connection.php's variables out of the page scope
        $cartLinkCount = (static function (): int {
            require __DIR__ . '/../../../config/connection.php';

            return (new Cart($db))->countItems((int) $_SESSION['user_id']);
        })();
    } catch (Throwable $exception) {
        $cartLinkCount = 0;
    }
}
?>
<a class="cx-bag" href="<?= htmlspecialchars(nabta_public_url('index.php?page=cart'), ENT_QUOTES, 'UTF-8') ?>" aria-label="Shopping basket">
    <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M5 7h14l1 14H4L5 7Z" />
        <path d="M9 8V6a3 3 0 0 1 6 0v2" />
    </svg>
    <span data-cart-count<?= $cartLinkCount > 0 ? '' : ' style="display:none"' ?>><?= (int) $cartLinkCount ?></span>
</a>
<div class="cx-toast" id="cx-toast" role="status" aria-live="polite"></div>
