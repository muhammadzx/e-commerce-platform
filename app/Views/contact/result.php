<?php
require_once __DIR__ . '/../../../config/paths.php';
$homeUrl = htmlspecialchars(nabta_public_url('index.php'), ENT_QUOTES, 'UTF-8');
$contactUrl = htmlspecialchars(nabta_public_url('index.php#contact-us'), ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Nabta | Nabta Botanical</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/nabta-theme.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/contact-result.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/store-responsive.css?v=20261101'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="botanical-edition">
<?php require __DIR__ . '/../layouts/header.php'; ?>
<main id="main" class="container contact-result-main">
  <section class="panel contact-result-card" role="status" aria-live="polite">
    <p class="eyebrow">NABTA SUPPORT</p>
    <h1><?= $success ? 'Thanks for reaching out.' : 'Your message could not be sent.' ?></h1>
    <p><?= htmlspecialchars($success ? 'Your message has been received. Our team will get back to you.' : (string) $error, ENT_QUOTES, 'UTF-8') ?></p>
    <p><a class="btn" href="<?= $success ? $homeUrl : $contactUrl ?>"><?= $success ? 'Back to home' : 'Return to contact form' ?></a></p>
  </section>
</main>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
