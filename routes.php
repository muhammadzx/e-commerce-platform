<?php
require_once __DIR__ . '/config/paths.php';

require_once __DIR__ . "/app/Controllers/ProductController.php";
require_once __DIR__ . "/app/Controllers/ReviewController.php";
require_once __DIR__ . "/app/Controllers/CartController.php";
require_once __DIR__ . "/app/Controllers/OrderController.php";

function handleApiRequest()
{
    $api = $_GET["api"] ?? "";

    header("Content-Type: application/json; charset=utf-8");

    switch ($api) {

        // Get paginated products
        case "products":

            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                header("Allow: GET");
                http_response_code(405);

                echo json_encode([
                    "error" => "Method not allowed"
                ]);
                return;
            }

            $controller = new ProductController();
            $controller->index();
            break;

        // Get all categories
        case "product-categories":

            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                header("Allow: GET");
                http_response_code(405);

                echo json_encode([
                    "error" => "Method not allowed"
                ]);
                return;
            }

            $controller = new ProductController();
            $controller->categories();
            break;

        // Submit product review
        case "submit-review":

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                header("Allow: POST");
                http_response_code(405);

                echo json_encode([
                    "success" => false,
                    "message" => "Method not allowed"
                ]);
                return;
            }

            $controller = new ReviewController();
            $controller->store();
            break;

        // Add a product to the basket
        case "cart-add":

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                header("Allow: POST");
                http_response_code(405);

                echo json_encode([
                    "success" => false,
                    "message" => "Method not allowed"
                ]);
                return;
            }

            $controller = new CartController();
            $controller->add();
            break;

        case "cart-remove":
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Allow: POST');
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Method not allowed']);
                return;
            }
            (new CartController())->remove();
            break;

        // Number of items in the basket (bag icon)
        case "cart-count":

            if ($_SERVER["REQUEST_METHOD"] !== "GET") {
                header("Allow: GET");
                http_response_code(405);

                echo json_encode([
                    "error" => "Method not allowed"
                ]);
                return;
            }

            $controller = new CartController();
            $controller->count();
            break;

        // Heart buttons: saved products + token (GET), save / unsave a product (POST)
        case "wishlist-state":
        case "wishlist-toggle":

            $expected = $api === "wishlist-state" ? "GET" : "POST";

            if ($_SERVER["REQUEST_METHOD"] !== $expected) {
                header("Allow: " . $expected);
                http_response_code(405);

                echo json_encode([
                    "success" => false,
                    "message" => "Method not allowed"
                ]);
                return;
            }

            require_once __DIR__ . "/app/Controllers/WishlistController.php";

            $controller = new WishlistController();
            $api === "wishlist-state" ? $controller->state() : $controller->toggle();
            break;

        // Confirm the order
        case "place-order":

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                header("Allow: POST");
                http_response_code(405);

                echo json_encode([
                    "success" => false,
                    "message" => "Method not allowed"
                ]);
                return;
            }

            $controller = new OrderController();
            $controller->place();
            break;

        default:
            http_response_code(404);

            echo json_encode([
                "error" => "API not found"
            ]);
            break;
    }
}
