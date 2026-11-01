<?php
require_once __DIR__ . '/../../config/paths.php';
// ProductController provides $product, $relatedProducts, $reviews, $reviewSummary.
$img = static function (?string $url): string {
    if (!$url) return '';
    return preg_match('~^https?://~i', $url) ? $url : nabta_public_url('assets/img/' . ltrim($url, '/'));
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
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/nabta-theme.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/product-details.css?v=15'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/cart.css?v=2'), ENT_QUOTES, 'UTF-8') ?>">
    <meta name="cart-csrf" content="<?= $esc(csrf_token()) ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="nabta-product-body">
<?php require __DIR__ . '/layouts/cart-link.php'; ?>
<?php require __DIR__ . "/layouts/header.php"; ?>
<main class="nabta-detail">
    <nav class="nd-crumbs" aria-label="Breadcrumb">
        <a href="<?= htmlspecialchars(nabta_public_url('index.php?page=products'), ENT_QUOTES, 'UTF-8') ?>">Shop All</a><span aria-hidden="true">/</span>
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






    <?php if (!empty($frequentlyBoughtTogether)): ?>

<section class="nd-frequently-bought">

    <div class="nd-section-head">
        <div>
            <p class="nd-kicker">BETTER TOGETHER</p>
            <h2>Frequently bought together<span class="nd-period">.</span></h2>
        </div>
    </div>

    <div class="nd-fbt-grid">

        <?php foreach ($frequentlyBoughtTogether as $item): ?>

            <a
                class="nd-fbt-card"
                href="index.php?page=product&id=<?= (int) $item['pro_id'] ?>"
            >
                <div class="nd-fbt-image">
                    <?php if (!empty($item['image_url'])): ?>
                        <img
                            src="<?= $esc($img($item['image_url'])) ?>"
                            alt="<?= $esc($item['name']) ?>"
                            loading="lazy"
                        >
                    <?php else: ?>
                        <div class="nd-image-empty">NABTA</div>
                    <?php endif; ?>
                </div>

                <div class="nd-fbt-info">
                    <h3><?= $esc($item['name']) ?></h3>

                    <span>
                        <?= number_format((float) $item['price'], 2) ?> JOD
                    </span>

                    <p>
                        Purchased together
                        <?= (int) $item['times_bought_together'] ?>
                        times
                    </p>
                </div>
            </a>

        <?php endforeach; ?>

    </div>

</section>

<?php endif; ?>








<section class="nd-reviews" id="reviews">

    <div class="nd-section-head">
        <div>
            <p class="nd-kicker">WORDS FROM OUR COMMUNITY</p>
            <h2>
                Customer reviews
                <span class="nd-count"><?= $total ?></span>
            </h2>
        </div>

        <?php if ($total > 0): ?>
            <p class="nd-review-summary">
                <span class="nd-stars">
                    <?= str_repeat('★', $rounded) . str_repeat('☆', 5 - $rounded) ?>
                </span>
                <?= number_format($average, 1) ?> / 5
            </p>
        <?php endif; ?>
    </div>

    <!-- Existing customer reviews -->
    <?php if (empty($reviews)): ?>

        <p class="nd-empty">
            No reviews yet. Be the first to share your experience.
        </p>

    <?php else: ?>

        <div class="nd-review-list">

          <?php foreach ($topReviews as $review): ?>

                <?php
                $stars = max(
                    0,
                    min(5, (int) ($review['rating'] ?? 0))
                );
                ?>

                <article class="nd-review">

                    <div class="nd-review-person">
                        <strong>
                            <?= $esc($review['reviewer_name'] ?? 'Customer') ?>
                        </strong>

                        <span>
                            <?= !empty($review['created_at'])
                                ? date('M j, Y', strtotime($review['created_at']))
                                : '' ?>
                        </span>
                    </div>

                    <div class="nd-review-body">

                        <span class="nd-stars">
                            <?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?>
                        </span>

                        <?php if (!empty($review['comment'])): ?>
                            <p><?= nl2br($esc($review['comment'])) ?></p>

                            
                        <?php endif; ?>

                    </div>

</article>

<?php endforeach; ?>

</div>

<?php if ($total > 3): ?>
    <button
        type="button"
        class="nd-view-reviews"
        id="open-reviews-modal"
    >
        View all <?= $total ?> reviews ↗
    </button>
<?php endif; ?>

    <?php endif; ?>

<?php if ($total > 3): ?>
<div
    class="nd-reviews-modal"
    id="reviews-modal"
    hidden
