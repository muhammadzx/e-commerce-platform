<?php
// TEMPORARY preview of the DB-driven collections section. Delete with _tmp_login.php.
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../app/Views/bootstrap.php';

$css = static fn(string $f): string => htmlspecialchars(nabta_public_url('assets/css/' . $f), ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Collections preview</title>
  <link rel="stylesheet" href="<?= $css('style.css?v=10') ?>">
  <link rel="stylesheet" href="<?= $css('home.css?v=18') ?>">
  <link rel="stylesheet" href="<?= $css('botanical.css?v=10') ?>">
  <link rel="stylesheet" href="<?= $css('bundlesLandingPage.css?v=11') ?>">
  <link rel="stylesheet" href="<?= $css('nabta-theme.css?v=18') ?>">
</head>
<body class="garden-home botanical-edition index-page">
  <?php require __DIR__ . '/../app/Views/layouts/cart-link.php'; ?>
  <main id="main">
    <?php require __DIR__ . '/../app/Views/layouts/collections-section.php'; ?>
  </main>
</body>
</html>
