<?php
require_once __DIR__ . '/../../../config/paths.php';
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
// Opened directly (not through the controller): send the visitor to the real page
if (!isset($categories)) {
    header('Location: ' . nabta_public_url('admin/categories.php'));
    exit;
}

// Provided by AdminCategoryController: $categories, $search, $flash, $csrfToken
$e = static fn($value) => AdminSupport::e($value);
$total = count($categories);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage categories | NABTA Botanical</title>
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

<body class="admin-body botanical-edition workspace-page admin-categories">
    <main id="main">
        <div class="admin-shell">
            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
            <div class="admin-content">
                <div class="admin-top"><span>Workspace / Categories</span>
                    <div class="flex"><span>Nabta Botanical</span><span class="pill">Categories</span></div>
                </div>
                <div class="admin-photo-strip" role="img" aria-label="Soft-focus botanical greenhouse photograph">
                    <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span>
                </div>
                <div class="admin-title">
                    <div>
                        <h1>Categories</h1>
                        <p>A clear place for every growing essential.</p>
                    </div><button class="btn" type="button" popovertarget="add">+ Add new</button>
                </div>

                <?php if ($flash): ?>
                    <div class="flash <?= $e($flash['type']) ?>" role="status"><?= $e($flash['message']) ?></div>
                <?php endif; ?>

                <section class="panel">
                    <div class="toolbar">
                        <form method="get" action="<?= htmlspecialchars(nabta_public_url('admin/categories.php'), ENT_QUOTES, 'UTF-8') ?>">
                            <label class="sr-only" for="search-records">Search categories</label>
                            <input class="control" id="search-records" name="q" type="search"
                                placeholder="Search categories" value="<?= $e($search) ?>">
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
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($total === 0): ?>
                                    <tr>
                                        <td colspan="4" style="text-align:center; padding:32px 16px;">
                                            <strong>No categories found</strong>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($categories as $c): $id = (int) $c['cat_id']; ?>
                                    <tr>
                                        <td data-label="Category"><?= $e($c['name']) ?></td>
                                        <td data-label="Description"><?= $e($c['description'] ?: '—') ?></td>
                                        <td data-label="Products"><?= (int) $c['products_count'] ?></td>
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

            <?php foreach ($categories as $c): $id = (int) $c['cat_id']; ?>
                <!-- Category #<?= $id ?> -->
                <section id="view-<?= $id ?>" class="popover" popover aria-labelledby="view-<?= $id ?>-title">
                    <div class="popover-top">
                        <h2 id="view-<?= $id ?>-title">Category #<?= $id ?></h2><button class="icon-btn" type="button"
                            popovertarget="view-<?= $id ?>" popovertargetaction="hide"
                            aria-label="Close window">×</button>
                    </div>
                    <div class="summary-row"><span>Category</span><span><?= $e($c['name']) ?></span></div>
                    <div class="summary-row"><span>Description</span><span><?= $e($c['description'] ?: '—') ?></span></div>
                    <div class="summary-row"><span>Products</span><span><?= (int) $c['products_count'] ?></span></div>
                </section>

                <section id="edit-<?= $id ?>" class="popover" popover aria-labelledby="edit-<?= $id ?>-title">
                    <form method="post" action="<?= htmlspecialchars(nabta_public_url('admin/categories.php'), ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="cat_id" value="<?= $id ?>">
                        <div class="popover-top">
                            <h2 id="edit-<?= $id ?>-title">Edit category</h2><button class="icon-btn" type="button"
                                popovertarget="edit-<?= $id ?>" popovertargetaction="hide"
                                aria-label="Close window">×</button>
                        </div>
                        <div class="field"><label for="edit-<?= $id ?>-name">Name</label><input
                                id="edit-<?= $id ?>-name" name="name" type="text" maxlength="100" required
                                value="<?= $e($c['name']) ?>"></div>
                        <div class="field"><label for="edit-<?= $id ?>-description">Description</label><textarea
                                id="edit-<?= $id ?>-description" name="description" rows="3"
                                maxlength="1000"><?= $e($c['description']) ?></textarea></div>
                        <button class="btn" type="submit">Save changes</button>
                    </form>
                </section>

                <section id="delete-<?= $id ?>" class="popover" popover aria-labelledby="delete-<?= $id ?>-title">
                    <div class="popover-top">
                        <h2 id="delete-<?= $id ?>-title">Delete this category?</h2><button class="icon-btn"
                            type="button" popovertarget="delete-<?= $id ?>" popovertargetaction="hide"
                            aria-label="Close window">×</button>
                    </div>
                    <p>You are about to remove <strong><?= $e($c['name']) ?></strong>.
                        <?php if ((int) $c['products_count'] > 0): ?>
                            This category still has <?= (int) $c['products_count'] ?> product(s), so it cannot be deleted
                            until they are moved or removed.
                        <?php else: ?>
                            This cannot be undone.
                        <?php endif; ?>
                    </p>
                    <form method="post" action="<?= htmlspecialchars(nabta_public_url('admin/categories.php'), ENT_QUOTES, 'UTF-8') ?>" class="flex" style="margin-top:18px">
                        <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="cat_id" value="<?= $id ?>">
                        <button class="btn" type="submit">Delete category</button>
                        <button class="btn secondary" type="button" popovertarget="delete-<?= $id ?>"
                            popovertargetaction="hide">Keep category</button>
                    </form>
                </section>
            <?php endforeach; ?>

            <!-- Add new -->
            <section id="add" class="popover" popover aria-labelledby="add-title">
                <form method="post" action="<?= htmlspecialchars(nabta_public_url('admin/categories.php'), ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="csrf_token" value="<?= $e($csrfToken) ?>">
                    <input type="hidden" name="action" value="create">
                    <div class="popover-top">
                        <h2 id="add-title">Create a category</h2><button class="icon-btn" type="button"
                            popovertarget="add" popovertargetaction="hide" aria-label="Close window">×</button>
                    </div>
                    <div class="field"><label for="new-name">Name</label><input id="new-name" name="name" type="text"
                            maxlength="100" required></div>
                    <div class="field"><label for="new-description">Description</label><textarea id="new-description"
                            name="description" rows="3" maxlength="1000"></textarea></div>
                    <button class="btn" type="submit">Create category</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
