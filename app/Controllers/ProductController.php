<?php

require_once __DIR__ . "/../Models/Product.php";
require_once __DIR__ . "/../Models/Review.php";
require_once __DIR__ . "/../Models/Wishlist.php";

class ProductController
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    // Products API
public function index()
{
    header("Content-Type: application/json; charset=utf-8");

    $page = filter_input(
        INPUT_GET,
        "page",
        FILTER_VALIDATE_INT
    );

    $page = ($page !== false && $page !== null && $page > 0)
        ? $page
        : 1;

    $limit = 9;
    $offset = ($page - 1) * $limit;

    $search = trim($_GET["search"] ?? "");
    $category = $_GET["category"] ?? "all";
    $sort = $_GET["sort"] ?? "default";

    $totalProducts = $this->product->countProducts(
        $search,
        $category
    );

    $totalPages = (int) ceil($totalProducts / $limit);

    // Keep requested page within the available range
    $page = min($page, max(1, $totalPages));
    $offset = ($page - 1) * $limit;

    $products = $this->product->getPaginatedProducts(
        $limit,
        $offset,
        $search,
        $category,
        $sort
    );

    echo json_encode([
        "products" => $products,
        "totalProducts" => $totalProducts,
        "currentPage" => $page,
        "totalPages" => $totalPages
    ]);
}


// Display a single product
public function show()
{
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if (!$id || $id <= 0) {
        http_response_code(400);
        echo "Invalid product ID";
        return;
    }

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

    // Get product details
    $product = $this->product->getProductById($id);

    if (!$product) {
        http_response_code(404);
        echo "Product not found";
        return;
    }

    // Get all product images (primary + additional)
    $productImages = $this->product->getProductImages($id);





    $frequentlyBoughtTogether = $this->product
    ->getFrequentlyBoughtTogether($id);



    

    // Get related products
    $relatedProducts = $this->product->getRelatedProducts(
        $product["cat_id"],
        $id
    );

    // Get product reviews
  $reviewModel = new Review();

// All reviews (for the popup)
$reviews = $reviewModel->getByProduct($id);

// Only the 3 highest-rated reviews
$topReviews = $reviewModel->getTopReviews($id);

// Average rating and total count
$reviewSummary = $reviewModel->getSummary($id);

    // Is this product already in the logged-in user's wishlist?
    $inWishlist = !empty($_SESSION["user_id"])
        && (new Wishlist())->has((int) $_SESSION["user_id"], $id);

    // Display product details page
    require __DIR__ . "/../Views/product.php";
}




    // Categories API
public function categories()
{
    header("Content-Type: application/json; charset=utf-8");

    $categories = $this->product->getAllCategories();

    echo json_encode($categories);
}
}