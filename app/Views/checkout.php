<?php
require_once __DIR__ . '/../../config/paths.php';
// OrderController provides $items, $itemCount, $subtotal, $customer and $cities.
$img = static fn(?string $url): string => nabta_image_url($url);
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
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css?v=2') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <!-- Cart styles stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=2') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/popups.css') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="cx-body checkout-page">

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
<h1 class="page-title">Request order confirmation</h1>

    <div class="cx-grid" id="checkout-root">

        <section class="cx-card" aria-label="Delivery details">
            <div class="cx-steps" aria-label="Checkout steps">
                <span class="is-current" data-step="1">01 / DELIVERY</span>
                <span data-step="2">02 / REVIEW</span>
                <span data-step="3">03 / CONFIRM</span>
            </div>

            <h2>Delivery details</h2><p class="checkout-intro">Request only. Delivery details are optional; delivery costs, payment and availability need your approval before fulfilment. <a href="index.php?page=information">Store information</a></p>

            <form class="cx-form" id="delivery-form" novalidate>
                <?= csrf_field() ?>

                <div class="cx-field">
                    <label for="full_name">Full name (optional)</label>
                    <input id="full_name" name="full_name" type="text" maxlength="100" autocomplete="name"
                           value="<?= e($customer['full_name'] ?? '') ?>">
                </div>

                <div class="cx-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" maxlength="150" autocomplete="email" readonly aria-describedby="checkout-email-note"
                           value="<?= e($customer['email'] ?? '') ?>"><small id="checkout-email-note">Account email. Change it in account settings.</small>
                </div>

                <div class="cx-field">
                    <label for="phone">Phone number (optional)</label>
                    <input id="phone" name="phone" type="tel" maxlength="20" autocomplete="tel"
                           value="<?= e($customer['phone'] ?? '') ?>">
                </div>

                <div class="cx-field">
                    <label for="city">City (optional)</label>
                    <select id="city" name="city">
                        <?php foreach ($cities as $city): ?>
                            <option value="<?= e($city) ?>"><?= e($city) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="cx-field">
                    <label for="street">Street address (optional)</label>
                    <input id="street" name="street" type="text" maxlength="150" autocomplete="street-address"
                           value="<?= e($customer['address'] ?? '') ?>">
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
            <aside class="cx-card checkout-selections" aria-label="Your selections">
                <h2>Your selections</h2>
                <?php foreach (array_slice($items, 0, 3) as $item): ?>
                    <?php $image = $img($item['image_url'] ?? null); ?>
                    <div class="cx-pick" data-checkout-item="<?= (int)$item['cart_item_id'] ?>">
                        <?php if ($image): ?>
                            <img src="<?= e($image) ?>" alt="<?= e($item['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="cx-pick-empty"></div>
                        <?php endif; ?>
                        <div>
                            <strong><?= e($item['name']) ?></strong>
                            <span><?= !empty($item['collection_id']) ? 'Package · ' : '' ?>Quantity <?= (int) $item['quantity'] ?> · <?= $money((float) $item['price'] * (int) $item['quantity']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (count($items) > 3): ?>
                    <button class="checkout-selections-more" type="button" popovertarget="checkout-selections-details" aria-label="See more: view all selected items">See more (+<?= count($items) - 3 ?>)</button>
                <?php endif; ?>
            </aside>

            <aside class="cx-card" aria-label="Order summary">
                <h2>Order summary</h2>
                <div class="cx-row"><span data-checkout-item-count>Subtotal &middot; <?= (int) $itemCount ?> item<?= $itemCount === 1 ? '' : 's' ?></span><span data-checkout-subtotal><?= $money($subtotal) ?></span></div>
                <div class="cx-row"><span>Delivery</span><span>Not yet calculated</span></div>
                <div class="cx-row cx-row-total"><span>Total before delivery</span><strong data-checkout-subtotal><?= $money($subtotal) ?></strong></div>
            </aside>
        </div>

    </div>
</main>
<?php require __DIR__ . "/layouts/footer.php"; ?>

<?php if (count($items) > 3): ?>
<section id="checkout-selections-details" class="popover checkout-selections-modal" popover role="dialog" aria-modal="true" aria-labelledby="checkout-selections-title">
    <div class="checkout-selections-heading"><h2 id="checkout-selections-title">All your selections (<?= count($items) ?>)</h2><button class="checkout-selections-close" type="button" popovertarget="checkout-selections-details" popovertargetaction="hide" aria-label="Close selections">&times;</button></div>
                <?php foreach ($items as $item): ?>
                    <?php $image = $img($item['image_url'] ?? null); ?>
                    <div class="cx-pick" data-checkout-item="<?= (int)$item['cart_item_id'] ?>">
                        <?php if ($image): ?>
                            <img src="<?= e($image) ?>" alt="<?= e($item['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="cx-pick-empty"></div>
                        <?php endif; ?>
                        <div>
                            <strong><?= e($item['name']) ?></strong>
                            <span><?= !empty($item['collection_id']) ? 'Package · ' : '' ?>Quantity <?= (int) $item['quantity'] ?> · <?= $money((float) $item['price'] * (int) $item['quantity']) ?></span>
                        </div>
                        <button class="checkout-remove-item" type="button" data-remove-checkout-item="<?= (int)$item['cart_item_id'] ?>" aria-label="Remove <?= e($item['name']) ?> from basket" title="Remove from basket"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M9 7V4h6v3M6 7l1 14h10l1-14M10 11v6m4-6v6"/></svg></button>
                    </div>
                <?php endforeach; ?>
    <p id="checkout-remove-error" class="cx-form-error" role="alert"></p>
    <div class="cx-row cx-row-total"><span>Subtotal before delivery</span><strong data-checkout-subtotal><?= $money($subtotal) ?></strong></div>
</section>
<?php endif; ?>

<!-- Step 2: "One last look" -->
<div class="cx-modal" id="review-modal" role="dialog" aria-modal="true" aria-labelledby="review-title">
    <div class="cx-dialog">
        <div id="review-content">
            <h3 id="review-title">One last look.</h3>
            <p>Review your request. Delivery costs and payment arrangements are not yet specified. Sending this request does not approve any undisclosed charges.</p>

            <dl class="cx-review" id="review-details"></dl>

            <dl class="cx-review">
                <?php foreach ($items as $item): ?>
                    <div data-checkout-item="<?= (int)$item['cart_item_id'] ?>"><dt><?= e($item['name']) ?> × <?= (int) $item['quantity'] ?></dt><dd><?= $money((float) $item['price'] * (int) $item['quantity']) ?></dd></div>
                <?php endforeach; ?>
                <div><dt>Delivery</dt><dd>Not yet calculated</dd></div>
                <div><dt><strong>Total before delivery</strong></dt><dd><strong data-checkout-subtotal><?= $money($subtotal) ?></strong></dd></div>
            </dl>

            <p class="cx-form-error" id="order-error" role="alert"></p>

            <div class="cx-dialog-actions">
                <button class="cx-btn cx-btn-ghost" type="button" id="review-edit">Edit details</button>
                <button class="cx-btn" type="button" id="review-confirm">Send confirmation request</button>
            </div>
        </div>

        <!-- Step 3: confirmation -->
        <div class="cx-success" id="review-success" hidden>
            <div class="cx-check" aria-hidden="true">✓</div>
            <h3>Thank you.</h3>
            <p id="success-text">Your request has been saved. No payment has been taken.</p>
            <a class="cx-btn cx-btn-block" href="<?= $u('index.php?page=products') ?>">Continue shopping <span aria-hidden="true">→</span></a>
        </div>
    </div>
</div>

<script>
window.NABTA_PUBLIC_URL = <?= json_encode(nabta_public_url()) ?>;
window.NABTA_CSRF = <?= json_encode(csrf_token()) ?>;
</script>
<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
<script src="<?= $u('assets/js/cart.js?v=' . (int)filemtime(__DIR__ . '/../../public/assets/js/cart.js')) ?>" defer></script>
</body>
</html>
