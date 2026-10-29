<?php

require_once __DIR__ . '/../Models/Dashboard.php';

class AdminController
{
    private $dashboard;

    public function __construct()
    {
        require __DIR__ . '/../../config/connection.php';

        $this->dashboard = new Dashboard($db);
    }

    public function index()
    {
        $overviewStats = $this->dashboard->getOverviewStats();

        $salesByCategory = $this->dashboard->getSalesByCategory();

       
        $topThreeCategories = array_slice($salesByCategory, 0, 3);

        $notes = $this->dashboard->getDashboardNotes();

        $bestItems = $this->dashboard->getBestSellingItems();
        
        $topFiveItems = array_slice($bestItems, 0, 5);

        $ordersByStatus = $this->dashboard->getOrdersByStatus();

        $weeklySales = $this->dashboard->getWeeklySales();
        $salesByDate = [];

        foreach ($weeklySales as $sale) {
            $salesByDate[$sale['sale_date']] = (float) $sale['daily_sales'];
        }

        $timezone = new DateTimeZone('Asia/Amman');
        $today = new DateTimeImmutable('today', $timezone);

        $weeklyLabels = [];
        $weeklyValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $chartDate = $today->modify("-{$i} days");
            $dateKey = $chartDate->format('Y-m-d');

            $weeklyLabels[] = $chartDate->format('D');
            $weeklyValues[] = $salesByDate[$dateKey] ?? 0;
        }

        $categoryLabels = array_column($salesByCategory, 'category_name');
        $categoryValues = array_map(
            'floatval',
            array_column($salesByCategory, 'category_sales')
        );

        $bestSellerLabels = array_column($topFiveItems, 'item_name');
        $bestSellerValues = array_map(
            'intval',
            array_column($topFiveItems, 'quantity_sold')
        );

        $orderLabels = array_column($ordersByStatus, 'status');
        $orderValues = array_map(
            'intval',
            array_column($ordersByStatus, 'order_count')
        );

        $chartData = [
            'weekly' => [
                'labels' => $weeklyLabels,
                'values' => $weeklyValues
            ],
            'categories' => [
                'labels' => $categoryLabels,
                'values' => $categoryValues
            ],
            'bestSellers' => [
                'labels' => $bestSellerLabels,
                'values' => $bestSellerValues
            ],
            'orders' => [
                'labels' => $orderLabels,
                'values' => $orderValues
            ]
        ];

        $date = new DateTime('now', $timezone);

        $fieldDate = strtoupper($date->format('d F Y'));
        $weekNumber = $date->format('W');
        $month = (int) $date->format('n');

        if ($month >= 3 && $month <= 5) {
            $seasonName = 'SPRING';
        } elseif ($month >= 6 && $month <= 8) {
            $seasonName = 'SUMMER';
        } elseif ($month >= 9 && $month <= 11) {
            $seasonName = 'AUTUMN';
        } else {
            $seasonName = 'WINTER';
        }

        require __DIR__ . '/../Views/admin/dashboard.php';
    }
}