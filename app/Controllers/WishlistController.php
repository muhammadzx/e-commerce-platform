<?php

require_once __DIR__ . "/../Models/Wishlist.php";

class WishlistController
{
    private Wishlist $wishlist;

    public function __construct()
    {
        $this->wishlist = new Wishlist();
    }

    // Get current user's wishlist
    public function index(): void
    {
        $userId = $this->getUserId();

        if (!$userId) {
            $this->unauthorized();
            return;
        }

        $items = $this->wishlist->getByUserId($userId);

        echo json_encode([
            "success" => true,
            "items" => $items
        ]);
    }

    // Add product or collection to wishlist
    public function store(): void
    {
        $userId = $this->getUserId();

        if (!$userId) {
            $this->unauthorized();
            return;
        }

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $productId = isset($data["pro_id"])
            ? (int) $data["pro_id"]
            : 0;

        $collectionId = isset($data["collection_id"])
            ? (int) $data["collection_id"]
            : 0;

        // Must provide exactly one item type
        if (
            ($productId > 0 && $collectionId > 0) ||
            ($productId <= 0 && $collectionId <= 0)
        ) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Provide either pro_id or collection_id."
            ]);

            return;
        }

        if ($productId > 0) {

            if ($this->wishlist->hasProduct($userId, $productId)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Product is already in your wishlist."
                ]);

                return;
            }

            $added = $this->wishlist->addProduct(
                $userId,
                $productId
            );

        } else {

            if ($this->wishlist->hasCollection($userId, $collectionId)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Collection is already in your wishlist."
                ]);

                return;
            }

            $added = $this->wishlist->addCollection(
                $userId,
                $collectionId
            );
        }

        if (!$added) {
            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Could not add item to wishlist."
            ]);

            return;
        }

        echo json_encode([
            "success" => true,
            "message" => "Item added to wishlist."
        ]);
    }

    // Delete item from wishlist
    public function destroy(): void
    {
        $userId = $this->getUserId();

        if (!$userId) {
            $this->unauthorized();
            return;
        }

        $wishlistId = filter_input(
            INPUT_POST,
            "wishlist_id",
            FILTER_VALIDATE_INT
        );

        // Also allow JSON body
        if (!$wishlistId) {

            $data = json_decode(
                file_get_contents("php://input"),
                true
            );

            $wishlistId = isset($data["wishlist_id"])
                ? (int) $data["wishlist_id"]
                : 0;
        }

        if (!$wishlistId || $wishlistId <= 0) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Invalid wishlist ID."
            ]);

            return;
        }

        $deleted = $this->wishlist->delete(
            $userId,
            $wishlistId
        );

        if (!$deleted) {
            http_response_code(404);

            echo json_encode([
                "success" => false,
                "message" => "Wishlist item not found."
            ]);

            return;
        }

        echo json_encode([
            "success" => true,
            "message" => "Item removed from wishlist."
        ]);
    }

    private function getUserId(): int
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION["user_id"])
            ? (int) $_SESSION["user_id"]
            : 0;
    }

    private function unauthorized(): void
    {
        http_response_code(401);

        echo json_encode([
            "success" => false,
            "message" => "You must be logged in."
        ]);
    }
}