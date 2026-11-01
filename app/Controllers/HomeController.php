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

// Keyword => image file (checked in order, first match wins)
$imageRules = [
    'cact'      => 'cacti.png',
    'succulent' => 'cacti.png',
    'indoor'    => 'indoor.png',
    'outdoor'   => 'outdoor.png',
    'seed'      => 'seeds.png',
    'fertil'    => 'fertilizers.png',
    'nutri'     => 'fertilizers.png',
    'سماد'      => 'fertilizers.png',
    'soil'      => 'soil.png',
    'تربة'      => 'soil.png',
    'pot'       => 'pots.png',
    'planter'   => 'pots.png',
    'أصيص'      => 'pots.png',
    'اصيص'      => 'pots.png',
    'tool'      => 'Tools.png',
    'prun'      => 'Tools.png',
    'أدوات'     => 'Tools.png',
    'decor'     => 'decor.png',
    'gift'      => 'decor.png',
    'ديكور'     => 'decor.png',
    'treat'     => 'treatments.png',
    'spray'     => 'treatments.png',
    'care'      => 'treatments.png',
    'عناية'     => 'treatments.png',
    'plant'     => 'indoor.png',
    'flower'    => 'outdoor.png',
    'نبات'      => 'indoor.png',
    'زهور'      => 'outdoor.png',
];

foreach ($categories as $category) {
    $name  = mb_strtolower((string) ($category['name'] ?? ''), 'UTF-8');
    $image = 'indoor.png'; // fallback that exists

    foreach ($imageRules as $keyword => $file) {
        if (mb_strpos($name, $keyword) !== false) {
            $image = $file;
            break;
        }
    }

    $categoryImages[(int) $category['cat_id']] = $image;
}

        require __DIR__ . "/../Views/home.php";
    }
}
