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
    <title>Collections | NABTA Botanical</title>
    <meta name="description" content="Thoughtfully paired sets of plants, pots, soil and tools from Nabta.">
    <link rel="icon" href="<?= $u('assets/img/favicon.svg') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= $u('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nature-bg.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/nabta-theme.css') ?>">
    <link rel="stylesheet" href="<?= $u('assets/css/bundlesLandingPage.css?v=11') ?>">
    <!-- Cart styles stay LAST so they win over the older sheets -->
    <link rel="stylesheet" href="<?= $u('assets/css/cart.css?v=1') ?>">
    <style>
        /* The card colours come from sheets this page does not load, so set them here */
        .collections-page .bundle-card {
            background: rgba(22, 56, 50, 0.78);
            border: 1px solid rgba(142, 182, 155, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .collections-page .bundle-card:hover {
            border-color: rgba(212, 242, 123, 0.55);
        }

        .collections-page .bundle-photo {
            background: linear-gradient(160deg, #1d5446, #0f3029);
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

<main id="main" style="padding-top: 48px">

    <?php require __DIR__ . '/layouts/collections-section.php'; ?>
</main>

<?php require __DIR__ . '/layouts/footer.php'; ?>

<script src="<?= $u('assets/js/nature-bg.js') ?>" defer></script>
</body>
</html>
