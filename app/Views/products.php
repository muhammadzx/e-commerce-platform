<?php
require_once __DIR__ . '/../../config/paths.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shop All | NABTA Botanical</title>

    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/product.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/nature-bg.css?v=2'), ENT_QUOTES, 'UTF-8') ?>">
    <!-- Theme must stay LAST so it overrides the colours above -->
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/nabta-theme.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/cart.css?v=2'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>

<body>
<?php require __DIR__ . '/layouts/cart-link.php'; ?>

<!-- Living background: falling leaves (behind the page) -->
<div class="nature-bg" aria-hidden="true">
    <div class="tree" id="tree"></div>
    <div class="leaves" id="leaves"></div>
</div>

<!-- Sunlight: soft rays + light patches (over the page, pointer-events off) -->
<div class="sunlight" aria-hidden="true">
    <div class="rays"></div>
    <div class="glints"></div>
</div>

<?php require __DIR__ . "/layouts/header.php"; ?>
<main>
    <div class="page-container">

        <!-- <div class="breadcrumbs">
            <a href="<?= htmlspecialchars(nabta_public_url('index.php'), ENT_QUOTES, 'UTF-8') ?>">Home</a>
            <span>/</span>
            <span>Shop All</span>
        </div>

        <section class="shop-banner">
            <div class="banner-overlay">
                <p class="eyebrow">THE NABTA COLLECTION</p>

                <h1>Grow Your World.</h1>

                <p>
                    Discover plants, flowers, and everything
                    you need to bring nature home.
                </p>
            </div>
        </section> -->

        <!-- Products -->
        <section class="shop-content">

            <div class="section-heading">
                <!-- <p id="product-count"></p> -->
            </div>

            <section class="welcome" id="welcome">

                <div id="welcome-ask">

                    <h3>Ready to make your space bloom?</h3>

                    <p>
                        Fresh plants, seeds, tools and everything your green
                        corner has been dreaming of. Hand-picked and waiting for you.
                    </p>

                </div>

            </section>

            <div class="shop-area" id="shop-area">

                <!-- Filters -->
                <div class="simple-filters">

                    <div class="filter-group search-group">
                        <label for="product-search">Search Products</label>
                        <input
                            type="text"
                            id="product-search"
                            placeholder="Search for a plant..."
                        >
                    </div>

                    <div class="filter-group">
                        <label for="category-filter">Category</label>
                        <select id="category-filter">
                            <option value="all">All Categories</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="sort-filter">Sort By</label>
                        <select id="sort-filter">
                            <option value="default">Featured</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="name">Name: A to Z</option>
                        </select>
                    </div>

                </div>

                <!-- Products Grid -->
                <div class="products-grid" id="products-container">
                    <p>Loading products...</p>
                </div>

                <!-- Page buttons -->
                <nav class="pagination" id="pagination" aria-label="Pagination"></nav>

            </div>

        </section>

    </div>
</main>

<!-- Bottom Banner -->
<section class="bottom-banner">
    <p class="eyebrow">GROW WITH NABTA</p>

    <h2>
        A little more <em>green.</em>
        A lot more life.
    </h2>

    <a href="<?= htmlspecialchars(nabta_public_url('index.php?page=products'), ENT_QUOTES, 'UTF-8') ?>">
        Explore the collection ↗
    </a>
</section>
<?php require __DIR__ . "/layouts/footer.php"; ?>

<script src="<?= htmlspecialchars(nabta_public_url('assets/js/nature-bg.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<script>window.NABTA_PUBLIC_URL = <?= json_encode(nabta_public_url()) ?>;</script>
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/products.js?v=20261101b'), ENT_QUOTES, 'UTF-8') ?>"></script>

</body>
</html>