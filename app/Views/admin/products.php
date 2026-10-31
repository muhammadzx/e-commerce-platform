<?php
require_once __DIR__ . '/../../../config/paths.php';
$openEditProductId = filter_input(INPUT_GET, 'edit_product', FILTER_VALIDATE_INT);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage products | NABTA Botanical</title>
    <meta name="description" content="Manage NABTA Botanical products and product images.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">
    <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="admin-body botanical-edition workspace-page admin-products">
<main id="main">
    <div class="admin-shell">
        <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
        <div class="admin-content">
            <div class="admin-top">
                <span>Workspace / Products</span>
                <div class="flex"><span>Nabta Botanical</span><span class="pill">Products</span></div>
            </div>

            <div class="admin-photo-strip" role="img" aria-label="Botanical greenhouse">
                <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span>
            </div>

            <div class="admin-title">
                <div>
                    <h1>Products</h1>
                    <p>Manage products, stock, categories, and product photos.</p>
                </div>
                <button class="btn" type="button" popovertarget="add-product">+ Add new</button>
            </div>

            <?php if (!empty($message)): ?>
                <p role="status" class="product-message <?= htmlspecialchars($messageType ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>

            <section class="panel">
                <div class="toolbar">
                    <form method="get" action="products.php" class="table-actions">
                        <label class="sr-only" for="search-records">Search products</label>
                        <input class="control" id="search-records" name="search" type="search"
                               value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>"
                               placeholder="Search products">
                        <button class="btn secondary" type="submit">Search</button>
                    </form>
                    <span class="label"><?= count($products) ?> records</span>
                </div>

                <div class="table-scroll">
                    <table>
                        <thead>
                        <tr>
                            <th>Product</th><th>Category</th><th>Price</th>
                            <th>Stock</th><th>Status</th><th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($products)): ?>
                            <tr><td colspan="6">No products found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <?php $productId = (int) $product['pro_id']; ?>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product">
                                            <?php if (!empty($product['image_url'])): ?>
                                                <img src="<?= htmlspecialchars($product['image_url'], ENT_QUOTES, 'UTF-8') ?>"
                                                     alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                                            <?php else: ?>
                                                <span>No image</span>
                                            <?php endif; ?>
                                            <span><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                        </div>
                                    </td>
                                    <td data-label="Category"><?= htmlspecialchars($product['category'] ?? 'Uncategorized', ENT_QUOTES, 'UTF-8') ?></td>
                                    <td data-label="Price"><?= number_format((float) $product['price'], 2) ?> JOD</td>
                                    <td data-label="Stock"><?= (int) $product['quantity'] ?></td>
                                    <td data-label="Status"><span class="pill"><?= htmlspecialchars($product['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions">
                                            <button class="table-button" type="button" popovertarget="view-product-<?= $productId ?>">View</button>
                                            <button class="table-button" type="button" popovertarget="edit-product-<?= $productId ?>">Edit</button>
                                            <form method="post" action="products.php">
                                                <input type="hidden" name="action" value="hide">
                                                <input type="hidden" name="product_id" value="<?= $productId ?>">
                                                <button class="table-button" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <?php foreach ($products as $product): ?>
            <?php
            $productId = (int) $product['pro_id'];
            $images = $productImages[$productId] ?? [];
            ?>
            <section id="view-product-<?= $productId ?>" class="popover" popover
                     aria-labelledby="view-title-<?= $productId ?>">
                <div class="popover-top">
                    <h2 id="view-title-<?= $productId ?>">Product details</h2>
                    <button class="icon-btn" type="button" popovertarget="view-product-<?= $productId ?>"
                            popovertargetaction="hide" aria-label="Close">×</button>
                </div>
                <div class="summary-row"><span>Name</span><span><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></span></div>
                <div class="summary-row"><span>Category</span><span><?= htmlspecialchars($product['category'] ?? 'Uncategorized', ENT_QUOTES, 'UTF-8') ?></span></div>
                <div class="summary-row"><span>Price</span><span><?= number_format((float) $product['price'], 2) ?> JOD</span></div>
                <div class="summary-row"><span>Stock</span><span><?= (int) $product['quantity'] ?></span></div>
                <div class="summary-row"><span>Sold</span><span><?= (int) $product['count_selling'] ?></span></div>
                <div class="summary-row"><span>Status</span><span><?= htmlspecialchars($product['status'], ENT_QUOTES, 'UTF-8') ?></span></div>
                <h3>Product images</h3>
                <div class="product-image-gallery">
                    <?php if (empty($images)): ?>
                        <p>No images have been added.</p>
                    <?php else: ?>
                        <?php foreach ($images as $image): ?>
                            <div class="product-image-card">
                                <img src="<?= htmlspecialchars($image['image_url'], ENT_QUOTES, 'UTF-8') ?>"
                                     alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                                <?php if ((int) $image['is_primary'] === 1): ?>
                                    <span class="pill">Primary image</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section id="edit-product-<?= $productId ?>" class="popover" popover
                     aria-labelledby="edit-title-<?= $productId ?>">
                <div class="popover-top">
                    <h2 id="edit-title-<?= $productId ?>">Edit product</h2>
                    <button class="icon-btn" type="button" popovertarget="edit-product-<?= $productId ?>"
                            popovertargetaction="hide" aria-label="Close">×</button>
                </div>

                <?php if (!empty($message) && (int) $openEditProductId === $productId): ?>
                    <p role="status" class="product-message <?= htmlspecialchars($messageType ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>

                <form class="product-form" method="post" action="products.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="product_id" value="<?= $productId ?>">
                    <div class="field">
                        <label for="category-<?= $productId ?>">Category</label>
                        <select id="category-<?= $productId ?>" name="cat_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int) $category['cat_id'] ?>" <?= (int) $category['cat_id'] === (int) $product['cat_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label for="name-<?= $productId ?>">Product name</label>
                        <input id="name-<?= $productId ?>" name="name" type="text"
                               value="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="field">
                        <label for="description-<?= $productId ?>">Description</label>
                        <textarea id="description-<?= $productId ?>" name="description"><?= htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                    <div class="form-grid">
                        <div class="field">
                            <label for="price-<?= $productId ?>">Price (JOD)</label>
                            <input id="price-<?= $productId ?>" name="price" type="number" min="0.01" step="0.01"
                                   value="<?= htmlspecialchars((string) $product['price'], ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="field">
                            <label for="quantity-<?= $productId ?>">Quantity</label>
                            <input id="quantity-<?= $productId ?>" name="quantity" type="number" min="0"
                                   value="<?= (int) $product['quantity'] ?>" required>
                        </div>
                    </div>
                    <div class="field product-image-upload" data-image-upload>
                        <div class="product-image-upload-heading">
                            <label for="images-<?= $productId ?>">Add more images</label>
                            <button class="image-add-button" type="button" data-add-image-input
                                    aria-label="Add another image">+</button>
                        </div>
                        <div class="image-input-list" data-image-input-list>
                            <div class="image-input-row">
                                <input id="images-<?= $productId ?>" type="file" name="images[]"
                                       accept="image/jpeg,image/png,image/webp">
                            </div>
                        </div>
                    </div>
                    <button class="btn" type="submit">Save changes</button>
                </form>

                <div class="product-image-management">
                    <h3>Current product images</h3>
                    <?php if (empty($images)): ?>
                        <p>No images have been added.</p>
                    <?php else: ?>
                        <div class="product-image-gallery">
                            <?php foreach ($images as $image): ?>
                                <?php $imageId = (int) $image['image_id']; ?>
                                <div class="product-image-card">
                                    <img src="<?= htmlspecialchars($image['image_url'], ENT_QUOTES, 'UTF-8') ?>"
                                         alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?php if ((int) $image['is_primary'] === 1): ?>
                                        <span class="pill">Primary image</span>
                                    <?php else: ?>
                                        <form method="post" action="products.php">
                                            <input type="hidden" name="action" value="set_primary_image">
                                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                                            <input type="hidden" name="image_id" value="<?= $imageId ?>">
                                            <button class="table-button" type="submit">Make primary</button>
                                        </form>
                                    <?php endif; ?>

                                    <form method="post" action="products.php" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="replace_image">
                                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                                        <input type="hidden" name="image_id" value="<?= $imageId ?>">
                                        <label for="replace-image-<?= $imageId ?>">Replace image</label>
                                        <input id="replace-image-<?= $imageId ?>" type="file" name="replacement_image"
                                               accept="image/jpeg,image/png,image/webp" required>
                                        <button class="table-button" type="submit">Replace</button>
                                    </form>

                                    <form method="post" action="products.php">
                                        <input type="hidden" name="action" value="delete_image">
                                        <input type="hidden" name="product_id" value="<?= $productId ?>">
                                        <input type="hidden" name="image_id" value="<?= $imageId ?>">
                                        <button class="table-button" type="submit">Remove image</button>
                                    </form>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <section id="add-product" class="popover" popover aria-labelledby="add-product-title">
            <div class="popover-top">
                <h2 id="add-product-title">Add product</h2>
                <button class="icon-btn" type="button" popovertarget="add-product"
                        popovertargetaction="hide" aria-label="Close">×</button>
            </div>
            <form class="product-form" method="post" action="products.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="field">
                    <label for="add-category">Category</label>
                    <select id="add-category" name="cat_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['cat_id'] ?>">
                                <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="add-name">Product name</label>
                    <input id="add-name" name="name" type="text" required>
                </div>
                <div class="field">
                    <label for="add-description">Description</label>
                    <textarea id="add-description" name="description"></textarea>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label for="add-price">Price (JOD)</label>
                        <input id="add-price" name="price" type="number" min="0.01" step="0.01" required>
                    </div>
                    <div class="field">
                        <label for="add-quantity">Quantity</label>
                        <input id="add-quantity" name="quantity" type="number" min="0" required>
                    </div>
                </div>
                <div class="field product-image-upload" data-image-upload>
                    <div class="product-image-upload-heading">
                        <label for="add-images">Product images</label>
                        <button class="image-add-button" type="button" data-add-image-input
                                aria-label="Add another image">+</button>
                    </div>
                    <div class="image-input-list" data-image-input-list>
                        <div class="image-input-row">
                            <input id="add-images" type="file" name="images[]"
                                   accept="image/jpeg,image/png,image/webp">
                        </div>
                    </div>
                </div>
                <button class="btn" type="submit">Add product</button>
            </form>
        </section>
    </div>
</main>
<script>
document.querySelectorAll('[data-image-upload]').forEach((group) => {
    const addButton = group.querySelector('[data-add-image-input]');
    const inputList = group.querySelector('[data-image-input-list]');

    addButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'image-input-row';

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.accept = 'image/jpeg,image/png,image/webp';
        input.setAttribute('aria-label', 'Additional product image');

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'image-remove-input';
        removeButton.textContent = '×';
        removeButton.setAttribute('aria-label', 'Remove this image field');
        removeButton.addEventListener('click', () => row.remove());

        row.append(input, removeButton);
        inputList.append(row);
        input.focus();
    });
});

const editProductId = <?= json_encode($openEditProductId ?: 0) ?>;
if (editProductId > 0) {
    const editPopover = document.getElementById(`edit-product-${editProductId}`);
    if (editPopover && typeof editPopover.showPopover === 'function') {
        editPopover.showPopover();
    }
}
</script>
</body>
</html>
