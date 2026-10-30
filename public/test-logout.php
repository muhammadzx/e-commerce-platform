<?php
require_once __DIR__ . '/../config/paths.php';

session_start();

unset($_SESSION["user_id"]);

header("Location: " . nabta_public_url("index.php?page=product&id=1"));
exit;