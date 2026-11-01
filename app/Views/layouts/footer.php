<?php
// Site footer shared by every customer page (taken from the landing page).
// Include it just before </body>.
require_once __DIR__ . '/../../Core/Security.php';

$footUrl = static fn(string $path): string => htmlspecialchars(nabta_public_url($path), ENT_QUOTES, 'UTF-8');
?>
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <a class="logo" href="<?= $footUrl('index.php') ?>" aria-label="Nabta home"><svg class="leaf-logo" viewBox="0 0 36 36"
            aria-hidden="true">
            <path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z" />
            <path d="M8 31 23 12" />
          </svg>NABTA<span class="logo-sub">BOTANICAL</span></a>
        <p>
          A little nature, closer to home.<br />Plants, thoughtful objects,
          and everyday growing essentials.
        </p>
      </div>
      <div>
        <div class="footer-title">GROW YOUR SPACE</div>
        <nav class="footer-links">
          <a href="<?= $footUrl('index.php?page=products') ?>">Shop the collection</a><a
            href="<?= $footUrl('index.php#bundles') ?>">Seasonal offers</a><a
            href="<?= $footUrl('index.php?page=about') ?>">About Nabta</a>
        </nav>
      </div>
      <div>
        <div class="footer-title">YOUR NABTA</div>
        <nav class="footer-links">
          <a href="<?= $footUrl('index.php?page=profile') ?>">My account</a><a
            href="<?= $footUrl('index.php?page=profile#orders') ?>">My orders</a><a
            href="<?= $footUrl('index.php?page=cart') ?>">My basket</a>
        </nav>
      </div>
      <div>
        <div class="footer-title">STORE INFORMATION</div><nav class="footer-links"><a href="<?= $footUrl('index.php?page=information') ?>">Delivery, returns, terms &amp; privacy</a><a href="<?= $footUrl('account-help.php') ?>">Account access help</a></nav>
        <p>
          For windowsills, balconies, and the small corners that make a
          home.
        </p>
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <?= date("Y") ?> Nabta Botanical</span><span>Jordan
        / JOD</span>
    </div>
  </div>
</footer>
