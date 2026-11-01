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
<body class="cx-body">

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

                    <?php foreach ($items as $item): ?>
                        <?php
                        $image = $img($item['image_url'] ?? null);
                        $isCollection = !empty($item['collection_id']);
                        $href = $isCollection ? $u('index.php#bundles') : $u('index.php?page=product&id=' . (int) $item['pro_id']);
                        ?>
                        <article class="cx-line">
                            <a class="cx-line-img" href="<?= $href ?>">
                                <?php if ($image): ?>
                                    <img src="<?= e($image) ?>" alt="<?= e($item['name']) ?>" loading="lazy">
                                <?php else: ?>
                                    <span>NABTA</span>
                                <?php endif; ?>
                            </a>

                            <div>
                                <h2 class="cx-line-name">
                                    <a href="<?= $href ?>"><?= e($item['name']) ?></a>
                                </h2>
                                <p class="cx-line-meta">
                                    <?= e($item['category'] ?? 'NABTA') ?>
                                    <?php if ($isCollection && !empty($item['includes'])): ?>
                                        · <?= e(implode(', ', $item['includes'])) ?>
                                    <?php endif; ?>
                                </p>
                                <label class="sr-only" for="qty-<?= (int) $item['cart_item_id'] ?>" style="position:absolute;left:-9999px">Quantity for <?= e($item['name']) ?></label>
                                <input class="cx-qty" id="qty-<?= (int) $item['cart_item_id'] ?>" type="number" inputmode="numeric"
                                       name="qty[<?= (int) $item['cart_item_id'] ?>]" value="<?= (int) $item['quantity'] ?>"
                                       min="1" max="<?= max(1, (int) $item['stock']) ?>">
                            </div>

                            <div class="cx-line-side">
                                <span class="cx-line-price"><?= $money((float) $item['price'] * (int) $item['quantity']) ?></span>
                                <button class="cx-remove" type="submit" form="remove-<?= (int) $item['cart_item_id'] ?>">Remove</button>
                            </div>
                        </article>
                    <?php endforeach; ?>

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

    <?php endif; ?>
</main>
<?php require __DIR__ . "/layouts/footer.php"; ?>

<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
</body>
</html>
