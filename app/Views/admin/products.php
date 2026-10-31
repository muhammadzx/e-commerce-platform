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
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/product-details.css?v=13'), ENT_QUOTES, 'UTF-8') ?>">
    <style>
        .nabta-detail .nd-main-image { position: relative; }
        .nabta-detail .nd-wish { position: absolute; top: 16px; right: 16px; z-index: 2; display: flex; align-items: center; justify-content: center; width: 46px; height: 46px; padding: 0; color: #fff; background: rgba(10, 28, 20, .55); border: 1px solid rgba(255, 255, 255, .35); border-radius: 50%; cursor: pointer; backdrop-filter: blur(6px); transition: transform .2s, color .2s, background .2s; }
        .nabta-detail .nd-wish svg { width: 22px; height: 22px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .nabta-detail .nd-wish:hover:not(:disabled) { transform: scale(1.08); }
        .nabta-detail .nd-wish.is-active { color: #ff6b6b; }
        .nabta-detail .nd-wish.is-active svg { fill: currentColor; }
        .nabta-detail .nd-wish:disabled { opacity: .6; cursor: wait; }
        .nabta-detail .nd-wish-msg { position: absolute; top: 72px; right: 16px; z-index: 2; max-width: 70%; padding: 8px 14px; font-size: .85rem; color: #fff; background: rgba(10, 28, 20, .85); border-radius: 12px; }
    </style>
</head>
<body class="nabta-product-body">
<main class="nabta-detail">
    <nav class="nd-crumbs" aria-label="Breadcrumb">
        <a href="<?= htmlspecialchars(nabta_public_url('index.php?page=products'), ENT_QUOTES, 'UTF-8') ?>">Shop All</a><span aria-hidden="true">/</span>
        <span><?= $esc($product['name']) ?></span>
    </nav>

    <section class="nd-hero" aria-label="Product details">
      
<div class="nd-gallery">

    <!-- Main product image -->
    <div class="nd-main-image">

        <button class="nd-wish<?= !empty($inWishlist) ? ' is-active' : '' ?>" type="button"
            data-wish-product-id="<?= (int) $product['pro_id'] ?>"
            data-csrf="<?= $esc($_SESSION['csrf_token'] ?? '') ?>"
            data-api="<?= $esc(nabta_public_url('index.php?api=wishlist-toggle')) ?>"
            aria-pressed="<?= !empty($inWishlist) ? 'true' : 'false' ?>"
            aria-label="<?= !empty($inWishlist) ? 'Remove from wishlist' : 'Add to wishlist' ?>"
            title="<?= !empty($inWishlist) ? 'Remove from wishlist' : 'Add to wishlist' ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10Z"/></svg>
        </button>
        <span class="nd-wish-msg" role="status" hidden></span>

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

<script>window.NABTA_PUBLIC_URL = <?= json_encode(nabta_public_url()) ?>;</script>
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/products.js?v=reviews4'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<script>
(function () {
    var btn = document.querySelector('[data-wish-product-id]');
    var msg = document.querySelector('.nd-wish-msg');
    var timer = null;

    if (!btn) return;

    function show(text) {
        if (!msg || !text) return;
        msg.textContent = text;
        msg.hidden = false;
        clearTimeout(timer);
        timer = setTimeout(function () { msg.hidden = true; }, 2500);
    }

    btn.addEventListener('click', function () {
        var body = new URLSearchParams();
        body.append('pro_id', btn.dataset.wishProductId);
        body.append('csrf_token', btn.dataset.csrf);

        btn.disabled = true;

        fetch(btn.dataset.api, { method: 'POST', body: body, credentials: 'same-origin' })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    var saved = !!data.in_wishlist;
                    var label = saved ? 'Remove from wishlist' : 'Add to wishlist';
                    btn.classList.toggle('is-active', saved);
                    btn.setAttribute('aria-pressed', saved ? 'true' : 'false');
                    btn.setAttribute('aria-label', label);
                    btn.setAttribute('title', label);
                }
                show(data.message);
            })
            .catch(function () { show('Something went wrong. Please try again.'); })
            .finally(function () { btn.disabled = false; });
    });
})();
</script>
</body>
</html>