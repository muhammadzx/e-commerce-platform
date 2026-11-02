<?php
// Caller provides the package data and a unique dialog ID.
$packageDetailImage = nabta_image_url($packageDetail['image'] ?? '',800) ?: nabta_image_url($packageDetail['fallback_image'] ?? '',800);
if (!$packageDetailImage) foreach ($packageDetail['products'] as $detailProduct) {
    $packageDetailImage = nabta_image_url($detailProduct['image_url'] ?? '',800);
    if ($packageDetailImage) break;
}
?>
<section class="package-detail-popover" popover id="<?= e($packageDetailId) ?>" role="dialog" aria-modal="true" aria-labelledby="<?= e($packageDetailId) ?>-title">
<div class="package-detail-heading"><div><p class="package-detail-eyebrow">PACKAGE DETAILS</p><h2 id="<?= e($packageDetailId) ?>-title"><?= e($packageDetail['name']) ?></h2></div><button class="package-detail-close" type="button" popovertarget="<?= e($packageDetailId) ?>" popovertargetaction="hide" aria-label="Close package details">&times;</button></div>
<?php if ($packageDetailImage): ?><img class="package-detail-image" src="<?= e($packageDetailImage) ?>" alt="<?= e($packageDetail['name']) ?>" width="800" height="400" loading="lazy"><?php endif; ?>
<?php if (!empty($packageDetail['description'])): ?><p class="package-detail-description"><?= nl2br(e($packageDetail['description'])) ?></p><?php endif; ?>
<h3>All products (<?= count($packageDetail['products']) ?>)</h3>
<ol class="package-detail-products"><?php foreach ($packageDetail['products'] as $detailProduct): ?>
<li><div><?php if (($detailProduct['status'] ?? 'active') === 'active'): ?><a href="<?= e(nabta_public_url('index.php?page=product&id='.(int)$detailProduct['pro_id'])) ?>"><?= e($detailProduct['name']) ?></a><?php else: ?><strong><?= e($detailProduct['name']) ?></strong><?php endif; ?><small>Quantity <?= (int)$detailProduct['quantity'] ?> &times; <?= number_format((float)$detailProduct['price'],2) ?> JOD each</small></div><strong><?= number_format((float)$detailProduct['price']*(int)$detailProduct['quantity'],2) ?> JOD</strong></li>
<?php endforeach; ?></ol>
<dl class="package-detail-totals"><div><dt>Individual total</dt><dd><?= number_format((float)$packageDetail['original_price'],2) ?> JOD</dd></div><div><dt>Discount</dt><dd><?= number_format((float)$packageDetail['discount'],2) ?>%</dd></div><div><dt>You save</dt><dd><?= number_format((float)$packageDetail['saving'],2) ?> JOD</dd></div><div class="package-detail-total"><dt>Package price</dt><dd><?= number_format((float)$packageDetail['price'],2) ?> JOD</dd></div><div><dt>Available packages</dt><dd><?= (int)$packageDetail['available_sets'] ?></dd></div></dl>
</section>
