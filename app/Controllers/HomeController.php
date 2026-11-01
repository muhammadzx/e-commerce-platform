<?php

require_once __DIR__ . "/../Models/Product.php";
require_once __DIR__ . "/../Models/Category.php";

class HomeController
{
    public function show(): void
    {
        require __DIR__ . "/../../config/connection.php";

        $productModel = new Product();
        $featuredProducts = array_slice($productModel->getAllProducts(), 0, 4);
        $activeCategoryNames = array_column($productModel->getAllCategories(), "name");
        $categories = array_values(array_filter(
            (new Category($db))->getAll(),
            static fn(array $category): bool => in_array($category["name"], $activeCategoryNames, true)
        ));

        $categoryImages = [];
        $defaultImages = ["plant.jpg", "pot.jpg", "soil.jpg", "tools.jpg", "decor.jpg", "care.jpg"];
        foreach ($categories as $index => $category) {
            $name = strtolower((string) ($category["name"] ?? ""));
            $image = $defaultImages[$index % count($defaultImages)];

            if (strpos($name, "soil") !== false || strpos($name, "fertil") !== false || strpos($name, "nutri") !== false || strpos($name, "تربة") !== false || strpos($name, "سماد") !== false) {
                $image = "soil.jpg";
            } elseif (strpos($name, "pot") !== false || strpos($name, "planter") !== false || strpos($name, "أصيص") !== false || strpos($name, "اصيص") !== false) {
                $image = "pot.jpg";
            } elseif (strpos($name, "tool") !== false || strpos($name, "prun") !== false || strpos($name, "أدوات") !== false) {
                $image = "tools.jpg";
            } elseif (strpos($name, "decor") !== false || strpos($name, "gift") !== false || strpos($name, "ديكور") !== false) {
                $image = "decor.jpg";
            } elseif (strpos($name, "care") !== false || strpos($name, "spray") !== false || strpos($name, "treat") !== false || strpos($name, "عناية") !== false) {
                $image = "care.jpg";
            } elseif (strpos($name, "plant") !== false || strpos($name, "flower") !== false || strpos($name, "cact") !== false || strpos($name, "نبات") !== false || strpos($name, "زهور") !== false) {
                $image = "plant.jpg";
            }

            $categoryImages[(int) $category["cat_id"]] = $image;
        }

        require __DIR__ . "/../Views/home.php";
    }
}
