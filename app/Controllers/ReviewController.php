
<?php

require_once __DIR__ . "/../Models/Review.php";

class ReviewController
{
    private Review $review;

    public function __construct()
    {
        $this->review = new Review();
    }

    public function store()
    {
        header("Content-Type: application/json; charset=utf-8");

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // User must be logged in
        if (!isset($_SESSION["user_id"])) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "message" => "Please log in to write a review."
            ]);
            return;
        }

        // CSRF protection
        if (
            !isset($_SESSION["csrf_token"]) ||
            !is_string($_POST["csrf_token"] ?? null) ||
            !hash_equals(
                $_SESSION["csrf_token"],
                $_POST["csrf_token"]
            )
        ) {
            http_response_code(403);

            echo json_encode([
                "success" => false,
                "message" => "Invalid form token. Please refresh the page."
            ]);
            return;
        }

        $userId = (int) $_SESSION["user_id"];

        $productId = filter_input(
            INPUT_POST,
            "pro_id",
            FILTER_VALIDATE_INT
        );

        $rating = filter_input(
            INPUT_POST,
            "rating",
            FILTER_VALIDATE_INT
        );

        $comment = trim((string) ($_POST["comment"] ?? ""));

        // Validate submitted data
        if (
            !$productId ||
            $productId <= 0 ||
            !$rating ||
            $rating < 1 ||
            $rating > 5 ||
            $comment === "" ||
            mb_strlen($comment) > 1000
        ) {
            http_response_code(422);

            echo json_encode([
                "success" => false,
                "message" => "Enter a rating from 1 to 5 and a comment of up to 1000 characters."
            ]);
            return;
        }

        // Customer must have purchased this product
        if (!$this->review->hasPurchased($userId, $productId)) {
            http_response_code(403);

            echo json_encode([
                "success" => false,
                "message" => "Only customers who purchased this product can review it."
            ]);
            return;
        }

        // One review per customer per product
        if ($this->review->hasReviewed($userId, $productId)) {
            http_response_code(409);

            echo json_encode([
                "success" => false,
                "message" => "You have already reviewed this product."
            ]);
            return;
        }

        // Save review
        $success = $this->review->createReview(
            $userId,
            $productId,
            $rating,
            $comment
        );

        if (!$success) {
            http_response_code(409);

            echo json_encode([
                "success" => false,
                "message" => "Unable to submit your review. Please check your eligibility."
            ]);
            return;
        }

        http_response_code(201);

        echo json_encode([
            "success" => true,
            "message" => "Your review was submitted successfully."
        ]);
    }
}
