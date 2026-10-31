<?php
require_once __DIR__ . '/../../config/paths.php';
// OrderController provides $items, $itemCount, $subtotal, $customer and $cities.
$img = static function (?string $url): string {
    if (!$url) return '';
    return preg_match('~^https?://~i', $url) ? $url : nabta_public_url('assets/img/' . ltrim($url, '/'));
};
$u = static fn(string $path): string => htmlspecialchars(nabta_public_url($path), ENT_QUOTES, 'UTF-8');
$money = static fn($value): string => number_format((float) $value, 2) . ' JOD';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | NABTA Botanical</title>
    <link rel="icon" href="<?= $u('assets/img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= $u('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <!-- Cart styles stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=1') ?>">
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

<main class="cx-page">
    <header class="cx-top">
        <a class="cx-brand" href="<?= $u('index.php') ?>" aria-label="Nabta home">
            <svg viewBox="0 0 36 36" aria-hidden="true"><path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z" /><path d="M8 31 23 12" /></svg>
            NABTA <small>BOTANICAL</small>
        </a>
        <nav class="cx-top-links" aria-label="Main navigation">
            <a href="<?= $u('index.php?page=cart') ?>">← Back to basket</a>
        </nav>
    </header>

    <div class="cx-grid" id="checkout-root">

        <section class="cx-card" aria-label="Delivery details">
            <div class="cx-steps" aria-label="Checkout steps">
                <span class="is-current" data-step="1">01 / DELIVERY</span>
                <span data-step="2">02 / REVIEW</span>
                <span data-step="3">03 / CONFIRM</span>
            </div>

            <h2>Delivery details</h2>

            <form class="cx-form" id="delivery-form" novalidate>
                <?= csrf_field() ?>

                <div class="cx-field cx-field-wide">
                    <label for="full_name">Full name</label>
                    <input id="full_name" name="full_name" type="text" maxlength="100" autocomplete="name"
                           value="<?= e($customer['full_name'] ?? '') ?>">
                </div>

                <div class="cx-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" maxlength="150" autocomplete="email"
                           value="<?= e($customer['email'] ?? '') ?>">
                </div>

                <div class="cx-field">
                    <label for="phone">Phone number</label>
                    <input id="phone" name="phone" type="tel" maxlength="30" autocomplete="tel"
                           value="<?= e($customer['phone'] ?? '') ?>">
                </div>

                <div class="cx-field cx-field-wide">
                    <label for="street">Street address</label>
                    <input id="street" name="street" type="text" maxlength="150" autocomplete="street-address"
                           value="<?= e($customer['address'] ?? '') ?>">
                </div>

                <div class="cx-field">
                    <label for="city">City</label>
                    <select id="city" name="city">
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= e($city) ?>"><?= e($city) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="cx-field">
                    <label for="postal_code">Postal code (optional)</label>
                    <input id="postal_code" name="postal_code" type="text" maxlength="20" autocomplete="postal-code">
                </div>

                <p class="cx-form-error" id="form-error" role="alert"></p>

                <button class="cx-btn cx-btn-block" type="submit" style="grid-column:1/-1">
                    Review your order <span aria-hidden="true">→</span>
                </button>
            </form>
        </section>

        <div class="cx-stack">
            <aside class="cx-card" aria-label="Your selections">
                <h2>Your selections</h2>
                <?php foreach ($items as $item): ?>
                    <?php $image = $img($item['image_url'] ?? null); ?>
                    <div class="cx-pick">
                        <?php if ($image): ?>
                            <img src="<?= e($image) ?>" alt="<?= e($item['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="cx-pick-empty"></div>
                        <?php endif; ?>
                        <div>
                            <strong><?= e($item['name']) ?></strong>
                            <span><?= !empty($item['collection_id']) ? 'Collection · ' : '' ?>Quantity <?= (int) $item['quantity'] ?> · <?= $money((float) $item['price'] * (int) $item['quantity']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </aside>

            <aside class="cx-card" aria-label="Order summary">
                <h2>Order summary</h2>
                <div class="cx-row"><span>Subtotal · <?= (int) $itemCount ?> item<?= $itemCount === 1 ? '' : 's' ?></span><span><?= $money($subtotal) ?></span></div>
                <div class="cx-row"><span>Delivery</span><span>Confirmed before order</span></div>
                <div class="cx-row cx-row-total"><span>Total before delivery</span><strong><?= $money($subtotal) ?></strong></div>
            </aside>
        </div>

    </div>
</main>

<!-- Step 2: "One last look" -->
<div class="cx-modal" id="review-modal" role="dialog" aria-modal="true" aria-labelledby="review-title">
    <div class="cx-dialog">
        <div id="review-content">
            <h3 id="review-title">One last look.</h3>
            <p>Check your details before we place your order.</p>

            <dl class="cx-review" id="review-details"></dl>

            <dl class="cx-review">
                <?php foreach ($items as $item): ?>
                    <div><dt><?= e($item['name']) ?> × <?= (int) $item['quantity'] ?></dt><dd><?= $money((float) $item['price'] * (int) $item['quantity']) ?></dd></div>
                <?php endforeach; ?>
                <div><dt>Delivery</dt><dd>Confirmed before order</dd></div>
                <div><dt><strong>Total before delivery</strong></dt><dd><strong><?= $money($subtotal) ?></strong></dd></div>
            </dl>

            <p class="cx-form-error" id="order-error" role="alert"></p>

            <div class="cx-dialog-actions">
                <button class="cx-btn cx-btn-ghost" type="button" id="review-edit">Edit details</button>
                <button class="cx-btn" type="button" id="review-confirm">Confirm order</button>
            </div>
        </div>

        <!-- Step 3: confirmation -->
        <div class="cx-success" id="review-success" hidden>
            <div class="cx-check" aria-hidden="true">✓</div>
            <h3>Thank you.</h3>
            <p id="success-text">Your order has been placed.</p>
            <a class="cx-btn cx-btn-block" href="<?= $u('index.php?page=products') ?>">Continue shopping <span aria-hidden="true">→</span></a>
        </div>
    </div>
</div>

<script>
window.NABTA_PUBLIC_URL = <?= json_encode(nabta_public_url()) ?>;
window.NABTA_CSRF = <?= json_encode(csrf_token()) ?>;
</script>
<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
<script src="<?= $u('assets/js/cart.js?v=1') ?>" defer></script>
</body>
</html>
