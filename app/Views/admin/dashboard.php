<?php
require_once __DIR__ . '/../../../config/paths.php';
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
if (!isset($overviewStats)) {
    header('Location: ' . nabta_public_url('admin/dashboard.php'));
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Store overview | NABTA Botanical</title>
  <meta name="description" content="NABTA Botanical admin workspace overview.">
  <meta name="robots" content="noindex,nofollow">
  <meta name="theme-color" content="#FFF9EF">
<link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
<link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
<link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
<link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
<link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/palette-overrides.css?v=' . (int) @filemtime(__DIR__ . '/../../../public/assets/css/palette-overrides.css')), ENT_QUOTES, 'UTF-8') ?>">
<link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/ui.css?v=' . (int) filemtime(__DIR__ . '/../../../public/assets/css/ui.css')), ENT_QUOTES, 'UTF-8') ?>">
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/ui.js?v=' . (int) filemtime(__DIR__ . '/../../../public/assets/js/ui.js')), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</head>

<body class="admin-body botanical-edition workspace-page admin-overview">
  <main id="main">
    <div class="admin-shell">
      <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
      <div class="admin-content">
        <div class="admin-top">
          <span>Workspace / Overview</span>
          <div class="flex">
            <span>NABTA Botanical</span>
            <span class="pill">Store overview</span>
          </div>
        </div>

        <section class="desk-intro" aria-labelledby="overview-title">
          <div>
            <div class="season-mark">FIELD NOTES · <?= htmlspecialchars($fieldDate, ENT_QUOTES, 'UTF-8') ?></div>
            <h1 id="overview-title">Store overview</h1>
            <p>A clear view of sales, orders, products, and customer demand.</p>
          </div>
          <div class="overview-intro-actions">
            <a class="btn overview-ai-button" href="<?= htmlspecialchars(nabta_public_url('admin/ai_reports.php'), ENT_QUOTES, 'UTF-8') ?>">Request an AI report <span
                aria-hidden="true">↗</span></a>
            <span class="desk-date"><?= htmlspecialchars($seasonName, ENT_QUOTES, 'UTF-8') ?>
              / WEEK
              <?= htmlspecialchars($weekNumber, ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </section>

        <?php if ($notes['low_stock_count'] > 0): ?>
          <aside class="overview-alert" aria-label="Low stock notice">
            <div>
              <strong>
                <?= (int) $notes['low_stock_count'] ?>
                products running low
              </strong>

              <p>
                <?= htmlspecialchars($notes['lowest_stock']['name'], ENT_QUOTES, 'UTF-8') ?>
                has only
                <?= (int) $notes['lowest_stock']['quantity'] ?>
                units in stock.
              </p>
            </div>

            <a href="<?= htmlspecialchars(nabta_public_url('admin/products.php'), ENT_QUOTES, 'UTF-8') ?>">Review products ↗</a>
          </aside>
        <?php endif; ?>
        <section class="desk-kpis" aria-label="Store statistics">
          <article class="kpi-card kpi-sales">
            <i aria-hidden="true"></i>
            <small>Gross sales / today</small>
            <strong><?= number_format((float) $overviewStats['today_sales'], 2) . ' JOD' ?></strong>
          </article>
          <article class="kpi-card kpi-orders">
            <i aria-hidden="true"></i>
            <small>Orders in motion</small>
            <strong><?= (int) $overviewStats['orders_in_motion'] ?></strong>
          </article>
          <article class="kpi-card kpi-units">
            <i aria-hidden="true"></i>
            <small>Units sold</small>
            <strong><?= (int) $overviewStats['units_sold'] ?></strong>
          </article>
          <article class="kpi-card kpi-families">
            <i aria-hidden="true"></i>
            <small>Product families</small>
            <strong><?= (int) $overviewStats['product_families'] ?></strong>
          </article>
        </section>

        <section class="overview-section" aria-labelledby="charts-first-title">
          <div class="overview-section-heading">
            <div>
              <div class="eyebrow">SALES &amp; DEMAND</div>
              <h2 id="charts-first-title">What is moving in the store</h2>
            </div>
          </div>
          <div class="overview-chart-grid">
            <section class="panel overview-chart-card chart-best" aria-labelledby="best-chart-title">
              <div class="eyebrow">BEST SELLERS</div>
              <h2 id="best-chart-title">Products &amp; packages sold</h2>
              <div class="overview-canvas-wrap">
                <canvas role="img" id="bestSellersChart" aria-label="Top five products and packages by units sold"></canvas>
              </div>
              <p class="overview-chart-note">Ranked by quantity sold across completed orders.</p>
            </section>
            <section class="panel overview-chart-card chart-category" aria-labelledby="category-chart-title">
              <div class="eyebrow">CATEGORY PERFORMANCE</div>
              <h2 id="category-chart-title">Sales by category</h2>
              <div class="overview-canvas-wrap">
                <canvas role="img" id="categorySalesChart" aria-label="Sales grouped by product category and packages"></canvas>
              </div>
              <p class="overview-chart-note">Package sales are shown as a separate group.</p>
            </section>
          </div>
        </section>

        <section class="overview-summary-grid" aria-label="Best selling items and category">
          <section class="panel" aria-labelledby="top-items-title">
            <div class="overview-section-heading">
              <div>
                <div class="eyebrow">MOST PURCHASED</div>
                <h2 id="top-items-title">Top 5 products &amp; packages</h2>
              </div>
              <button class="overview-show-all" type="button" data-open-best-sellers>Show all</button>
            </div>
            <ol class="overview-best-list">

              <?php foreach ($topFiveItems as $top): ?>
                <li>
                  <span class="overview-item-name">
                    <strong><?= htmlspecialchars($top['item_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <small><?= htmlspecialchars($top['item_type'], ENT_QUOTES, 'UTF-8') ?></small>
                  </span>

                  <span class="overview-quantity">
                    <?= (int) $top['quantity_sold'] ?> sold
                  </span>
                </li>
              <?php endforeach; ?>
            </ol>
          </section>

          <section class="overview-category-feature" aria-labelledby="top-category-title">
            <div>
              <small>TOP CATEGORY BY SALES</small>
              <?php foreach ($topThreeCategories as $top): ?>

                <h3>
                  <?= htmlspecialchars($top['category_name'], ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <strong>
                  <?= number_format((float) $top['category_sales'], 2) ?> JOD
                </strong>
                <hr>
              <?php endforeach; ?>
          </section>
        </section>

        <section class="overview-section" aria-labelledby="activity-charts-title">
          <div class="overview-section-heading">
            <div>
              <div class="eyebrow">STORE ACTIVITY</div>
              <h2 id="activity-charts-title">Recent sales &amp; order flow</h2>
            </div>
          </div>
          <div class="overview-chart-grid">
            <section class="panel overview-chart-card chart-weekly" aria-labelledby="weekly-chart-title">
              <div class="eyebrow">LAST SEVEN DAYS</div>
              <h2 id="weekly-chart-title">Daily sales</h2>
              <div class="overview-canvas-wrap">
                <canvas role="img" id="weeklySalesChart" aria-label="Completed order sales for the last seven days"></canvas>
              </div>
            </section>
            <section class="panel overview-chart-card chart-orders" aria-labelledby="orders-chart-title">
              <div class="eyebrow">ORDER WORKFLOW</div>
              <h2 id="orders-chart-title">Orders by status</h2>
              <div class="overview-canvas-wrap">
                <canvas role="img" id="ordersStatusChart" aria-label="Order counts grouped by order status"></canvas>
              </div>
            </section>
          </div>
        </section>

        <dialog class="overview-modal" id="bestSellersDialog" aria-labelledby="best-sellers-dialog-title">
          <div class="overview-modal-inner">
            <div class="overview-modal-head">
              <h2 id="best-sellers-dialog-title">All best-selling items</h2>
              <button class="overview-modal-close" type="button" data-close-best-sellers aria-label="Close">×</button>
            </div>
            <ol class="overview-best-list overview-modal-list">

              <?php foreach ($bestItems as $top): ?>
                <li>
                  <span class="overview-item-name">
                    <strong><?= htmlspecialchars($top['item_name'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <small><?= htmlspecialchars($top['item_type'], ENT_QUOTES, 'UTF-8') ?></small>
                  </span>

                  <span class="overview-quantity">
                    <?= (int) $top['quantity_sold'] ?> sold
                  </span>
                </li>
              <?php endforeach; ?>
            </ol>
          </div>
        </dialog>

  <section class="chart-data-tables" aria-label="Chart data tables"><h2>Dashboard data</h2><p>The same figures are available below, including when charts cannot load.</p><?php foreach (['bestSellers'=>'Best sellers (units)', 'categories'=>'Sales by category (JOD)', 'weekly'=>'Daily sales (JOD)', 'orders'=>'Orders by status (count)'] as $key=>$title): ?><details><summary><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></summary><table class="chart-data-table"><thead><tr><th scope="col">Label</th><th scope="col">Value</th></tr></thead><tbody><?php foreach ($chartData[$key]['labels'] as $i=>$label): ?><tr><th scope="row"><?= htmlspecialchars((string)$label, ENT_QUOTES, 'UTF-8') ?></th><td><?= htmlspecialchars((string)($chartData[$key]['values'][$i] ?? 0), ENT_QUOTES, 'UTF-8') ?></td></tr><?php endforeach; ?><?php if (!$chartData[$key]['labels']): ?><tr><td colspan="2">No data available</td></tr><?php endif; ?></tbody></table></details><?php endforeach; ?></section>
        <div class="dashboard-footer-note">Store figures are based on the data currently available.
        </div>
      </div>
    </div>
  </main>


  <script id="overview-chart-data" type="application/json">
  <?= json_encode(
    $chartData,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
  ) ?>
</script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js" defer></script>
  <script src="<?= htmlspecialchars(nabta_public_url('assets/js/admin.js'), ENT_QUOTES, 'UTF-8') ?>" defer></script>
</body>

</html>