>
    <div class="nd-modal-backdrop" data-close-reviews></div>

    <div
        class="nd-modal-panel"
        role="dialog"
        aria-modal="true"
        aria-labelledby="reviews-modal-title"
        tabindex="-1"
    >
        <div class="nd-modal-header">
            <div>
                <p class="nd-kicker">THE NABTA COMMUNITY</p>
                <h2 id="reviews-modal-title">All customer reviews</h2>
                <p>
                    <?= number_format($average, 1) ?> / 5
                    · <?= $total ?> reviews
                </p>
            </div>

            <button
                type="button"
                class="nd-modal-close"
                id="close-reviews-modal"
                aria-label="Close reviews"
            >
                &times;
            </button>
        </div>

        <div class="nd-modal-review-list" id="modal-review-list">
            <?php foreach ($reviews as $review): ?>
                <?php
                $stars = max(0, min(5, (int) $review['rating']));
                ?>

                <article class="nd-review">
                    <div class="nd-review-person">
                        <strong>
                            <?= $esc($review['reviewer_name'] ?? 'Customer') ?>
                        </strong>
                        <span>
                            <?= !empty($review['created_at'])
                                ? date('M j, Y', strtotime($review['created_at']))
                                : '' ?>
                        </span>
                    </div>

                    <div class="nd-review-body">
                        <span class="nd-stars">
                            <?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?>
                        </span>

                        <?php if (!empty($review['comment'])): ?>
                            <p><?= nl2br($esc($review['comment'])) ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="nd-modal-footer">
            <button
                type="button"
                class="nd-modal-load-more"
                id="load-more-reviews"
                hidden
            >
                Show more reviews ↓
            </button>
        </div>
    </div>
</div>
<?php endif; ?>
    
    <!-- Write a review -->
    <div class="nd-review-form-container">

        <p class="nd-kicker">YOUR EXPERIENCE MATTERS</p>
        <h3>Share your experience.</h3>

        <?php if (empty($_SESSION["user_id"])): ?>

            <p class="nd-empty">
                Please log in to leave a review.
            </p>

        <?php elseif (!$reviewModel->hasPurchased(
            (int) $_SESSION["user_id"],
            (int) $product["pro_id"]
        )): ?>

            <p class="nd-empty">
                Only customers who purchased this product can leave a review.
            </p>

        <?php elseif ($reviewModel->hasReviewed(
            (int) $_SESSION["user_id"],
            (int) $product["pro_id"]
        )): ?>

            <p class="nd-empty">
                You have already reviewed this product.
            </p>

        <?php else: ?>

           <form
    id="review-form"
    method="POST"
    action="<?= htmlspecialchars(nabta_public_url('index.php?api=submit-review'), ENT_QUOTES, 'UTF-8') ?>"
>
                <input
                    type="hidden"
                    name="pro_id"
                    value="<?= (int) $product["pro_id"] ?>"
                >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= $esc($_SESSION["csrf_token"]) ?>"
                >

                <label for="review-rating">Your rating</label>

                <select id="review-rating" name="rating" required>
                    <option value="">Select your rating</option>
                    <option value="5">★★★★★ — Excellent</option>
                    <option value="4">★★★★☆ — Very good</option>
                    <option value="3">★★★☆☆ — Good</option>
                    <option value="2">★★☆☆☆ — Fair</option>
                    <option value="1">★☆☆☆☆ — Poor</option>
                </select>

                <label for="review-comment">Your review</label>

                <textarea
                    id="review-comment"
                    name="comment"
                    rows="4"
                    maxlength="1000"
                    placeholder="Tell us about your experience..."
                    required
                ></textarea>

                <button type="submit" class="nd-review-submit">
                    Submit review ↗
                </button>

                <p id="review-message" role="status" aria-live="polite"></p>

            </form>

        <?php endif; ?>

    </div>

</section>


    <section class="nd-related">
        <div class="nd-section-head"><div><p class="nd-kicker">DISCOVER SOMETHING NEW</p><h2>You may also like<span class="nd-period">.</span></h2></div><a class="nd-view-all" href="<?= htmlspecialchars(nabta_public_url('index.php?page=products'), ENT_QUOTES, 'UTF-8') ?>">Explore all products ↗</a></div>
        <?php if (empty($relatedProducts)): ?>
            <p class="nd-empty">No related products available.</p>
        <?php else: ?>
            <div class="nd-related-grid">
            <?php foreach ($relatedProducts as $related): ?>
                <article class="nd-product-card"><a href="<?= htmlspecialchars(nabta_public_url('index.php?page=product&id=' . (int) $related['pro_id']), ENT_QUOTES, 'UTF-8') ?>">
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
<?php require __DIR__ . "/layouts/footer.php"; ?>

<script>window.NABTA_PUBLIC_URL = <?= json_encode(nabta_public_url()) ?>;</script>
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/products.js?v=reviews5'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/cart.js?v=1'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>
</html>
