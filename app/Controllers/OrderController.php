<?php

require_once __DIR__ . "/../Core/Security.php";
require_once __DIR__ . "/../Models/Cart.php";

class OrderController
{
    private Cart $cart;

    public function __construct()
    {
        require __DIR__ . '/../../config/connection.php';

        $this->cart = new Cart($db);
    }

    // Checkout page: delivery details form + order summary
    public function checkout()
    {
        require_authenticated_user();

        $userId = (int) $_SESSION["user_id"];
        $items = $this->cart->getItems($userId);

        if (!$items) {
            header("Location: index.php?page=cart");
            exit;
        }

        $itemCount = 0;
        $subtotal = 0.0;

        foreach ($items as $item) {
            $itemCount += (int) $item["quantity"];
            $subtotal += (float) $item["price"] * (int) $item["quantity"];
        }

        $customer = $this->cart->getCustomer($userId);

        $cities = [
            "Amman", "Zarqa", "Irbid", "Aqaba", "Madaba", "Salt",
            "Jerash", "Ajloun", "Karak", "Tafilah", "Ma'an", "Mafraq"
        ];

        require __DIR__ . "/../Views/checkout.php";
    }

    // API: confirm the order (every delivery field is optional)
    public function place()
    {
        if (!is_authenticated()) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "login" => true,
                "message" => "Please sign in to place an order."
            ]);
            return;
        }

        if (!verify_csrf_token($_POST["csrf_token"] ?? null)) {
            http_response_code(403);

            echo json_encode([
                "success" => false,
                "message" => "Your session expired. Refresh the page and try again."
            ]);
            return;
        }

        $account = $this->cart->getCustomer((int) $_SESSION['user_id']);
        $email = trim((string) ($_POST['email'] ?? ''));
        if (!$account || !filter_var($email, FILTER_VALIDATE_EMAIL) || strcasecmp($email, (string) $account['email']) !== 0) {
            http_response_code(422);
            echo json_encode(['success'=>false,'message'=>'Use your current account email. Refresh checkout after updating your account.']);
            return;
        }
        $name = trim((string) ($_POST["full_name"] ?? ""));
        $phone = trim((string) ($_POST["phone"] ?? ""));
        $street = trim((string) ($_POST["street"] ?? ""));
        $city = trim((string) ($_POST["city"] ?? ""));
        $postal = trim((string) ($_POST["postal_code"] ?? ""));

        if (
            app_length($name) > 100 ||
            app_length($phone) > 20 ||
            ($phone !== "" && preg_match('/^[0-9+()\-\s.]{6,20}$/', $phone) !== 1) ||
            app_length($street) > 150 ||
            app_length($city) > 50 ||
            app_length($postal) > 20
        ) {
            http_response_code(422);

            echo json_encode([
                "success" => false,
                "message" => "Please check your delivery details and try again."
            ]);
            return;
        }

        $address = implode(", ", array_filter([$street, $city, $postal], "strlen"));

        [$success, $message, $orderId] = $this->cart->placeOrder(
            (int) $_SESSION["user_id"],
            ["name" => $name, "phone" => $phone, "address" => $address]
        );

        if (!$success) {
            http_response_code(409);
        } else {
            http_response_code(201);
        }

        echo json_encode([
            "success" => $success,
            "message" => $message,
            "order_id" => $orderId
        ]);
    }
}
