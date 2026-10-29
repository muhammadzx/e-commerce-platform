<?php

require_once __DIR__ . "/app/models/Product.php";

$productObj = new Product();

$products = $productObj->getAllProducts();

echo "<pre>";
print_r($products);
echo "</pre>";