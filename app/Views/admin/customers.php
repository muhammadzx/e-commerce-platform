<?php
require_once __DIR__ . '/../../../config/paths.php';
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
// Opened directly (not through the controller): send the visitor to the real page
if (!isset($customers)) {
    header('Location: ' . nabta_public_url('admin/customers.php'));
    exit;
}

// Provided by AdminCustomerController: $customers, $search, $flash, $csrfToken
$e = static fn($value) => AdminSupport::e($value);
$roleLabels = ['customer' => 'Regular user', 'admin' => 'Admin'];
$statusLabels = ['active' => 'Active', 'suspended' => 'Suspended'];
$total = count($customers);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage customers | NABTA Botanical</title>
    <meta name="description" content="NABTA Botanical admin workspace.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">
    <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
    <style>
        .flash { margin: 0 0 16px; padding: 12px 16px; border-radius: 10px; font-size: 14px; }
        .flash.success { background: rgba(130, 152, 117, .25); border: 1px solid rgba(130, 152, 117, .6); }
        .flash.error { background: rgba(176, 80, 64, .2); border: 1px solid rgba(176, 80, 64, .6); }
        .toolbar form { display: contents; }
    </style>
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>

<body class="admin-body botanical-edition workspace-page admin-customers">
    <main id="main">
        <div class="admin-shell">
            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
            <div class="admin-content">
                <div class="admin-top"><span>Workspace / Customers</span>
                    <div class="flex"><span>Nabta Botanical</span><span class="pill">Customers</span></div>
                </div>
                <div class="admin-photo-strip" role="img" aria-label="Soft-focus botanical greenhouse photograph">
                    <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span>
                </div>
                <div class="admin-title">
                    <div>
                        <h1>Customers</h1>
                        <p>Meet the people growing with Nabta.</p>
                    </div><button class="btn" type="button" popovertarget="add">+ Add new</button>
                </div>

                <?php if ($flash): ?>
                    <div class="flash <?= $e($flash['type']) ?>" role="status"><?= $e($flash['message']) ?></div>
                <?php endif; ?>

                <section class="panel">
                    <div class="toolbar">
                        <form class="admin-search" method="get" action="<?= htmlspecialchars(nabta_public_url('admin/customers.php'), ENT_QUOTES, 'UTF-8') ?>">
                            <label class="sr-only" for="search-records">Search customers</label>
                            <input class="control" id="search-records" name="q" type="search"
                                placeholder="Search by name, email or phone" value="<?= $e($search) ?>">
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
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($total === 0): ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center; padding:32px 16px;">
                                            <strong>No customers found</strong>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($customers as $c): $id = (int) $c['user_id']; ?>
                                    <tr>
                                        <td data-label="Customer"><?= $e($c['full_name']) ?></td>
                                        <td data-label="Email"><?= $e($c['email']) ?></td>
                                        <td data-label="Role"><?= $e($roleLabels[$c['role']] ?? $c['role']) ?></td>
                                        <td data-label="Status"><span class="pill"><?= $e($statusLabels[$c['status']] ?? $c['status']) ?></span></td>
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

            <?php foreach ($customers as $c): $id = (int) $c['user_id']; ?>
                <!-- Customer #<?= $id ?> -->
                <section id="view-<?= $id ?>" class="popover" popover aria-labelledby="view-<?= $id ?>-title">
                    <div class="popover-top">
                        <h2 id="view-<?= $id ?>-title">Customer #<?= $id ?></h2><button class="icon-btn" type="button"
                            popovertarget="view-<?= $id ?>" popovertargetaction="hide"
                            aria-label="Close window">×</button>
                    </div>
                    <div class="summary-row"><span>Customer</span><span><?= $e($c['full_name']) ?></span></div>
                    <div class="summary-row"><span>Email</span><span><?= $e($c['email']) ?></span></div>
                    <div class="summary-row"><span>Phone</span><span><?= $e($c['phone'] ?: '—') ?></span></div>
                    <div class="summary-row"><span>Address</span><span><?= $e($c['address'] ?: '—') ?></span></div>
                    <div class="summary-row"><span>Role</span><span><?= $e($roleLabels[$c['role']] ?? $c['role']) ?></span></div>
                    <div class="summary-row"><span>Status</span><span><span class="pill"><?= $e($statusLabels[$c['status']] ?? $c['status']) ?></span></span></div>
                </section>

                <section id="edit-<?= $id ?>" class="popover" popover aria-labelledby="edit-<?= $id ?>-title">
                    <form method="post" action="<?= htmlspecialchars(nabta_public_url('admin/customers.php'), ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="user_id" value="<?= $id ?>">
                        <div class="popover-top">
                            <h2 id="edit-<?= $id ?>-title">Edit customer</h2><button class="icon-btn" type="button"
                                popovertarget="edit-<?= $id ?>" popovertargetaction="hide"
                                aria-label="Close window">×</button>
                        </div>
                        <div class="field"><label for="edit-<?= $id ?>-name">Full name</label><input
                                id="edit-<?= $id ?>-name" name="full_name" type="text" maxlength="100" required
                                value="<?= $e($c['full_name']) ?>"></div>
                        <div class="field"><label for="edit-<?= $id ?>-email">Email</label><input
                                id="edit-<?= $id ?>-email" name="email" type="email" maxlength="150" required
                                value="<?= $e($c['email']) ?>"></div>
                        <div class="form-grid">
                            <div class="field"><label for="edit-<?= $id ?>-phone">Phone</label><input
                                    id="edit-<?= $id ?>-phone" name="phone" type="text" maxlength="30"
                                    value="<?= $e($c['phone']) ?>"></div>
                            <div class="field"><label for="edit-<?= $id ?>-password">New password</label><input
                                    id="edit-<?= $id ?>-password" name="password" type="password" minlength="8"
                                    autocomplete="new-password" placeholder="Leave empty to keep"></div>
                        </div>
                        <div class="field"><label for="edit-<?= $id ?>-address">Address</label><input
                                id="edit-<?= $id ?>-address" name="address" type="text" maxlength="255"
                                value="<?= $e($c['address']) ?>"></div>
                        <div class="form-grid">
                            <div class="field"><label for="edit-<?= $id ?>-role">Role</label><select
                                    id="edit-<?= $id ?>-role" name="role">
                                    <?php foreach ($roleLabels as $value => $label): ?>
                                        <option value="<?= $e($value) ?>" <?= $c['role'] === $value ? 'selected' : '' ?>><?= $e($label) ?></option>
                                    <?php endforeach; ?>
                                </select></div>
                            <div class="field"><label for="edit-<?= $id ?>-status">Status</label><select
                                    id="edit-<?= $id ?>-status" name="status">
                                    <?php foreach ($statusLabels as $value => $label): ?>
                                        <option value="<?= $e($value) ?>" <?= $c['status'] === $value ? 'selected' : '' ?>><?= $e($label) ?></option>
                                    <?php endforeach; ?>
                                </select></div>
                        </div>
                        <button class="btn" type="submit">Save changes</button>
                    </form>
                </section>

                <section id="delete-<?= $id ?>" class="popover" popover aria-labelledby="delete-<?= $id ?>-title">
                    <div class="popover-top">
                        <h2 id="delete-<?= $id ?>-title">Delete this customer?</h2><button class="icon-btn"
                            type="button" popovertarget="delete-<?= $id ?>" popovertargetaction="hide"
                            aria-label="Close window">×</button>
                    </div>
                    <p>You are about to remove <strong><?= $e($c['full_name']) ?></strong>. Customers with orders or
                        reviews cannot be deleted; suspend them instead.</p>
                    <form method="post" action="<?= htmlspecialchars(nabta_public_url('admin/customers.php'), ENT_QUOTES, 'UTF-8') ?>" class="flex" style="margin-top:18px">
                        <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="user_id" value="<?= $id ?>">
                        <button class="btn" type="submit">Delete customer</button>
                        <button class="btn secondary" type="button" popovertarget="delete-<?= $id ?>"
                            popovertargetaction="hide">Keep customer</button>
                    </form>
                </section>
            <?php endforeach; ?>

            <!-- Add new -->
            <section id="add" class="popover" popover aria-labelledby="add-title">
                <form method="post" action="<?= htmlspecialchars(nabta_public_url('admin/customers.php'), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                    <input type="hidden" name="action" value="create">
                    <div class="popover-top">
                        <h2 id="add-title">Create a customer</h2><button class="icon-btn" type="button"
                            popovertarget="add" popovertargetaction="hide" aria-label="Close window">×</button>
                    </div>
                    <div class="field"><label for="new-name">Full name</label><input id="new-name" name="full_name"
                            type="text" maxlength="100" required></div>
                    <div class="field"><label for="new-email">Email</label><input id="new-email" name="email"
                            type="email" maxlength="150" required></div>
                    <div class="form-grid">
                        <div class="field"><label for="new-phone">Phone</label><input id="new-phone" name="phone"
                                type="text" maxlength="30"></div>
                        <div class="field"><label for="new-password">Password</label><input id="new-password"
                                name="password" type="password" minlength="8" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="field"><label for="new-address">Address</label><input id="new-address" name="address"
                            type="text" maxlength="255"></div>
                    <div class="form-grid">
                        <div class="field"><label for="new-role">Role</label><select id="new-role" name="role">
                                <?php foreach ($roleLabels as $value => $label): ?>
                                    <option value="<?= $e($value) ?>"><?= $e($label) ?></option>
                                <?php endforeach; ?>
                            </select></div>
                        <div class="field"><label for="new-status">Status</label><select id="new-status" name="status">
                                <?php foreach ($statusLabels as $value => $label): ?>
                                    <option value="<?= $e($value) ?>"><?= $e($label) ?></option>
                                <?php endforeach; ?>
                            </select></div>
                    </div>
                    <button class="btn" type="submit">Create customer</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
