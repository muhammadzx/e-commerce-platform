<?php
// "Good things grow better together" section of the landing page, read from the
// database (collections + collections_details) instead of static markup.
// Uses the same classes as bundlesLandingPage.css and the add-to-cart button of cart.js.
require_once __DIR__ . '/../../Models/Collection.php';

$cxCollections = [];

try {
    $cxCollections = (static function (): array {
        require __DIR__ . '/../../../config/connection.php';

        return (new Collection($db))->getActive();
    })();
} catch (Throwable $exception) {
    error_log('Nabta collections section: ' . $exception->getMessage());
}

// The landing page shows only a few sets: the ones in stock first, then the newest
// (the collections page sets $cxLimit before including this file to show them all)
$cxLimit = $cxLimit ?? 4;

usort($cxCollections, static fn(array $a, array $b): int =>
    ((int) $b['available_sets'] > 0) <=> ((int) $a['available_sets'] > 0)
    ?: (int) $b['collection_id'] <=> (int) $a['collection_id']);
$cxCollections = array_slice($cxCollections, 0, $cxLimit);

$cxMoney = static fn(float $amount): string => number_format($amount, 2) . ' JOD';
$cxImage = static fn(?string $path): string => nabta_image_url($path, 800);
?>

<meta name="cart-csrf" content="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
<section class="section bundles-section" id="bundles" aria-labelledby="bundles-title">
  <div class="container">
    <div class="section-head-v3">
      <div><span class="eyebrow">Thoughtfully paired</span>
        <h2 id="bundles-title">Good things grow<br><em>better together.</em></h2>
      </div>
      <div class="section-intro-v3">
        <p>Considered combinations, made easy: everything in the set is chosen to work beautifully together.</p>
        <a class="text-link" href="<?= htmlspecialchars(nabta_public_url('index.php?page=products'), ENT_QUOTES, 'UTF-8') ?>">Explore the whole store <span aria-hidden="true">↗</span></a>
      </div>
    </div>
    <div class="bundle-grid">
      <?php foreach ($cxCollections as $collection): ?>
        <?php
        $count = count($collection['products']);
        $image = $cxImage($collection['image'] ?? null) ?: $cxImage($collection['fallback_image'] ?? null);
        $inStock = (int) $collection['available_sets'] > 0;
        $saving = (float) $collection['saving'];
        ?>
        <article class="bundle-card">
          <div class="bundle-photo">
            <?php if ($image): ?>
              <img src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($collection['name'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy" width="900" height="1000">
            <?php endif; ?>
            <span class="bundle-set-badge"><?= $count ?> <?= $count === 1 ? 'piece' : 'pieces' ?> · one thoughtful set</span>
            <?php if ((float) $collection['discount'] > 0): ?>
              <span class="bundle-saving-badge">Save <?= rtrim(rtrim(number_format((float) $collection['discount'], 2), '0'), '.') ?>%</span>
            <?php endif; ?>
          </div>
          <div class="bundle-card-body">
            <div class="bundle-card-kicker"><span class="bundle-kicker-mark" aria-hidden="true">✳</span><span>THE NABTA EDIT</span><span class="bundle-count-pill"><?= $count ?> <?= $count === 1 ? 'item' : 'items' ?></span></div>
            <h3><?= htmlspecialchars($collection['name'], ENT_QUOTES, 'UTF-8') ?></h3>
            <p class="bundle-description"><?= htmlspecialchars((string) $collection['description'], ENT_QUOTES, 'UTF-8') ?></p>
            <div class="bundle-items-heading">Inside this set</div>
            <div class="bundle-items-list" aria-label="Products included in <?= htmlspecialchars($collection['name'], ENT_QUOTES, 'UTF-8') ?>">
              <?php foreach ($collection['products'] as $product): ?>
                <span><a href="<?= htmlspecialchars(nabta_public_url('index.php?page=product&id=' . (int)$product['pro_id']), ENT_QUOTES, 'UTF-8') ?>"><?php /* included product */ ?><i aria-hidden="true">&#10003;</i><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?><?= (int) $product['quantity'] > 1 ? ' &times; ' . (int) $product['quantity'] : '' ?></a></span>
              <?php endforeach; ?>
            </div>
            <div class="bundle-card-bottom">
              <div class="bundle-price-row">
                <div><small class="bundle-price-label">Set price</small><strong><?= $cxMoney((float) $collection['price']) ?></strong></div>
                <?php if ($saving > 0): ?>
                  <div class="bundle-compare-price"><span>Individual total</span><del><?= $cxMoney((float) $collection['original_price']) ?></del><small>You save <?= $cxMoney($saving) ?></small></div>
                <?php endif; ?>
              </div>
              <?php if ($inStock): ?>
                <button class="btn btn-primary bundle-add-button" type="button" data-collection-id="<?= (int) $collection['collection_id'] ?>"><span>Add this set to basket</span><strong><?= $cxMoney((float) $collection['price']) ?></strong><span class="bundle-add-arrow" aria-hidden="true">↗</span></button>
              <?php else: ?>
                <button class="btn btn-primary bundle-add-button" type="button" disabled><span>Currently unavailable</span><span class="bundle-add-arrow" aria-hidden="true">↗</span></button>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
      <?php if (!$cxCollections): ?>
        <p>New sets are on their way. Check back soon.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
<div class="cx-toast" id="cx-toast" role="status" aria-live="polite"></div>
<script>window.NABTA_PUBLIC_URL = window.NABTA_PUBLIC_URL || <?= json_encode(nabta_public_url()) ?>;</script>
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/cart.js?v=20261102'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
