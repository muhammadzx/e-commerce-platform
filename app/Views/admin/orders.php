<?php
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
require_once __DIR__ . '/../../../config/paths.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage orders | Nabta Botanical</title>
    <meta
      name="description"
      content="Manage orders — plants and growing essentials at Nabta."
    />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="theme-color" content="#c5d4b4" />
    <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
      <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
  <body class="admin-body botanical-edition workspace-page admin-orders">
    <main id="main">
        <div class="admin-shell">
            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
            <div class="admin-content">
                <div class="admin-top"><span>Workspace / Orders</span>
                    <div class="flex"><span>Nabta Botanical</span><span class="pill">Orders</span></div>
                </div>
                <div class="admin-photo-strip" role="img" aria-label="Soft-focus botanical greenhouse photograph">
                    <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span>
                </div>
                <div class="admin-title">
                    <div>
                        <h1>Orders</h1>
                        <p>Track every order from basket to delivery.</p>
                    </div>
                </div>

                <?php if ($flash): ?>
                    <div class="flash <?= $e($flash['type']) ?>" role="status"><?= $e($flash['message']) ?></div>
                <?php endif; ?>

                <section class="panel">
                    <div class="toolbar">
                        <form method="get" action="<?= $e($formAction) ?>">
                            <label class="sr-only" for="search-records">Search orders</label>
                            <input class="control" id="search-records" name="q" type="search"
                                placeholder="Search by order #, customer or status" value="<?= $e($search) ?>">
                            <button class="btn secondary" type="submit">Search <svg class="icon" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <circle cx="10" cy="10" r="6"></circle>
                                    <path d="m15 15 5 5"></path>
                                </svg></button>
                        </form>
                        <span class="label"><?= $total ?> record<?= $total === 1 ? '' : 's' ?></span>
                    </div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($total === 0): ?>
                                    <tr>
                                        <td colspan="6" style="text-align:center; padding:32px 16px;">
                                            <strong>No orders found</strong>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($orders as $o): $id = (int) $o['cart_id']; ?>
                                    <tr>
                                        <td data-label="Order">#<?= $id ?></td>
                                        <td data-label="Customer"><?= $e($o['full_name'] ?? 'Deleted customer') ?></td>
                                        <td data-label="Date"><?= $e(date('d M Y', strtotime($o['created_at']))) ?></td>
                                        <td data-label="Total"><?= $e($money($o['total_price'])) ?></td>
                                        <td data-label="Status">
                                            <span class="pill <?= in_array($o['status'], ['pending', 'processing'], true) ? 'pending' : '' ?>"><?= $e($statusLabels[$o['status']] ?? $o['status']) ?></span>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="table-actions"><button class="table-button" type="button"
                                                    popovertarget="view-<?= $id ?>">View</button><button
                                                    class="table-button" type="button"
                                                    popovertarget="edit-<?= $id ?>">Edit</button><button
                                                    class="table-button" type="button"
                                                    popovertarget="delete-<?= $id ?>">Delete</button></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <?php foreach ($orders as $o):
                $id = (int) $o['cart_id'];
                $items = $itemsByOrder[$id] ?? [];
                $subtotal = 0;
                foreach ($items as $item) {
                    $subtotal += (float) $item['unit_price_at_purchase'] * (int) $item['quantity'];
                }
            ?>
                <!-- Order #<?= $id ?> -->
                <section id="view-<?= $id ?>" class="popover" popover aria-labelledby="view-<?= $id ?>-title">
                    <div class="popover-top">
                        <h2 id="view-<?= $id ?>-title">Order #<?= $id ?></h2><button class="icon-btn" type="button"
                            popovertarget="view-<?= $id ?>" popovertargetaction="hide"
                            aria-label="Close window">×</button>
                    </div>
                    <div class="summary-row"><span>Customer</span><span><?= $e($o['full_name'] ?? 'Deleted customer') ?></span></div>
                    <div class="summary-row"><span>Email</span><span><?= $e($o['email'] ?: '—') ?></span></div>
                    <div class="summary-row"><span>Phone</span><span><?= $e($o['phone'] ?: '—') ?></span></div>
                    <div class="summary-row"><span>Date</span><span><?= $e(date('d M Y, H:i', strtotime($o['created_at']))) ?></span></div>
                    <div class="summary-row"><span>Delivery address</span><span><?= $e($o['delivery_address_at_order']) ?></span></div>
                    <div class="summary-row"><span>Payment method</span><span><?= $e($o['payment_method'] ?: '—') ?></span></div>
                    <div class="summary-row"><span>Status</span><span><span class="pill <?= in_array($o['status'], ['pending', 'processing'], true) ? 'pending' : '' ?>"><?= $e($statusLabels[$o['status']] ?? $o['status']) ?></span></span></div>

                    <h3 style="margin:18px 0 6px">Items</h3>
                    <?php if (!$items): ?>
                        <div class="summary-row"><span>No items recorded for this order.</span><span></span></div>
                    <?php endif; ?>
                    <?php foreach ($items as $item): ?>
                        <div class="summary-row">
                            <span><?= $e($item['item_name']) ?> <small>(<?= $e($item['item_type']) ?>) × <?= (int) $item['quantity'] ?></small></span>
                            <span><?= $e($money((float) $item['unit_price_at_purchase'] * (int) $item['quantity'])) ?></span>
                        </div>
                    <?php endforeach; ?>

                    <div class="summary-row"><span>Subtotal</span><span><?= $e($money($subtotal)) ?></span></div>
                    <div class="summary-row"><span>Delivery fee</span><span><?= $e($money($o['delivery_fee'])) ?></span></div>
                    <?php if ($o['discount_code']): ?>
                        <div class="summary-row"><span>Discount code</span><span><?= $e($o['discount_code']) ?> (<?= $e(rtrim(rtrim(number_format((float) $o['discount_percentage'], 2), '0'), '.')) ?>%)</span></div>
                    <?php endif; ?>
                    <div class="summary-row"><span><strong>Total</strong></span><span><strong><?= $e($money($o['total_price'])) ?></strong></span></div>
                </section>

                <section id="edit-<?= $id ?>" class="popover" popover aria-labelledby="edit-<?= $id ?>-title">
                    <form method="post" action="<?= $e($formAction) ?>">
                        <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="order_id" value="<?= $id ?>">
                        <div class="popover-top">
                            <h2 id="edit-<?= $id ?>-title">Edit order #<?= $id ?></h2><button class="icon-btn"
                                type="button" popovertarget="edit-<?= $id ?>" popovertargetaction="hide"
                                aria-label="Close window">×</button>
                        </div>
                        <div class="field"><label>Customer</label>
                            <input type="text" value="<?= $e($o['full_name'] ?? 'Deleted customer') ?>" disabled>
                        </div>
                        <div class="form-grid">
                            <div class="field"><label>Payment method</label>
                                <input type="text" value="<?= $e($o['payment_method'] ?: '—') ?>" disabled>
                            </div>
                            <div class="field"><label for="edit-<?= $id ?>-status">Order status</label>
                                <select id="edit-<?= $id ?>-status" name="status">
                                    <?php foreach ($statusLabels as $value => $label): ?>
                                        <option value="<?= $e($value) ?>" <?= $o['status'] === $value ? 'selected' : '' ?>><?= $e($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="field"><label>Delivery address</label>
                            <input type="text" value="<?= $e($o['delivery_address_at_order']) ?>" disabled>
                        </div>
                        <div class="field"><label>Total price</label>
                            <input type="text" value="<?= $e($money($o['total_price'])) ?>" disabled>
                        </div>
                        <button class="btn" type="submit">Save changes</button>
                    </form>
                </section>

                <section id="delete-<?= $id ?>" class="popover" popover aria-labelledby="delete-<?= $id ?>-title">
                    <div class="popover-top">
                        <h2 id="delete-<?= $id ?>-title">Delete this order?</h2><button class="icon-btn"
                            type="button" popovertarget="delete-<?= $id ?>" popovertargetaction="hide"
                            aria-label="Close window">×</button>
                    </div>
                    <p>You are about to permanently remove <strong>order #<?= $id ?></strong>, all of its items,
                        and the customer's reviews on those items. This cannot be undone.</p>
                    <form method="post" action="<?= $e($formAction) ?>" class="flex" style="margin-top:18px">
                        <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="order_id" value="<?= $id ?>">
                        <button class="btn" type="submit">Delete order</button>
                        <button class="btn secondary" type="button" popovertarget="delete-<?= $id ?>"
                            popovertargetaction="hide">Keep order</button>
                    </form>
                </section>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>