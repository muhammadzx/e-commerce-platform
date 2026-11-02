<?php
$adminHeaderName = trim((string) ($adminUser['full_name'] ?? 'Admin')) ?: 'Admin';
?>
<header class="admin-top admin-page-header">
  <span class="admin-header-location">Workspace / <?= htmlspecialchars($adminHeaderTitle, ENT_QUOTES, 'UTF-8') ?></span>
  <p class="admin-header-welcome">Welcome back, <strong><?= htmlspecialchars($adminHeaderName, ENT_QUOTES, 'UTF-8') ?></strong></p>
  <span class="pill admin-header-page"><?= htmlspecialchars($adminHeaderTitle, ENT_QUOTES, 'UTF-8') ?></span>
</header>
