<?php $pageTitle = 'Packages'; ?>
<!doctype html><html lang="en"><head><?php require __DIR__ . '/../layouts/admin-collection-head.php'; ?></head>
<body class="admin-body botanical-edition workspace-page admin-collections"><main id="main" tabindex="-1"><div class="admin-shell">
<?php require __DIR__ . '/../layouts/admin-sidebar.html'; ?>
<div class="admin-content"><?php $adminHeaderTitle = 'Packages'; require __DIR__ . '/../layouts/admin-header.php'; ?>
<div class="admin-title"><div><h1>Packages</h1><p>Curated packages with product quantities and a shared discount.</p></div><a class="btn" href="<?= e(nabta_public_url('admin/collection-create.php')) ?>">+ Add package</a></div>
<?php if ($flash): ?><p class="collection-notice" role="status"><?= e($flash['message']) ?></p><?php endif; ?>
<section class="panel"><div class="collection-list-heading"><h2>All packages</h2><span class="pill"><?= count($collections) ?> packages</span></div>
<div class="admin-collection-grid">
<?php foreach ($collections as $collection): $image=nabta_image_url($collection['image'] ?? '',640); if (!$image) { foreach ($collection['products'] as $productImage) { $image=nabta_image_url($productImage['image_url'] ?? '',640); if ($image) break; } } ?>
<article class="admin-collection-card">
<?php if ($image): ?><img src="<?= e($image) ?>" alt="<?= e($collection['name']) ?>" width="640" height="360" loading="lazy"><?php else: ?><div class="image-fallback">No image available</div><?php endif; ?>
<div class="admin-collection-card-content"><span class="pill"><?= $collection['status'] === 'active' ? 'Published' : 'Hidden' ?></span><h3><?= e($collection['name']) ?></h3><div class="package-card-actions"><a class="btn" href="<?= e(nabta_public_url('admin/collection-edit.php?id='.(int)$collection['collection_id'])) ?>" aria-label="Edit <?= e($collection['name']) ?>">Edit</a><button class="btn package-delete-button" type="button" popovertarget="delete-package-<?= (int)$collection['collection_id'] ?>" aria-label="Delete <?= e($collection['name']) ?>">Delete</button></div><p><?= e($collection['description'] ?? '') ?></p>
<ul class="package-products-preview"><?php foreach (array_slice($collection['products'],0,3) as $product): ?><li><?= e($product['name']) ?> &times; <?= (int)$product['quantity'] ?></li><?php endforeach; ?></ul>
<?php if (count($collection['products']) > 3): ?><button class="package-show-more" type="button" popovertarget="admin-package-details-<?= (int)$collection['collection_id'] ?>" aria-label="Show all <?= count($collection['products']) ?> products and details for <?= e($collection['name']) ?>">Show more <span aria-hidden="true">(+<?= count($collection['products'])-3 ?>)</span></button><?php endif; ?>
<dl class="collection-totals"><div><dt>Individual total</dt><dd><?= number_format((float)$collection['original_price'],2) ?> JOD</dd></div><div><dt>Discount</dt><dd><?= number_format((float)$collection['discount'],2) ?>%</dd></div><div><dt>Package price</dt><dd><?= number_format((float)$collection['price'],2) ?> JOD</dd></div><div><dt>Available packages</dt><dd><?= (int)$collection['available_sets'] ?></dd></div></dl>

</div></article><?php endforeach; ?>
<?php if (!$collections): ?><p>No packages yet. Use Add package to create your first package.</p><?php endif; ?>
</div></section></div></div>
<?php foreach ($collections as $collection): $packageId=(int)$collection['collection_id']; ?>
<?php if (count($collection['products']) > 3): $packageDetail=$collection; $packageDetailId='admin-package-details-'.$packageId; require __DIR__ . '/../layouts/package-details.php'; endif; ?>
<section class="popover" popover id="delete-package-<?= $packageId ?>" aria-labelledby="delete-package-title-<?= $packageId ?>"><div class="popover-top"><h2 id="delete-package-title-<?= $packageId ?>">Delete package?</h2><button class="icon-btn" type="button" popovertarget="delete-package-<?= $packageId ?>" popovertargetaction="hide" aria-label="Close window">&times;</button></div><p>Remove <strong><?= e($collection['name']) ?></strong> from package management and the storefront? Existing orders and reviews will be kept.</p><form class="package-confirm-actions" method="post"><input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="package_id" value="<?= $packageId ?>"><button class="btn package-delete-button" type="submit">Delete package</button><button class="btn secondary" type="button" popovertarget="delete-package-<?= $packageId ?>" popovertargetaction="hide">Keep package</button></form></section>
<?php endforeach; ?></main></body></html>
