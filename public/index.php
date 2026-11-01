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
        require_once __DIR__ . "/../app/Controllers/HomeController.php";
        (new HomeController())->show();
        break;

    case "products":
        require __DIR__ . "/../app/Views/products.php";
        break;

    case "product":
        $controller = new ProductController();
        $controller->show();
        break;

    case "collections":
        require __DIR__ . "/../app/Views/collections.php";
        break;

    case "cart":
        $controller = new CartController();
        $controller->show();
        break;

    case "checkout":
        $controller = new OrderController();
        $controller->checkout();
        break;

    case "wishlist":
        require_once __DIR__ . "/../app/Controllers/WishlistController.php";
        (new WishlistController())->handle();
        break;

    case "contact":
        require_once __DIR__ . "/../config/connection.php";
        require_once __DIR__ . "/../app/Controllers/ContactController.php";
        (new ContactController($db))->submit();
        break;

    case "profile":
        require_once __DIR__ . "/../app/Controllers/AccountController.php";
        $controller = new AccountController();
        $controller->show();
        break;

    case "about":
        require __DIR__ . "/../app/Views/about.php";
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}