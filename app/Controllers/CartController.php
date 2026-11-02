<?php

require_once __DIR__ . "/../Core/Security.php";
require_once __DIR__ . "/../Models/Cart.php";

class CartController
{
    private Cart $cart;

    public function __construct()
    {
        require __DIR__ . '/../../config/connection.php';

        $this->cart = new Cart($db);
    }

    // Cart page: shows the basket, handles "Update quantities" and "Remove"
    public function show()
    {
        require_authenticated_user();

        $userId = (int) $_SESSION["user_id"];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (verify_csrf_token($_POST["csrf_token"] ?? null)) {
                $action = (string) ($_POST["action"] ?? "");

                if ($action === "update" && is_array($_POST["qty"] ?? null)) {
                    $this->cart->updateQuantities($userId, $_POST["qty"]);
                } elseif ($action === "remove") {
                    $this->cart->removeItem($userId, (int) ($_POST["cart_item_id"] ?? 0));
                }
            }

            header("Location: index.php?page=cart");
            exit;
        }

        $items = $this->cart->getItems($userId);

        $itemCount = 0;
        $subtotal = 0.0;

        foreach ($items as $item) {
            $itemCount += (int) $item["quantity"];
            $subtotal += (float) $item["price"] * (int) $item["quantity"];
        }

        require __DIR__ . "/../Views/cart.php";
    }

    // API: add one product to the basket
    public function add()
    {
        if (!is_authenticated()) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "login" => true,
                "message" => "Please sign in to add items to your basket."
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

        $productId = filter_input(INPUT_POST, "pro_id", FILTER_VALIDATE_INT);
        $collectionId = filter_input(INPUT_POST, "collection_id", FILTER_VALIDATE_INT);

        if (
            (!$productId || $productId <= 0) &&
            (!$collectionId || $collectionId <= 0)
        ) {
            http_response_code(422);

            echo json_encode([
                "success" => false,
                "message" => "Invalid product."
            ]);
            return;
        }

        $userId = (int) $_SESSION["user_id"];

        if ($collectionId && $collectionId > 0) {
            [$success, $message] = $this->cart->addCollection($userId, $collectionId, 1);
        } else {
            [$success, $message] = $this->cart->addItem($userId, $productId, 1);
        }

        if (!$success) {
            http_response_code(409);
        }

        echo json_encode([
            "success" => $success,
            "message" => $message,
            "count" => $this->cart->countItems($userId)
        ]);
    }

    // API: number shown on the bag icon
    public function remove(): void
    {
        if (!is_authenticated()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'login' => true, 'message' => 'Please sign in again.']);
            return;
        }
        if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Your session expired. Refresh the page and try again.']);
            return;
        }
        $id = filter_var($_POST['cart_item_id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || $id < 1) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'Invalid basket item.']);
            return;
        }
        try {
            $userId = (int) $_SESSION['user_id'];
            $this->cart->removeItem($userId, $id);
            $items = $this->cart->getItems($userId);
            $count = 0;
            $subtotal = 0.0;
            foreach ($items as $item) {
                $count += (int)$item['quantity'];
                $subtotal += (float)$item['price'] * (int)$item['quantity'];
            }
            echo json_encode(['success' => true, 'count' => $count, 'subtotal' => round($subtotal, 2),
                'item_ids' => array_map(static fn($item) => (int)$item['cart_item_id'], $items)]);
        } catch (Throwable $exception) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'We could not update your basket. Please refresh and try again.']);
        }
    }

    // API: number shown on the bag icon
    public function count()
    {
        $count = is_authenticated()
            ? $this->cart->countItems((int) $_SESSION["user_id"])
            : 0;

        echo json_encode(["count" => $count]);
    }
}
