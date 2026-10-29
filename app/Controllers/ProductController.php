<?php

require_once __DIR__ . "/../Models/Product.php";
require_once __DIR__ . "/../Models/Review.php";

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
        $products = $this->product->getAllProducts();

        header("Content-Type: application/json; charset=utf-8");

        echo json_encode($products);
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

        $product = $this->product->getProductById($id);

        if (!$product) {
            http_response_code(404);
            echo "Product not found";
            return;
        }

        $relatedProducts = $this->product->getRelatedProducts(
            $product["cat_id"],
            $id
        );

        $reviewModel   = new Review();
        $reviews       = $reviewModel->getByProduct($id);
        $reviewSummary = $reviewModel->getSummary($id);

        require __DIR__ . "/../Views/product.php";
    }
}