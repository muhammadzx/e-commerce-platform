<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../Models/Product.php';
$catalogModel = new Product();
$catalogSearch = mb_substr(trim((string) ($_GET['search'] ?? '')), 0, 200);
$catalogCategory = (string) ($_GET['category'] ?? 'all');
$catalogSort = (string) ($_GET['sort'] ?? 'default');
$catalogCount = $catalogModel->countProducts($catalogSearch, $catalogCategory);
$catalogPages = max(1, (int) ceil($catalogCount / 9));
$catalogPage = max(1, min($catalogPages, (int) ($_GET['p'] ?? 1)));
$catalogProducts = $catalogModel->getPaginatedProducts(9, ($catalogPage - 1) * 9, $catalogSearch, $catalogCategory, $catalogSort);
$catalogCategories = $catalogModel->getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shop All | NABTA Botanical</title>
    <meta name="description" content="Browse Nabta plants, pots, seeds and growing essentials. Search by category and compare prices and availability.">

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
<main id="main" tabindex="-1">
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

        <h1 class="page-title" id="results-title" tabindex="-1">Shop plants &amp; growing essentials</h1>
        <!-- Products -->
        <section class="shop-content">

            <div class="section-heading">
                <p id="product-count" role="status" aria-live="polite" aria-atomic="true"><?= (int)$catalogCount ?> products</p>
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
                <form class="simple-filters" method="get" action="index.php"><input type="hidden" name="page" value="products">

                    <div class="filter-group search-group">
                        <label for="product-search">Search Products</label>
                        <input
                            type="text"
                            id="product-search" name="search" value="<?= e($catalogSearch) ?>"
                            placeholder="Search for a plant..."
                        >
                    </div>

                    <div class="filter-group">
                        <label for="category-filter">Category</label>
                        <select id="category-filter" name="category">
                            <option value="all">All Categories</option><?php foreach ($catalogCategories as $category): ?><option value="<?= e($category['cat_id']) ?>" <?= (string)$category['cat_id'] === $catalogCategory ? 'selected' : '' ?>><?= e($category['name']) ?></option><?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="sort-filter">Sort By</label>
                        <select id="sort-filter" name="sort">
                            <option value="default" <?= $catalogSort === 'default' ? 'selected' : '' ?>>Featured</option>
                            <option value="price-low" <?= $catalogSort === 'price-low' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price-high" <?= $catalogSort === 'price-high' ? 'selected' : '' ?>>Price: High to Low</option>
                            <option value="name" <?= $catalogSort === 'name' ? 'selected' : '' ?>>Name: A to Z</option>
                        </select>
                    </div><button class="btn btn-primary filter-submit" type="submit">Apply filters</button></form>
<!-- Products Grid -->
                <div class="products-grid" id="products-container" aria-busy="false">
                    <?php require __DIR__ . '/layouts/catalog-items.php'; ?>
                </div>

                <!-- Page buttons -->
                <nav class="pagination" id="pagination" aria-label="Pagination"><?php for ($i=1;$i<=$catalogPages;$i++): ?><a class="page-btn" href="<?= e(nabta_public_url('index.php?' . http_build_query(['page'=>'products','p'=>$i,'search'=>$catalogSearch,'category'=>$catalogCategory,'sort'=>$catalogSort]))) ?>" <?= $i === $catalogPage ? 'aria-current="page"' : '' ?>><?= $i ?></a><?php endfor; ?></nav>

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
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/products.js?v=20261102'), ENT_QUOTES, 'UTF-8') ?>"></script>

</body>
</html>