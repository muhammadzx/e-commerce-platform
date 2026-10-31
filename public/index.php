<?php

require_once __DIR__ . "/../routes.php";

// API requests
if (isset($_GET["api"])) {
    handleApiRequest();
    exit;
}

// Frontend pages
$page = $_GET["page"] ?? "products";

switch ($page) {

    case "products":
        require __DIR__ . "/../app/Views/products.php";
        break;

    case "product":
        $controller = new ProductController();
        $controller->show();
        break;

    case "wishlist":
        $controller = new WishlistController();
        $controller->handle();
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}