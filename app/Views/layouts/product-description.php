<?php
// Caller supplies escaped-on-output product data and a unique description ID.
$descriptionText = (string) ($descriptionProduct['description'] ?? '');
?>
<div class="product-description-preview" data-description-preview>
  <div class="product-description-text"><?= nl2br(htmlspecialchars($descriptionText, ENT_QUOTES, 'UTF-8')) ?></div>
  <button class="product-description-more" type="button" popovertarget="<?= htmlspecialchars($descriptionId, ENT_QUOTES, 'UTF-8') ?>" hidden>See more</button>
</div>
<section class="package-detail-popover product-description-dialog" popover id="<?= htmlspecialchars($descriptionId, ENT_QUOTES, 'UTF-8') ?>" aria-labelledby="<?= htmlspecialchars($descriptionId, ENT_QUOTES, 'UTF-8') ?>-title">
  <div class="package-detail-heading"><h2 id="<?= htmlspecialchars($descriptionId, ENT_QUOTES, 'UTF-8') ?>-title"><?= htmlspecialchars((string) $descriptionProduct['name'], ENT_QUOTES, 'UTF-8') ?></h2><button class="package-detail-close" type="button" popovertarget="<?= htmlspecialchars($descriptionId, ENT_QUOTES, 'UTF-8') ?>" popovertargetaction="hide" aria-label="Close description">&times;</button></div>
  <p class="product-description-full"><?= nl2br(htmlspecialchars($descriptionText, ENT_QUOTES, 'UTF-8')) ?></p>
</section>
