<?php

require_once __DIR__ . "/../../config/paths.php";
require_once __DIR__ . "/../Core/Security.php";
require_once __DIR__ . "/../Models/User.php";
require_once __DIR__ . "/../Models/Cart.php";

// "My account" page of a signed-in customer: details, edit profile, change password
class AccountController
{
    private User $user;
    private Cart $cart;

    public function __construct()
    {
        require __DIR__ . '/../../config/connection.php';

        $this->user = new User($db);
        $this->cart = new Cart($db);
    }

    public function show()
    {
        require_authenticated_user();

        $userId = (int) $_SESSION["user_id"];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->handlePost($userId);
            header("Location: index.php?page=profile");
            exit;
        }

        $account = $this->user->find($userId);

        if (!$account) {
            $_SESSION = [];
            header("Location: login.php");
            exit;
        }

        $orders = $this->cart->getOrders($userId);

        $flash = $_SESSION["account_flash"] ?? null;
        unset($_SESSION["account_flash"]);

        require __DIR__ . "/../Views/account.php";
    }

    private function flash(string $type, string $message): void
    {
        $_SESSION["account_flash"] = ["type" => $type, "message" => $message];
    }

    private function handlePost(int $userId): void
    {
        if (!verify_csrf_token($_POST["csrf_token"] ?? null)) {
            $this->flash("error", "Your session expired. Please try again.");
            return;
        }

        $action = (string) ($_POST["action"] ?? "");

        if ($action === "profile") {
            $this->updateProfile($userId);
        } elseif ($action === "password") {
            $this->changePassword($userId);
        }
    }

    private function updateProfile(int $userId): void
    {
        $data = [
            "full_name" => trim((string) ($_POST["full_name"] ?? "")),
            "email" => trim((string) ($_POST["email"] ?? "")),
            "phone" => trim((string) ($_POST["phone"] ?? "")),
            "address" => trim((string) ($_POST["address"] ?? ""))
        ];

        if ($data["full_name"] === "" || app_length($data["full_name"]) > 100) {
            $this->flash("error", "Please enter your name (up to 100 characters).");
            return;
        }

        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL) || app_length($data["email"]) > 150) {
            $this->flash("error", "Please enter a valid email address.");
            return;
        }

        if (
            app_length($data["phone"]) > 30 ||
            ($data["phone"] !== "" && preg_match('/^[0-9+()\-\s.]{6,30}$/', $data["phone"]) !== 1)
        ) {
            $this->flash("error", "Please enter a valid phone number.");
            return;
        }

        if (app_length($data["address"]) > 255) {
            $this->flash("error", "The address is too long (up to 255 characters).");
            return;
        }

        if ($this->user->emailExists($data["email"], $userId)) {
            $this->flash("error", "That email address is already in use.");
            return;
        }

        $data["phone"] = $data["phone"] === "" ? null : $data["phone"];
        $data["address"] = $data["address"] === "" ? null : $data["address"];

        $this->user->updateProfile($userId, $data);
        $_SESSION["full_name"] = $data["full_name"];

        $this->flash("success", "Your details have been saved.");
    }

    private function changePassword(int $userId): void
    {
        $current = (string) ($_POST["current_password"] ?? "");
        $new = (string) ($_POST["new_password"] ?? "");
        $confirm = (string) ($_POST["confirm_password"] ?? "");

        $hash = $this->user->getPasswordHash($userId);

        if ($hash === null || !password_verify($current, $hash)) {
            $this->flash("error", "Your current password is not correct.");
            return;
        }

        if ($new !== $confirm) {
            $this->flash("error", "The new passwords do not match.");
            return;
        }

        if (!password_policy_passes($new)) {
            $this->flash("error", "Use at least 8 characters with a letter, a number and a symbol.");
            return;
        }

        $this->user->updatePasswordHash($userId, password_hash($new, PASSWORD_DEFAULT));
        session_regenerate_id(true);

        $this->flash("success", "Your password has been updated.");
    }
}
