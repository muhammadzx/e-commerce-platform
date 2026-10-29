
<?php

require_once __DIR__ . "/app/Controllers/ProductController.php";

function handleApiRequest()
{
    $api = $_GET["api"] ?? "";

    header("Content-Type: application/json; charset=utf-8");

    switch ($api) {

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

        default:
            http_response_code(404);
            echo json_encode([
                "error" => "API not found"
            ]);
            break;
    }
}
