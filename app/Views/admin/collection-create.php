<?php $pageTitle = $isEditing ? 'Edit package' : 'Add package'; $selected = array_map('strval',$old['selected']); ?>
<!doctype html><html lang="en"><head><?php require __DIR__ . '/../layouts/admin-collection-head.php'; ?>
<script src="<?= e(nabta_public_url('assets/js/admin-collections.js?v='.filemtime(__DIR__.'/../../../public/assets/js/admin-collections.js'))) ?>" defer></script></head>
<body class="admin-body botanical-edition workspace-page admin-collections"><main id="main" tabindex="-1"><div class="admin-shell">
<?php require __DIR__ . '/../layouts/admin-sidebar.html'; ?>
<div class="admin-content"><?php $adminHeaderTitle = $pageTitle; require __DIR__ . '/../layouts/admin-header.php'; ?>
<div class="admin-title"><div><h1><?= e($pageTitle) ?></h1><p>Choose the products, quantities and discount for a coordinated package.</p></div></div>
<?php if ($error): ?><p class="field-error collection-notice" role="alert"><?= e($error) ?><?php if (!empty($_FILES['image']['name'])): ?> Please select your image again before resubmitting.<?php endif; ?></p><?php endif; ?>
<form class="collection-editor" method="post" enctype="multipart/form-data" id="collection-form">
<input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
<div class="collection-editor-main"><section class="panel"><h2>Package details</h2><div class="collection-fields">
<label for="collection-name">Name <span>(required)</span><input class="control" id="collection-name" name="name" value="<?= e($old['name']) ?>" minlength="2" maxlength="150" required></label>
<label for="collection-description">Description <span>(optional)</span><textarea class="control" id="collection-description" name="description" rows="4" maxlength="5000"><?= e($old['description']) ?></textarea></label>
<div class="collection-field-pair"><label for="collection-discount">Discount (%)<input class="control" id="collection-discount" type="number" name="discount" min="0" max="99" step="0.01" value="<?= e($old['discount']) ?>" required></label>
<label for="collection-status">Visibility<select class="control" id="collection-status" name="status"><option value="active" <?= $old['status']==='active'?'selected':'' ?>>Published</option><option value="inactive" <?= $old['status']==='inactive'?'selected':'' ?>>Hidden</option></select></label></div>
<label for="collection-image">Package image <span>(optional)</span><input class="control" id="collection-image" type="file" name="image" accept="image/jpeg,image/png,image/webp" aria-describedby="collection-image-help"></label><p class="small" id="collection-image-help">JPG, PNG or WebP up to 5 MB. <?= $isEditing ? 'Leave empty to keep the current image.' : 'Without an upload, the storefront uses a selected product image.' ?></p>
<?php if ($isEditing && !empty($existing['image'])): ?><label class="package-remove-image"><input type="checkbox" name="remove_image" value="1" <?= !empty($_POST['remove_image']) ? 'checked' : '' ?>> Remove current image and use a product image instead</label><?php endif; ?>
<?php $existingImage=nabta_image_url($existing['image'] ?? '',800); ?>
<img id="collection-image-preview" class="collection-preview-image" data-managed-preview alt="Package image preview" <?= $existingImage ? 'src="'.e($existingImage).'"' : 'hidden' ?> data-existing-image="<?= e($existingImage) ?>">
</div></section>
<section class="panel"><h2>Products in this package</h2><p>Select at least one product. Quantities are per package; saving a package does not reduce stock.</p>
<div class="collection-product-filters" id="collection-product-filters" hidden>
<label class="collection-product-search" for="collection-product-search">Find a product<input class="control" id="collection-product-search" type="search" placeholder="Search by name or category"></label>
<label for="collection-filter-category">Category<select class="control" id="collection-filter-category"><option value="">All categories</option><?php $filterCategories=array_unique(array_map(static fn($p)=>(string)$p['category'],$products)); sort($filterCategories); foreach ($filterCategories as $filterCategory): ?><option value="<?= e($filterCategory) ?>"><?= e($filterCategory ?: 'Uncategorized') ?></option><?php endforeach; ?></select></label>
<label for="collection-filter-stock">Stock<select class="control" id="collection-filter-stock"><option value="">All stock levels</option><option value="in">In stock</option><option value="low">Low stock (1–5)</option><option value="out">Out of stock</option></select></label>
<label for="collection-filter-min">Min price (JOD)<input class="control" id="collection-filter-min" inputmode="decimal" placeholder="No minimum"></label>
<label for="collection-filter-max">Max price (JOD)<input class="control" id="collection-filter-max" inputmode="decimal" placeholder="No maximum"></label>
<label for="collection-filter-selection">Selection<select class="control" id="collection-filter-selection"><option value="">All products</option><option value="selected">Selected only</option><option value="unselected">Not selected</option></select></label>
<label for="collection-filter-sort">Sort by<select class="control" id="collection-filter-sort"><option value="name">Name A–Z</option><option value="price_low">Price: low to high</option><option value="price_high">Price: high to low</option><option value="stock_low">Lowest stock first</option></select></label>
<div class="collection-filter-actions"><button class="btn secondary" type="button" id="collection-filter-reset">Reset filters</button></div>
</div>
<p id="collection-product-search-status" role="status" class="small"></p>
<div class="collection-product-list">
<?php foreach ($products as $product): $id=(int)$product['pro_id']; $checked=in_array((string)$id,$selected,true); ?>
<div class="collection-product-row" data-collection-product data-name="<?= e(mb_strtolower($product['name'].' '.$product['category'])) ?>" data-category="<?= e($product['category'] ?? '') ?>" data-price="<?= e($product['price']) ?>" data-stock="<?= $product['status'] === 'active' ? (int)$product['stock'] : 0 ?>">
<label class="collection-product-choice"><input type="checkbox" name="selected[]" value="<?= $id ?>" <?= $checked?'checked':'' ?>><span><strong><?= e($product['name']) ?></strong><small><?= e($product['category']) ?> · <?= number_format((float)$product['price'],2) ?> JOD · <?= $product['status'] === 'active' ? (int)$product['stock'].' in stock' : 'Inactive — remove or replace before publishing' ?></small></span></label>
<label class="collection-item-quantity" for="collection-qty-<?= $id ?>">Qty per package<input class="control" type="number" id="collection-qty-<?= $id ?>" name="quantities[<?= $id ?>]" value="<?= e($old['quantities'][$id] ?? 1) ?>" min="1" max="999" step="1" aria-label="Quantity per package for <?= e($product['name']) ?>"></label>
</div><?php endforeach; ?></div>
<?php if (!$products): ?><p>No active products are available. <a href="<?= e(nabta_public_url('admin/products.php')) ?>">Add a product first</a>.</p><?php endif; ?>
</section></div>
<aside class="panel collection-summary" aria-labelledby="collection-summary-title"><h2 id="collection-summary-title">Package summary</h2><dl class="collection-totals"><div><dt>Selected products</dt><dd id="collection-selected-count">0</dd></div><div><dt>Individual total</dt><dd id="collection-subtotal">0.00 JOD</dd></div><div><dt>Discount</dt><dd id="collection-discount-total">0.00 JOD</dd></div><div><dt>Package price</dt><dd id="collection-final-price">0.00 JOD</dd></div><div><dt>Available packages</dt><dd id="collection-available">0</dd></div></dl>
<p class="small" id="collection-summary-status" role="status">Select products to preview this package.</p><p class="small">Prices and availability are calculated from current product records. Published packages appear in the storefront.</p>
<div class="collection-save-actions"><button class="btn" type="submit" <?= !$products?'disabled':'' ?>><?= $isEditing ? 'Save changes' : 'Create package' ?></button><a class="btn secondary" href="<?= e(nabta_public_url('admin/collections.php')) ?>">Cancel</a></div>
<noscript><p class="small">You can save this form without JavaScript. The final price is calculated on the server from the products and discount you select.</p></noscript>
</aside></form></div></div></main></body></html>
