<?php
// Site header shared by every customer page (taken from the landing page).
// Needs the session (bootstrap.php) and config/paths.php. Include it right after <body>.
require_once __DIR__ . '/../../Core/Security.php';
require __DIR__ . '/cart-count.php';
require __DIR__ . '/report-shortcut.php';

$navUrl = static fn(string $path): string => htmlspecialchars(nabta_public_url($path), ENT_QUOTES, 'UTF-8');
$navIsAdmin = is_authenticated() && ($_SESSION['role'] ?? '') === 'admin';
$navFirstName =explode(' ', trim((string) ($_SESSION['full_name'] ?? '')))[0] ?: 'there';
?>
<link rel="stylesheet" href="<?= $navUrl('assets/css/site-header.css?v=' . (int) @filemtime(__DIR__ . '/../../../public/assets/css/site-header.css')) ?>">
<link rel="stylesheet" href="<?= $navUrl('assets/css/warm-theme.css?v=' . (int) @filemtime(__DIR__ . '/../../../public/assets/css/warm-theme.css')) ?>">
<link rel="stylesheet" href="<?= $navUrl('assets/css/palette-overrides.css?v=' . (int) @filemtime(__DIR__ . '/../../../public/assets/css/palette-overrides.css')) ?>">
<link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/ui.css?v=' . (int) filemtime(__DIR__ . '/../../../public/assets/css/ui.css')), ENT_QUOTES, 'UTF-8') ?>">
<script src="<?= htmlspecialchars(nabta_public_url('assets/js/ui.js?v=' . (int) filemtime(__DIR__ . '/../../../public/assets/js/ui.js')), ENT_QUOTES, 'UTF-8') ?>" defer></script>
<a class="skip" href="#main">Skip to content</a>
<header class="header">
  <div class="container header-row">
    <a class="logo" href="<?= $navUrl('index.php') ?>" aria-label="Nabta home"><svg class="leaf-logo" viewBox="0 0 36 36"
        aria-hidden="true">
        <path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z" />
        <path d="M8 31 23 12" />
      </svg>NABTA<span class="logo-sub">BOTANICAL</span></a>

    <nav id="primary-navigation" class="main-nav" aria-label="Main navigation">
      <a href="<?= $navUrl('index.php') ?>">Home</a>
      <a href="<?= $navUrl('index.php?page=products') ?>">Shop</a>
      <a href="<?= $navUrl('index.php?page=about') ?>">About Us</a>
      <a href="<?= $navUrl('index.php?page=collections') ?>">Packages</a>
      <?php if ($navIsAdmin): ?><a href="<?= $navUrl('admin/dashboard.php') ?>">Dashboard</a><?php endif; ?>
    </nav>

    <div class="header-actions">
      <?php if (is_authenticated()): ?><a class="account-link" href="<?= $navUrl('index.php?page=profile') ?>"
          aria-label="Signed in account">Hi, <?= e($navFirstName) ?></a>
        <form class="logout-form" action="<?= $navUrl('logout.php') ?>" method="post"><?= csrf_field() ?><button class="account-link"
            type="submit">Sign out</button></form><?php else: ?><a class="account-link login-cta"
          href="<?= $navUrl('login.php') ?>">Login</a><?php endif; ?><a id="header-basket" class="bag-link" href="<?= $navUrl('index.php?page=cart') ?>"
        aria-label="Shopping basket"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M5 7h14l1 14H4L5 7Z" />
          <path d="M9 8V6a3 3 0 0 1 6 0v2" />
        </svg><span class="bag-count" data-cart-count<?= $navCartCount > 0 ? '' : ' style="display:none"' ?>><?= (int) $navCartCount ?></span></a>
      <details class="mobile-nav">
        <summary aria-label="Open navigation">☰</summary>
        <nav>
          <a href="<?= $navUrl('index.php') ?>">Home</a><a href="<?= $navUrl('index.php?page=products') ?>">Shop</a><a
            href="<?= $navUrl('index.php?page=about') ?>">About us</a><a
            href="<?= $navUrl('index.php?page=collections') ?>">Packages</a><?php if ($navIsAdmin): ?><a href="<?= $navUrl('admin/dashboard.php') ?>">Dashboard</a><?php endif; ?><?php if (is_authenticated()): ?><a
              href="<?= $navUrl('index.php?page=profile') ?>">My account</a>
            <form class="logout-form" action="<?= $navUrl('logout.php') ?>" method="post"><?= csrf_field() ?><button type="submit">Sign
                out</button></form><?php else: ?><a href="<?= $navUrl('login.php') ?>">Login</a><?php endif; ?>
        </nav>
      </details>
    </div>
  </div>
</header>
