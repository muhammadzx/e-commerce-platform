<?php if (!$catalogProducts): ?><p>No products match your search. Try another category or search term.</p><?php endif; ?>
<?php foreach ($catalogProducts as $catalogProduct): ?>
<article class="product-card"><a class="product-image" href="<?= e(nabta_public_url('index.php?page=product&id=' . (int)$catalogProduct['pro_id'])) ?>">
<?php $catalogImage = nabta_image_url($catalogProduct['image_url'] ?? '', 640); if ($catalogImage): ?>
<img src="<?= e($catalogImage) ?>" alt="<?= e($catalogProduct['name']) ?>" width="640" height="720" loading="lazy">
<?php else: ?><span class="image-fallback">Image unavailable</span><?php endif; ?></a>
<div class="product-info"><h3><a href="<?= e(nabta_public_url('index.php?page=product&id=' . (int)$catalogProduct['pro_id'])) ?>"><?= e($catalogProduct['name']) ?></a></h3>
<p class="product-price"><?= number_format((float)$catalogProduct['price'],2) ?> JOD</p><p><?= e($catalogProduct['description']) ?></p></div></article>
<?php endforeach; ?>
