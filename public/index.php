<?php

// Secure session first, so the cart and login work on every page
require_once __DIR__ . "/../app/Views/bootstrap.php";
require_once __DIR__ . "/../routes.php";

// API requests
if (isset($_GET["api"])) {
    handleApiRequest();
    exit;
}

// Frontend pages
$page = $_GET["page"] ?? "home";

switch ($page) {

    case "home":
        require __DIR__ . "/../app/Views/home.php";
        break;

    case "products":
        require __DIR__ . "/../app/Views/products.php";
        break;

    case "product":
        $controller = new ProductController();
        $controller->show();
        break;

    case "cart":
        $controller = new CartController();
        $controller->show();
        break;

    case "checkout":
        $controller = new OrderController();
        $controller->checkout();
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
