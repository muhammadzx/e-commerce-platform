<?php
require_once __DIR__ . '/../../config/paths.php';
// CartController provides $items, $itemCount and $subtotal.
$img = static fn(?string $url): string => nabta_image_url($url);
$u = static fn(string $path): string => htmlspecialchars(nabta_public_url($path), ENT_QUOTES, 'UTF-8');
$money = static fn($value): string => number_format((float) $value, 2) . ' JOD';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your basket | NABTA Botanical</title>
    <link rel="icon" href="<?= $u('assets/img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= $u('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css?v=2') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <!-- Cart styles stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=2') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="cx-body basket-page">

<div class="nature-bg" aria-hidden="true">
    <div class="tree" id="tree"></div>
    <div class="leaves" id="leaves"></div>
</div>
<div class="sunlight" aria-hidden="true">
    <div class="rays"></div>
    <div class="glints"></div>
</div>

<?php require __DIR__ . "/layouts/header.php"; ?>
<main id="main" tabindex="-1" class="cx-page">
<h1 class="page-title">Your basket</h1>

    <?php if (!$items): ?>

        <section class="cx-card cx-empty">
            <h2>Your basket is empty</h2>
            <p>Nothing here yet. A little more nature is waiting in the shop.</p>
            <a class="cx-btn" href="<?= $u('index.php?page=products') ?>">Continue shopping <span aria-hidden="true">→</span></a>
        </section>

    <?php else: ?>

        <div class="cx-grid">

            <section class="cx-card" aria-label="Items in your basket">
                <form method="post" action="<?= $u('index.php?page=cart') ?>" id="cart-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="update">

                    <?php $quantityPrefix = 'preview'; foreach (array_slice($items,0,3) as $item): require __DIR__ . '/layouts/basket-item.php'; endforeach; ?>
                    <?php foreach (array_slice($items,3) as $item): ?><input type="hidden" data-basket-quantity="<?= (int)$item['cart_item_id'] ?>" name="qty[<?= (int)$item['cart_item_id'] ?>]" value="<?= (int)$item['quantity'] ?>"><?php endforeach; ?>
                    <?php if (count($items) > 3): ?><button class="basket-see-more" type="button" popovertarget="basket-all-items">See more (+<?= count($items)-3 ?>)</button><?php endif; ?>

                    <div class="cx-actions">
                        <a class="cx-back" href="<?= $u('index.php?page=products') ?>">← Continue shopping</a>
                        <button class="cx-btn cx-btn-small" type="submit">Update quantities</button>
                    </div>
                </form>

                <?php foreach ($items as $item): ?>
                    <form id="remove-<?= (int) $item['cart_item_id'] ?>" method="post" action="<?= $u('index.php?page=cart') ?>" hidden>
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="cart_item_id" value="<?= (int) $item['cart_item_id'] ?>">
                    </form>
                <?php endforeach; ?>
            </section>

            <aside class="cx-card" aria-label="Basket summary">
                <h2>Your basket</h2>
                <div class="cx-row"><span>Subtotal · <?= (int) $itemCount ?> item<?= $itemCount === 1 ? '' : 's' ?></span><span><?= $money($subtotal) ?></span></div>
                <div class="cx-row"><span>Delivery</span><span>Not yet calculated</span></div>
                <div class="cx-row cx-row-total"><span>Total</span><strong><?= $money($subtotal) ?></strong></div>
                <a class="cx-btn cx-btn-block cx-summary-btn" href="<?= $u('index.php?page=checkout') ?>">Continue to checkout <span aria-hidden="true">→</span></a>
                <p class="cx-note">Checkout sends a request for confirmation. Delivery costs and payment arrangements require your later approval.</p>
            </aside>

        </div>

<?php if (count($items) > 3): ?>
<section id="basket-all-items" class="package-detail-popover basket-all-modal" popover role="dialog" aria-modal="true" aria-labelledby="basket-all-title">
    <div class="package-detail-heading"><h2 id="basket-all-title">All basket items (<?= count($items) ?>)</h2><button class="package-detail-close" type="button" popovertarget="basket-all-items" popovertargetaction="hide" aria-label="Close basket items">&times;</button></div>
    <form method="post" action="<?= $u('index.php?page=cart') ?>" id="cart-all-form">
        <?= csrf_field() ?><input type="hidden" name="action" value="update">
        <?php $quantityPrefix = 'all'; foreach ($items as $item): require __DIR__ . '/layouts/basket-item.php'; endforeach; ?>
        <div class="cx-row cx-row-total"><span>Subtotal before delivery</span><strong><?= $money($subtotal) ?></strong></div>
        <div class="cx-actions"><button class="cx-btn cx-btn-small" type="submit">Update quantities</button><button class="basket-see-more" type="button" popovertarget="basket-all-items" popovertargetaction="hide">Close</button></div>
    </form>
</section>
<?php endif; ?>

    <?php endif; ?>
</main>
<?php require __DIR__ . "/layouts/footer.php"; ?>

<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
<script src="<?= $u('assets/js/basket.js?v=' . (int)filemtime(__DIR__ . '/../../public/assets/js/basket.js')) ?>" defer></script>
</body>
</html>
