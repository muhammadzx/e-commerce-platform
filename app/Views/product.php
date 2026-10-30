<?php
// ProductController provides $product, $relatedProducts, $reviews, $reviewSummary.
$img = static function (?string $url): string {
    if (!$url) return '';
    return preg_match('~^https?://~i', $url) ? $url : 'assets/img/' . ltrim($url, '/');
};
$esc = static fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$average = (float) ($reviewSummary['average'] ?? 0);
$total = (int) ($reviewSummary['total'] ?? 0);
$rounded = max(0, min(5, (int) round($average)));
$inStock = (int) ($product['quantity'] ?? 0) > 0;

// All images belonging to this product
$productImages = $productImages ?? [];

// Use the existing main image as a fallback
if (empty($productImages) && !empty($product['image_url'])) {
    $productImages = [
        [
            'image_url' => $product['image_url'],
            'is_primary' => 1
        ]
    ];
}

$imageCount = count($productImages);
$mainImage = $imageCount > 0
    ? $img($productImages[0]['image_url'])
    : '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $esc($product['name']) ?> | NABTA Botanical</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/shared.css">
    <link rel="stylesheet" href="assets/css/nabta-theme.css">
    <link rel="stylesheet" href="assets/css/product-details.css?v=11">
</head>
<body class="nabta-product-body">
<main class="nabta-detail">
    <nav class="nd-crumbs" aria-label="Breadcrumb">
        <a href="index.php?page=products">Shop All</a><span aria-hidden="true">/</span>
        <span><?= $esc($product['name']) ?></span>
    </nav>

    <section class="nd-hero" aria-label="Product details">
      
<div class="nd-gallery">

    <!-- Main product image -->
    <div class="nd-main-image">

        <?php if ($mainImage): ?>

            <img
                id="main-product-image"
                src="<?= $esc($mainImage) ?>"
                alt="<?= $esc($product['name']) ?>"
            >

        <?php else: ?>

            <div class="nd-image-empty">
                NABTA BOTANICAL
            </div>

        <?php endif; ?>

    </div>

    <!-- Image thumbnails -->
    <?php if ($imageCount > 1): ?>

        <div class="nd-thumbnails">

            <?php foreach ($productImages as $index => $image): ?>

                <button
                    type="button"
                    class="nd-thumbnail <?= $index === 0 ? 'active' : '' ?>"
                    data-image="<?= $esc($img($image['image_url'])) ?>"
                    data-index="<?= $index + 1 ?>"
                    aria-label="View product image <?= $index + 1 ?>"
                    aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>"
                >

                    <img
                        src="<?= $esc($img($image['image_url'])) ?>"
                        alt="<?= $esc($product['name']) ?> - Image <?= $index + 1 ?>"
                        loading="lazy"
                    >

                </button>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <!-- Image counter -->
    <div class="nd-gallery-caption">

        <span>THE NABTA COLLECTION</span>

        <span id="image-counter">
            01 / <?= str_pad((string) $imageCount, 2, '0', STR_PAD_LEFT) ?>
        </span>

    </div>

</div>


        <div class="nd-information">
            <p class="nd-kicker">BOTANICAL ESSENTIALS <span>— <?= $esc($product['category'] ?? 'NABTA') ?></span></p>
            <h1><?= $esc($product['name']) ?></h1>
            <div class="nd-price-row">
                <p class="nd-price"><?= number_format((float) $product['price'], 2) ?> <small>JOD</small></p>
                <span class="nd-availability <?= $inStock ? '' : 'is-out' ?>"><span class="nd-dot"></span><?= $inStock ? 'In stock' : 'Out of stock' ?></span>
            </div>
            <?php if ($total > 0): ?>
                <a class="nd-rating" href="#reviews"><span class="nd-stars"><?= str_repeat('★', $rounded) . str_repeat('☆', 5 - $rounded) ?></span><span><?= number_format($average, 1) ?> · <?= $total ?> review<?= $total === 1 ? '' : 's' ?></span></a>
            <?php else: ?>
                <p class="nd-rating nd-rating-empty">No reviews yet</p>
            <?php endif; ?>
            <div class="nd-rule"></div>
            <p class="nd-description"><?= nl2br($esc($product['description'] ?? '')) ?></p>
            <button class="nd-cart" type="button" data-product-id="<?= (int) $product['pro_id'] ?>" <?= $inStock ? '' : 'disabled' ?>>
                <span><?= $inStock ? 'Add to cart' : 'Currently unavailable' ?></span><span aria-hidden="true">↗</span>
            </button>
            <p class="nd-small-note">A little more nature, every day.</p>
            <div class="nd-detail-footer"><span>NABTA / BOTANICAL GOODS</span><span>MADE FOR GREENER SPACES</span></div>
        </div>
    </section>

    <section class="nd-reviews" id="reviews">
        <div class="nd-section-head"><div><p class="nd-kicker">WORDS FROM OUR COMMUNITY</p><h2>Customer reviews<span class="nd-count"><?= $total ?></span></h2></div>
        <?php if ($total > 0): ?><p class="nd-review-summary"><span class="nd-stars"><?= str_repeat('★', $rounded) . str_repeat('☆', 5 - $rounded) ?></span> <?= number_format($average, 1) ?> / 5</p><?php endif; ?></div>
        <?php if (empty($reviews)): ?>
            <p class="nd-empty">No reviews yet. Be the first to share your experience.</p>
        <?php else: ?>
            <div class="nd-review-list">
            <?php foreach ($reviews as $review): $stars = max(0, min(5, (int) ($review['rating'] ?? 0))); ?>
                <article class="nd-review">
                    <div class="nd-review-person"><strong><?= $esc($review['reviewer_name'] ?? 'Customer') ?></strong><span><?= !empty($review['created_at']) ? date('M j, Y', strtotime($review['created_at'])) : '' ?></span></div>
                    <div class="nd-review-body"><span class="nd-stars" aria-label="<?= $stars ?> out of 5 stars"><?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?></span><?php if (!empty($review['comment'])): ?><p><?= nl2br($esc($review['comment'])) ?></p><?php endif; ?></div>
                </article>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="nd-related">
        <div class="nd-section-head"><div><p class="nd-kicker">DISCOVER SOMETHING NEW</p><h2>You may also like<span class="nd-period">.</span></h2></div><a class="nd-view-all" href="index.php?page=products">Explore all products ↗</a></div>
        <?php if (empty($relatedProducts)): ?>
            <p class="nd-empty">No related products available.</p>
        <?php else: ?>
            <div class="nd-related-grid">
            <?php foreach ($relatedProducts as $related): ?>
                <article class="nd-product-card"><a href="index.php?page=product&id=<?= (int) $related['pro_id'] ?>">
                    <div class="nd-card-image">
                        <?php if (!empty($related['image_url'])): ?><img src="<?= $esc($img($related['image_url'])) ?>" alt="<?= $esc($related['name']) ?>" loading="lazy"><?php else: ?><div class="nd-image-empty">NABTA</div><?php endif; ?>
                        <span class="nd-card-arrow" aria-hidden="true">↗</span>
                    </div>
                    <div class="nd-card-copy"><h3><?= $esc($related['name']) ?></h3><span><?= number_format((float) $related['price'], 2) ?> JOD</span></div>
                </a></article>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<script src="assets/js/products.js?v=gallery2" defer></script>
</body>
</html>
