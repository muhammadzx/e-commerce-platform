
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shop All | NABTA Botanical</title>

   <link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/shared.css">
<link rel="stylesheet" href="assets/css/product.css">
</head>

<body>

<main>
    <div class="page-container">

        <!-- Breadcrumb -->
        <div class="breadcrumbs">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Shop All</span>
        </div>

        <!-- Banner -->
        <section class="shop-banner">
            <div class="banner-overlay">
                <p class="eyebrow">THE NABTA COLLECTION</p>

                <h1>Grow Your World.</h1>

                <p>
                    Discover plants, flowers, and everything
                    you need to bring nature home.
                </p>
            </div>
        </section>

        <!-- Products -->
        <section class="shop-content">

            <div class="section-heading">
                <div>
                  

                    <h2>
                       A little nature, a lot of joy.  <span>Your next favorite plant is waiting.</span>
                    </h2>
                </div>

                <p id="product-count">Loading products...</p>
            </div>

            <!-- Filters -->
            <div class="simple-filters">

                <div class="filter-group search-group">
                    <label for="product-search">
                        Search Products
                    </label>

                    <input
                        type="text"
                        id="product-search"
                        placeholder="Search for a plant..."
                    >
                </div>

                <div class="filter-group">
                    <label for="category-filter">
                        Category
                    </label>

                    <select id="category-filter">
                        <option value="all">All Categories</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort-filter">
                        Sort By
                    </label>

                    <select id="sort-filter">
                        <option value="default">Featured</option>
                        <option value="price-low">
                            Price: Low to High
                        </option>
                        <option value="price-high">
                            Price: High to Low
                        </option>
                        <option value="name">
                            Name: A to Z
                        </option>
                    </select>
                </div>

            </div>

            <!-- Products Grid -->
            <div
                class="products-grid"
                id="products-container"
            >
                <p>Loading products...</p>
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

    <a href="index.php?page=products">
        Explore the collection ↗
    </a>
</section>

<script src="assets/js/products.js?v=20261029"></script>

</body>
</html>
