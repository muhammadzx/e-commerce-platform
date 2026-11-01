<?php
// Provided by AccountController: $account, $flash
$u = static fn(string $path): string => htmlspecialchars(nabta_public_url($path), ENT_QUOTES, 'UTF-8');

$initials = '';
foreach (array_slice(preg_split('/\s+/', trim((string) $account['full_name'])) ?: [], 0, 2) as $part) {
    $initials .= mb_strtoupper(mb_substr($part, 0, 1));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My account | NABTA Botanical</title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" href="<?= $u('assets/img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= $u('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css?v=2') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <!-- These two stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=2') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/account.css?v=4') ?>">
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

    <h1 class="cx-title">My account</h1>

    <?php if ($flash): ?>
        <div class="ac-flash <?= e($flash['type']) ?>" role="status"><?= e($flash['message']) ?></div>
    <?php endif; ?>

    <section class="cx-card" aria-label="Account details">
        <div class="ac-hero">
            <div class="ac-who">
                <div class="ac-avatar" aria-hidden="true"><?= e($initials) ?></div>
                <div>
                    <h2><?= e($account['full_name']) ?></h2>
                    <p><?= e($account['email']) ?></p>
                    <span class="ac-badge"><?= $account['role'] === 'admin' ? 'Admin' : 'Customer' ?></span>
                </div>
            </div>

            <div class="ac-actions">
                <button class="cx-btn cx-btn-small cx-btn-ghost" type="button" popovertarget="edit-profile">Edit profile ↗</button>
                <button class="cx-btn cx-btn-small cx-btn-ghost" type="button" popovertarget="change-password">Change password</button>
            </div>
        </div>

        <dl class="ac-info">
            <div><dt>Full name</dt><dd><?= e($account['full_name']) ?></dd></div>
            <div><dt>Email</dt><dd><?= e($account['email']) ?></dd></div>
            <div><dt>Phone</dt><dd><?= $account['phone'] ? e($account['phone']) : '—' ?></dd></div>
            <div><dt>Address</dt><dd><?= $account['address'] ? e($account['address']) : '—' ?></dd></div>
        </dl>
    </section>

    <section class="cx-card ac-orders" id="orders" aria-label="My orders">
        <h2>My orders</h2>

        <?php if (!$orders): ?>
            <p class="ac-empty">You have not placed any orders yet.
                <a href="<?= $u('index.php?page=products') ?>">Start shopping →</a></p>
        <?php else: ?>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td data-label="Order">#<?= (int) $order['cart_id'] ?></td>
                                <td data-label="Date"><?= e(date('d M Y', strtotime((string) $order['created_at']))) ?></td>
                                <td data-label="Items">
                                    <?= e((string) $order['summary']) ?>
                                    <small><?= (int) $order['units'] ?> <?= (int) $order['units'] === 1 ? 'item' : 'items' ?></small>
                                </td>
                                <td data-label="Total"><?= number_format((float) $order['total_price'], 2) ?> JOD</td>
                                <td data-label="Status">
                                    <span class="ac-status ac-status-<?= e($order['status']) ?>"><?= e(ucfirst((string) $order['status'])) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>


    <section class="cx-card ac-orders" aria-label="My wishlist">
        <h2>My wishlist</h2>

        <?php if (!$wishlist): ?>
            <p class="ac-empty">Your wishlist is empty.
                <a href="<?= $u('index.php?page=products') ?>">Find something you love →</a></p>
        <?php else: ?>
            <div class="ac-table-wrap">
                <table class="ac-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Availability</th>
                            <th><span class="ac-sr">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($wishlist as $item): ?>
                            <tr>
                                <td data-label="Item">
                                    <div class="ac-item">
                                        <?php if (!empty($item['image']) && is_file(__DIR__ . '/../../public/assets/img/' . ltrim($item['image'], '/'))): ?>
                                            <img src="<?= $u('assets/img/' . ltrim($item['image'], '/')) ?>" alt="" loading="lazy">
                                        <?php endif; ?>
                                        <a href="<?= $u($item['url']) ?>"><?= e($item['name']) ?></a>
                                    </div>
                                </td>
                                <td data-label="Type"><?= e($item['type']) ?></td>
                                <td data-label="Price"><?= number_format((float) $item['price'], 2) ?> JOD</td>
                                <td data-label="Availability">
                                    <span class="ac-status <?= $item['in_stock'] ? 'ac-status-completed' : 'ac-status-out' ?>"><?= $item['in_stock'] ? 'In stock' : 'Unavailable' ?></span>
                                </td>
                                <td data-label="">
                                    <form method="post" action="<?= $u('index.php?page=profile') ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="wishlist_remove">
                                        <input type="hidden" name="wishlist_id" value="<?= (int) $item['wishlist_id'] ?>">
                                        <button class="ac-link-btn" type="submit">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require __DIR__ . "/layouts/footer.php"; ?>

<!-- EDIT PROFILE POPOVER -->
<section id="edit-profile" class="ac-popover" popover aria-labelledby="edit-profile-title">
    <div class="ac-popover-top">
        <h2 id="edit-profile-title">Personal information</h2>
        <button class="ac-close" type="button" popovertarget="edit-profile" popovertargetaction="hide" aria-label="Close window">×</button>
    </div>

    <form class="cx-form" method="post" action="<?= $u('index.php?page=profile') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="profile">

        <div class="cx-field cx-field-wide">
            <label for="user-name">Full name</label>
            <input id="user-name" name="full_name" type="text" required maxlength="100"
                   value="<?= e($account['full_name']) ?>" autocomplete="name">
        </div>

        <div class="cx-field cx-field-wide">
            <label for="user-email">Email address</label>
            <input id="user-email" name="email" type="email" required maxlength="150"
                   value="<?= e($account['email']) ?>" autocomplete="email">
        </div>

        <div class="cx-field cx-field-wide">
            <label for="user-phone">Phone number</label>
            <input id="user-phone" name="phone" type="tel" maxlength="30"
                   value="<?= e($account['phone'] ?? '') ?>" autocomplete="tel">
        </div>

        <div class="cx-field cx-field-wide">
            <label for="user-address">Address</label>
            <input id="user-address" name="address" type="text" maxlength="255"
                   value="<?= e($account['address'] ?? '') ?>" autocomplete="street-address">
        </div>

        <button class="cx-btn cx-btn-block" type="submit">Save changes</button>
    </form>
</section>

<!-- CHANGE PASSWORD POPOVER -->
<section id="change-password" class="ac-popover" popover aria-labelledby="change-password-title">
    <div class="ac-popover-top">
        <h2 id="change-password-title">Change password</h2>
        <button class="ac-close" type="button" popovertarget="change-password" popovertargetaction="hide" aria-label="Close window">×</button>
    </div>

    <form class="cx-form" method="post" action="<?= $u('index.php?page=profile') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="password">

        <div class="cx-field cx-field-wide">
            <label for="current-password">Current password</label>
            <input id="current-password" name="current_password" type="password" required
                   autocomplete="current-password">
        </div>

        <div class="cx-field cx-field-wide">
            <label for="new-password">New password</label>
            <input id="new-password" name="new_password" type="password" minlength="8" required
                   autocomplete="new-password">
        </div>

        <div class="cx-field cx-field-wide">
            <label for="confirm-password">Confirm new password</label>
            <input id="confirm-password" name="confirm_password" type="password" minlength="8" required
                   autocomplete="new-password">
        </div>

        <button class="cx-btn cx-btn-block" type="submit">Update password</button>
    </form>
</section>

<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
</body>
</html>
