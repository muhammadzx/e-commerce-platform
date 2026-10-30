
<?php
require_once __DIR__ . '/../config/paths.php';

session_start();

// Simulate a logged-in customer
$_SESSION["user_id"] = 1;

echo "Test login successful! Logged in as User ID: " .
     $_SESSION["user_id"];

echo '<p><a href="' . htmlspecialchars(nabta_public_url('index.php?page=product&id=1'), ENT_QUOTES, 'UTF-8') . '">
        Open Product 1
      </a></p>';
