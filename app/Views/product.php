<?php
// Variables from ProductController:
// $product, $relatedProducts, $reviews, $reviewSummary

// Local filenames get the assets/img/ prefix; full URLs are used as-is
$img = function (?string $url): string {
    if (!$url) {
        return "";
    }
    return strpos($url, "http") === 0 ? $url : "assets/img/" . $url;
};

$avg   = (int)round((float)$reviewSummary["average"]);
$total = (int)$reviewSummary["total"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($product["name"]) ?> | NABTA</title>

 
    <link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/shared.css">
<link rel="stylesheet" href="assets/css/product-details.css?v=3">
</head>

<body>

<main class="page-container">

    <!-- Breadcrumb -->
    <div class="breadcrumbs">
        <a href="index.php?page=products">Shop All</a>
        <span>/</span>
        <span><?= htmlspecialchars($product["name"]) ?></span>
    </div>

    <!-- Product Details -->
    <section class="product-details">

        <div class="product-image">
            <?php if (!empty($product["image_url"])): ?>
                <img
                    src="<?= htmlspecialchars($img($product["image_url"])) ?>"
                    alt="<?= htmlspecialchars($product["name"]) ?>"
                >
            <?php endif; ?>
        </div>

        <div class="product-info">

            <p>THE NABTA COLLECTION</p>

            <h1><?= htmlspecialchars($product["name"]) ?></h1>

            <h2><?= number_format((float)$product["price"], 2) ?> JOD</h2>

            <?php if ($total > 0): ?>
                <p>
                    <span class="stars"><?= str_repeat("★", $avg) . str_repeat("☆", 5 - $avg) ?></span>
                    <?= number_format((float)$reviewSummary["average"], 1) ?>
                    (<?= $total ?>)
                </p>
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($product["description"] ?? "")) ?></p>

            <p><?= (int)$product["quantity"] > 0 ? "In Stock" : "Out of Stock" ?></p>

            <button type="button">Add to Cart ↗</button>

        </div>

    </section>

    <!-- Reviews -->
    <section class="reviews" id="reviews">

        <h2>Reviews</h2>

        <p class="rating-summary">
            <?php if ($total > 0): ?>
                <span class="stars"><?= str_repeat("★", $avg) . str_repeat("☆", 5 - $avg) ?></span>
                <?= number_format((float)$reviewSummary["average"], 1) ?>
                &middot; <?= $total ?> review<?= $total === 1 ? "" : "s" ?>
            <?php else: ?>
                No reviews yet.
            <?php endif; ?>
        </p>

        <?php foreach ($reviews as $review): ?>
            <?php $stars = max(0, min(5, (int)$review["rating"])); ?>
            <div class="review-item">
                <div class="review-head">
                    <strong><?= htmlspecialchars($review["reviewer_name"] ?? "Customer") ?></strong>
                    <span class="stars"><?= str_repeat("★", $stars) . str_repeat("☆", 5 - $stars) ?></span>
                </div>

                <?php if (!empty($review["comment"])): ?>
                    <p><?= nl2br(htmlspecialchars($review["comment"])) ?></p>
                <?php endif; ?>

                <span class="review-date">
                    <?= date("M j, Y", strtotime($review["created_at"])) ?>
                </span>
            </div>
        <?php endforeach; ?>

    </section>

    <!-- Related Products -->
    <section class="related-products">

        <h2>You May Also Like</h2>

        <?php if (empty($relatedProducts)): ?>

            <p>No related products available.</p>

        <?php else: ?>

            <?php foreach ($relatedProducts as $related): ?>

                <div class="related-product">

                    <a href="index.php?page=product&id=<?= (int)$related["pro_id"] ?>">

                        <?php if (!empty($related["image_url"])): ?>
                            <img
                                src="<?= htmlspecialchars($img($related["image_url"])) ?>"
                                alt="<?= htmlspecialchars($related["name"]) ?>"
                            >
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($related["name"]) ?></h3>

                        <p><?= number_format((float)$related["price"], 2) ?> JOD</p>

                    </a>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </section>

</main>

</body>
</html>