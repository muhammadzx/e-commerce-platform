
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <title>My profile | Nabta Botanical</title>
  <meta name="description" content="Manage your administrator profile at Nabta." />
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#c5d4b4" />

  <link rel="icon" href="../../../public/assets/img/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="../../../public/assets/css/shared.css">
  <link rel="stylesheet" href="../../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../../public/assets/css/canopy.css">
</head>

<body class="admin-body botanical-edition workspace-page profile-page">

<main id="main">
  <div class="admin-shell">

    <!-- ADMIN SIDEBAR -->
    <aside class="admin-sidebar">

      <a class="logo" href="/php/e-commerce%20platform/public/index.php" aria-label="Nabta home">
        <svg class="leaf-logo" viewBox="0 0 36 36" aria-hidden="true">
          <path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z"/>
          <path d="M8 31 23 12"/>
        </svg>
        NABTA<span class="logo-sub">BOTANICAL</span>
      </a>

      <div>
        <div class="eyebrow" style="padding:0 12px 15px">
          WORKSPACE
        </div>

        <nav aria-label="Administration">

          <a class="overview-link" href="/php/e-commerce%20platform/public/admin/dashboard.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z"/>
            </svg>
            Overview
          </a>

          <a class="products-link" href="/php/e-commerce%20platform/app/Views/admin/products.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="m12 3 9 5v9l-9 5-9-5V8l9-5Zm-9 5 9 5 9-5M12 13v9"/>
            </svg>
            Products
          </a>

          <a class="ai-reports-link" href="/php/e-commerce%20platform/app/Views/admin/ai_reports.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 3v3M12 18v3M3 12h3m12 0h3M5.64 5.64l2.12 2.12m8.48 8.48 2.12 2.12m0-12.72-2.12 2.12m-8.48 8.48-2.12 2.12"/>
              <circle cx="12" cy="12" r="5"/>
            </svg>
            AI Reports
          </a>

          <a class="categories-link" href="/php/e-commerce%20platform/app/Views/admin/categories.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z"/>
            </svg>
            Categories
          </a>

          <a class="customers-link" href="/php/e-commerce%20platform/app/Views/admin/customers.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <circle cx="12" cy="8" r="3"/>
              <path d="M5 21v-3a7 7 0 0 1 14 0v3"/>
            </svg>
            Customers
          </a>

          <a class="orders-link" href="/php/e-commerce%20platform/app/Views/admin/orders.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M5 7h14l1 14H4L5 7Z"/>
              <path d="M9 8V6a3 3 0 0 1 6 0v2"/>
            </svg>
            Orders
          </a>

          <a class="reviews-link" href="/php/e-commerce%20platform/app/Views/admin/reviews.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="m12 3 3 6 6 1-4 5 1 6-6-3-6 3 1-6-4-5 6-1Z"/>
            </svg>
            Reviews
          </a>

          <a class="store-link" href="/php/e-commerce%20platform/public/index.php">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M3 10 5 4h14l2 6"/>
              <path d="M4 10v10h16V10M9 20v-6h6v6"/>
              <path d="M3 10a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/>
            </svg>
            View storefront
          </a>

        </nav>
      </div>

      <div class="admin-bottom">
        <a class="profile-link" href="/php/e-commerce%20platform/app/Views/admin/profile.php">
          <span class="account-avatar">AS</span>
          <span>
            <strong>Alex</strong>
            <small>Store admin · Profile</small>
          </span>
          <span class="profile-arrow" aria-hidden="true">↗</span>
        </a>
      </div>

    </aside>

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
              <div class="account-avatar">MA</div>

              <div>
                <h3 style="margin-bottom:5px">Mohammad Ahmad</h3>
                <p class="small">mohammad@example.com</p>
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
              <span>Mohammad Ahmad</span>

              <span class="label">Email</span>
              <span>mohammad@example.com</span>
            </div>

            <div class="stack">
              <span class="label">Phone</span>
              <span>0791111111</span>

              <span class="label">Address</span>
              <span>Amman</span>
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
          value="Mohammad Ahmad"
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
          value="mohammad@example.com"
          autocomplete="email"
        >
      </div>

      <div class="field">
        <label for="admin-phone">Phone number</label>
        <input
          id="admin-phone"
          name="phone"
          type="tel"
          value="0791111111"
          autocomplete="tel"
        >
      </div>

      <div class="field">
        <label for="admin-address">Address</label>
        <input
          id="admin-address"
          name="address"
          type="text"
          value="Amman"
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
