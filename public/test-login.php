
<?php

session_start();

// Simulate a logged-in customer
$_SESSION["user_id"] = 1;

echo "Test login successful! Logged in as User ID: " .
     $_SESSION["user_id"];

echo '<p><a href="index.php?page=product&id=1">
        Open Product 1
      </a></p>';
