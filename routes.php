
<?php
require_once __DIR__ . '/config/paths.php';

require_once __DIR__ . "/app/Controllers/ProductController.php";
require_once __DIR__ . "/app/Controllers/ReviewController.php";

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

        default:
            http_response_code(404);

            echo json_encode([
                "error" => "API not found"
            ]);
            break;
    }
}
