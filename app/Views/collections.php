<?php
// Collections page: every active collection, read from the database.
$u = static fn(string $path): string => htmlspecialchars(nabta_public_url($path), ENT_QUOTES, 'UTF-8');
$cxLimit = PHP_INT_MAX;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Packages | NABTA Botanical</title>
    <meta name="description" content="Thoughtfully paired sets of plants, pots, soil and tools from Nabta.">
    <link rel="icon" href="<?= $u('assets/img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= $u('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css?v=2') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/bundlesLandingPage.css?v=11') ?>">
    <!-- Cart styles stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=2') ?>">
    <style>
        /* The card colours come from sheets this page does not load, so set them here */
        .collections-page .bundle-card {
            background: rgba(255, 254, 250, 0.94);
            border: 1px solid #E8D5B8;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 28px rgba(70, 58, 36, 0.08);
        }

        .collections-page .bundle-card:hover {
            border-color: #3B9B63;
        }

        .collections-page .bundle-photo {
            background: linear-gradient(160deg, #FFF3DE, #F8D9AE);
        }
    </style>
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="collections-page">

<div class="nature-bg" aria-hidden="true">
    <div class="tree" id="tree"></div>
    <div class="leaves" id="leaves"></div>
</div>
<div class="sunlight" aria-hidden="true">
    <div class="rays"></div>
    <div class="glints"></div>
</div>

<?php require __DIR__ . '/layouts/header.php'; ?>

<main id="main" tabindex="-1" style="padding-top: 48px"><div class="container"><h1 class="page-title">Plant &amp; growing collections</h1></div>

    <?php require __DIR__ . '/layouts/collections-section.php'; ?>
</main>

<?php require __DIR__ . '/layouts/footer.php'; ?>

<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
</body>
</html>
