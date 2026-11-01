<?php
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
require_once __DIR__ . '/../../../config/paths.php';
$profileName = (string) ($adminUser['full_name'] ?? '');
$profileEmail = (string) ($adminUser['email'] ?? '');
$profilePhone = (string) ($adminUser['phone'] ?? '');
$profileAddress = (string) ($adminUser['address'] ?? '');
$profileId = (int) ($adminUser['user_id'] ?? 0);
$profileInitialCharacters = preg_split('//u', (string) preg_replace('/\s+/u', '', $profileName), -1, PREG_SPLIT_NO_EMPTY) ?: [];
$profileInitials = strtoupper(($profileInitialCharacters[0] ?? 'A') . ($profileInitialCharacters[1] ?? ''));
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <title>My profile | Nabta Botanical</title>
  <meta name="description" content="Manage your administrator profile at Nabta." />
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#FFF9EF" />

  <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/palette-overrides.css?v=' . (int) @filemtime(__DIR__ . '/../../../public/assets/css/palette-overrides.css')), ENT_QUOTES, 'UTF-8') ?>">
</head>

<body class="admin-body botanical-edition workspace-page admin-profile profile-page">

<main id="main">
  <div class="admin-shell">

    <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>

    <!-- MAIN CONTENT -->
    <div class="admin-content">

      <!-- ADMIN HEADER -->
      <div class="admin-top">
        <span>Workspace / My profile</span>

        <div class="flex">
          <span>Nabta Botanical</span>
          <span class="pill">Admin</span>
        </div>
      </div>

      <!-- BOTANICAL BANNER -->
      <div
        class="admin-photo-strip"
        role="img"
        aria-label="Soft-focus botanical greenhouse photograph"
      >
        <span>
          CANOPY / BOTANICAL OPERATIONS
          <small>GROWTH · STOCK · CUSTOMER CARE</small>
        </span>
      </div>

      <!-- PAGE TITLE -->
      <div class="admin-title">
        <div>
          <h1>My profile</h1>
          <p>Your administrator account details.</p>
        </div>
      </div>

      <!-- ADMIN PROFILE -->
      <section>
        <div class="panel">

          <div class="flex between">

            <!-- AVATAR, NAME AND EMAIL -->
            <div class="flex">
              <div class="account-avatar"><?= htmlspecialchars($profileInitials !== '' ? $profileInitials : 'AD', ENT_QUOTES, 'UTF-8') ?></div>

              <div>
                <h3 style="margin-bottom:5px"><?= htmlspecialchars($profileName, ENT_QUOTES, 'UTF-8') ?></h3>
                <p class="small"><?= htmlspecialchars($profileEmail, ENT_QUOTES, 'UTF-8') ?></p>
                <p class="small">Administrator ID: #<?= $profileId ?></p>
              </div>
            </div>

            <!-- PROFILE BUTTONS -->
            <div class="flex profile-actions">

              <button
                class="btn secondary"
                type="button"
                popovertarget="edit-profile"
              >
                Edit profile ↗
              </button>

              <button
                class="btn secondary"
                type="button"
                popovertarget="change-password"
              >
                Change password
              </button>

            </div>
          </div>

          <hr class="divider">

          <!-- ADMIN INFORMATION -->
          <div class="form-grid">

            <div class="stack">
              <span class="label">Full name</span>
              <span><?= htmlspecialchars($profileName, ENT_QUOTES, 'UTF-8') ?></span>

              <span class="label">Email</span>
              <span><?= htmlspecialchars($profileEmail, ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <div class="stack">
              <span class="label">Phone</span>
              <span><?= htmlspecialchars($profilePhone, ENT_QUOTES, 'UTF-8') ?></span>

              <span class="label">Address</span>
              <span><?= $profileAddress !== '' ? htmlspecialchars($profileAddress, ENT_QUOTES, 'UTF-8') : 'Not provided' ?></span>
            </div>

          </div>

        </div>
      </section>

    </div>
  </div>

  <!-- EDIT PROFILE POPOVER -->
  <section
    id="edit-profile"
    class="popover"
    popover
    aria-labelledby="edit-profile-title"
  >
    <div class="popover-top">
      <h2 id="edit-profile-title">Edit profile</h2>

      <button
        class="icon-btn"
        type="button"
        popovertarget="edit-profile"
        popovertargetaction="hide"
        aria-label="Close window"
      >×</button>
    </div>

    <form method="post" action="#">
      <div class="field">
        <label for="admin-name">Full name</label>
        <input
          id="admin-name"
          name="full_name"
          type="text"
          required
          value="<?= htmlspecialchars($profileName, ENT_QUOTES, 'UTF-8') ?>"
          autocomplete="name"
        >
      </div>

      <div class="field">
        <label for="admin-email">Email address</label>
        <input
          id="admin-email"
          name="email"
          type="email"
          required
          value="<?= htmlspecialchars($profileEmail, ENT_QUOTES, 'UTF-8') ?>"
          autocomplete="email"
        >
      </div>

      <div class="field">
        <label for="admin-phone">Phone number</label>
        <input
          id="admin-phone"
          name="phone"
          type="tel"
          value="<?= htmlspecialchars($profilePhone, ENT_QUOTES, 'UTF-8') ?>"
          autocomplete="tel"
        >
      </div>

      <div class="field">
        <label for="admin-address">Address</label>
        <input
          id="admin-address"
          name="address"
          type="text"
          value="<?= htmlspecialchars($profileAddress, ENT_QUOTES, 'UTF-8') ?>"
          autocomplete="street-address"
        >
      </div>

      <button class="btn" type="submit">Save changes</button>
    </form>
  </section>

  <!-- CHANGE PASSWORD POPOVER -->
  <section
    id="change-password"
    class="popover"
    popover
    aria-labelledby="change-password-title"
  >
    <div class="popover-top">
      <h2 id="change-password-title">Change password</h2>

      <button
        class="icon-btn"
        type="button"
        popovertarget="change-password"
        popovertargetaction="hide"
        aria-label="Close window"
      >×</button>
    </div>

    <form method="post" action="#">
      <div class="field">
        <label for="current-password">Current password</label>
        <input
          id="current-password"
          name="current_password"
          type="password"
          required
          autocomplete="current-password"
        >
      </div>

      <div class="field">
        <label for="new-password">New password</label>
        <input
          id="new-password"
          name="new_password"
          type="password"
          minlength="8"
          required
          autocomplete="new-password"
        >
      </div>

      <div class="field">
        <label for="confirm-password">Confirm new password</label>
        <input
          id="confirm-password"
          name="confirm_password"
          type="password"
          minlength="8"
          required
          autocomplete="new-password"
        >
      </div>

      <button class="btn" type="submit">Update password</button>
    </form>
  </section>

</main>

</body>
</html>
