
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($product["name"]) ?> | NABTA
    </title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/shared.css">
</head>

<body>

<main>
    <div class="page-container">

        <div class="breadcrumbs">
            <a href="index.php?page=products">Shop</a>
            <span>/</span>
            <span><?= htmlspecialchars($product["name"]) ?></span>
        </div>

        <section class="product-details">

            <div class="product-image">
                <?php if (!empty($product["image_url"])): ?>
                    <img
                        src="<?= htmlspecialchars($product["image_url"]) ?>"
                        alt="<?= htmlspecialchars($product["name"]) ?>"
                        style="max-width:400px;width:100%;"
                    >
                <?php endif; ?>
            </div>

            <div class="product-info">

                <p>THE NABTA COLLECTION</p>

                <h1><?= htmlspecialchars($product["name"]) ?></h1>

                <h2>
                    <?= number_format((float)$product["price"], 2) ?>
                    JOD
                </h2>

                <p>
                    <?= nl2br(htmlspecialchars($product["description"])) ?>
                </p>

                <p>
                    <?= (int)$product["quantity"] > 0
                        ? "In Stock"
                        : "Out of Stock" ?>
                </p>

                <button type="button">
                    Add to Cart ↗
                </button>

            </div>

        </section>

        <section class="related-products">
            <h2>You May Also Like</h2>

            <?php foreach ($relatedProducts as $related): ?>
                <a href="index.php?page=product&id=<?= (int)$related["pro_id"] ?>">
                    <?= htmlspecialchars($related["name"]) ?>
                </a>
            <?php endforeach; ?>
        </section>

    </div>
</main>

</body>
</html>
