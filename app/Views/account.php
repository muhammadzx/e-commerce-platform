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
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <!-- These two stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=1') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/account.css?v=3') ?>">
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
            <a href="<?= $u('index.php?page=products') ?>">Shop</a>
            <a href="<?= $u('index.php') ?>">Home</a>
            <a href="<?= $u('index.php?page=cart') ?>">My basket</a>
            <?php if ($account['role'] === 'admin'): ?>
                <a href="<?= $u('admin/dashboard.php') ?>">Admin</a>
            <?php endif; ?>
        </nav>
    </header>

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

        </div>

        <dl class="ac-info">
            <div><dt>Full name</dt><dd><?= e($account['full_name']) ?></dd></div>
            <div><dt>Email</dt><dd><?= e($account['email']) ?></dd></div>
            <div><dt>Phone</dt><dd><?= $account['phone'] ? e($account['phone']) : '—' ?></dd></div>
            <div><dt>Address</dt><dd><?= $account['address'] ? e($account['address']) : '—' ?></dd></div>
        </dl>
    </section>

    <section class="cx-card ac-orders" aria-label="My orders">
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

    <div class="ac-forms">

        <section class="cx-card" aria-label="Edit profile">
            <h2>Edit profile</h2>

            <form class="cx-form" method="post" action="<?= $u('index.php?page=profile') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="profile">

                <div class="cx-field">
                    <label for="user-name">Full name</label>
                    <input id="user-name" name="full_name" type="text" required maxlength="100"
                           value="<?= e($account['full_name']) ?>" autocomplete="name">
                </div>

                <div class="cx-field">
                    <label for="user-email">Email address</label>
                    <input id="user-email" name="email" type="email" required maxlength="150"
                           value="<?= e($account['email']) ?>" autocomplete="email">
                </div>

                <div class="cx-field">
                    <label for="user-phone">Phone number</label>
                    <input id="user-phone" name="phone" type="tel" maxlength="30"
                           value="<?= e($account['phone'] ?? '') ?>" autocomplete="tel">
                </div>

                <div class="cx-field">
                    <label for="user-address">Address</label>
                    <input id="user-address" name="address" type="text" maxlength="255"
                           value="<?= e($account['address'] ?? '') ?>" autocomplete="street-address">
                </div>

                <button class="cx-btn" type="submit">Save changes</button>
            </form>
        </section>

        <section class="cx-card" aria-label="Change password">
            <h2>Change password</h2>

            <form class="cx-form ac-form-3" method="post" action="<?= $u('index.php?page=profile') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="password">

                <div class="cx-field">
                    <label for="current-password">Current password</label>
                    <input id="current-password" name="current_password" type="password" required
                           autocomplete="current-password">
                </div>

                <div class="cx-field">
                    <label for="new-password">New password</label>
                    <input id="new-password" name="new_password" type="password" minlength="8" required
                           autocomplete="new-password">
                </div>

                <div class="cx-field">
                    <label for="confirm-password">Confirm new password</label>
                    <input id="confirm-password" name="confirm_password" type="password" minlength="8" required
                           autocomplete="new-password">
                </div>

                <button class="cx-btn" type="submit">Update password</button>
            </form>
        </section>

    </div>
</main>

<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
</body>
</html>
