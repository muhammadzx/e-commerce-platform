
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>My account | Nabta Botanical</title>
  <meta name="description" content="Manage your Nabta account details." />
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#c5d4b4" />

  <link rel="icon" href="../../public/assets/img/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="../../public/assets/css/shared.css">
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../public/assets/css/canopy.css">
</head>

<body class="botanical-edition profile-page">

<a class="skip" href="#main">Skip to content</a>

<header class="header">
  <div class="container header-row">

    <a class="logo" href="#" aria-label="Nabta home">
      <svg class="leaf-logo" viewBox="0 0 36 36" aria-hidden="true">
        <path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z"/>
        <path d="M8 31 23 12"/>
      </svg>
      NABTA<span class="logo-sub">BOTANICAL</span>
    </a>

    <nav class="main-nav" aria-label="Main navigation">
      <a href="#">Shop all</a>
      <a href="#">Find your plant ↗</a>
    </nav>

    <div class="header-actions">
      <a href="#" aria-label="Search products">
        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
          <circle cx="10" cy="10" r="6"/>
          <path d="m15 15 5 5"/>
        </svg>
      </a>

      <a href="wishlist.php" aria-label="My wishlist">
        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10Z"/>
        </svg>
      </a>

      <a class="account-link" href="profile.php">My account</a>
      <a class="account-link register-link" href="#">Sign out</a>

      <a class="bag-link" href="#" aria-label="Shopping basket">
        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M5 7h14l1 14H4L5 7Z"/>
          <path d="M9 8V6a3 3 0 0 1 6 0v2"/>
        </svg>
        <span class="bag-count">0</span>
      </a>

      <details class="mobile-nav">
        <summary aria-label="Open navigation">☰</summary>
        <nav>
          <a href="#">Shop plants &amp; essentials</a>
          <a href="#">Plant assistant</a>
          <a href="profile.php">My account</a>
          <a href="wishlist.php">My wishlist</a>
          <a href="#">Sign out</a>
        </nav>
      </details>
    </div>
  </div>
</header>

<main id="main">
  <div class="container page-main">

    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <a href="#">Home</a>
      <span>/</span>
      <span>My account</span>
    </nav>

    <div class="page-heading">
      <div>
        <div class="eyebrow">MY ACCOUNT</div>
        <h1>Your space.</h1>
        <p>The details that make it yours.</p>
      </div>
    </div>

    <div class="account-layout" style="display:block">

      <div class="flex" style="flex-wrap:wrap;gap:12px;margin-bottom:24px">
        <a class="btn" href="profile.php">Personal information</a>
        <a class="btn secondary" href="#">My orders</a>
        <a class="btn secondary" href="wishlist.php">My wishlist</a>
        <a class="btn secondary" href="#">Sign out</a>
      </div>

      <section>
        <div class="panel">

          <div class="flex between">
            <div class="flex">
              <div class="account-avatar">SK</div>

              <div>
                <h3 style="margin-bottom:5px">Sara Khaled</h3>
                <p class="small">sara@example.com</p>
              </div>
            </div>

            <div class="flex">
              <button
                class="btn secondary"
                type="button"
                popovertarget="edit-profile">
                Edit profile ↗
              </button>

              <button
                class="btn secondary"
                type="button"
                popovertarget="change-password">
                Change password
              </button>
            </div>
          </div>

          <hr class="divider">

          <div class="form-grid">
            <div class="stack">
              <span class="label">Full name</span>
              <span>Sara Khaled</span>

              <span class="label">Email</span>
              <span>sara@example.com</span>
            </div>

            <div class="stack">
              <span class="label">Phone</span>
              <span>0792222222</span>

              <span class="label">Address</span>
              <span>Madaba</span>
            </div>
          </div>

        </div>
      </section>

    </div>
  </div>

  <!-- Edit Profile Popover -->
  <section
    id="edit-profile"
    class="popover"
    popover
    aria-labelledby="edit-profile-title">

    <div class="popover-top">
      <h2 id="edit-profile-title">Personal information</h2>

      <button
        class="icon-btn"
        type="button"
        popovertarget="edit-profile"
        popovertargetaction="hide"
        aria-label="Close window">
        ×
      </button>
    </div>

    <form method="post" action="#">

      <div class="field">
        <label for="name">Full name</label>
        <input
          id="name"
          name="full_name"
          type="text"
          required
          value="Sara Khaled"
          autocomplete="name">
      </div>

      <div class="field">
        <label for="email">Email address</label>
        <input
          id="email"
          name="email"
          type="email"
          required
          value="sara@example.com"
          autocomplete="email">
      </div>

      <div class="field">
        <label for="phone">Phone number</label>
        <input
          id="phone"
          name="phone"
          type="tel"
          value="0792222222"
          autocomplete="tel">
      </div>

      <div class="field">
        <label for="address">Address</label>
        <input
          id="address"
          name="address"
          type="text"
          value="Madaba"
          autocomplete="street-address">
      </div>

      <button class="btn" type="submit">Save changes</button>

    </form>
  </section>

  <!-- Change Password Popover -->
  <section
    id="change-password"
    class="popover"
    popover
    aria-labelledby="change-password-title">

    <div class="popover-top">
      <h2 id="change-password-title">Change password</h2>

      <button
        class="icon-btn"
        type="button"
        popovertarget="change-password"
        popovertargetaction="hide"
        aria-label="Close window">
        ×
      </button>
    </div>

    <form method="post" action="#">

      <div class="field">
        <label for="current_password">Current password</label>
        <input
          id="current_password"
          name="current_password"
          type="password"
          required
          autocomplete="current-password">
      </div>

      <div class="field">
        <label for="new_password">New password</label>
        <input
          id="new_password"
          name="new_password"
          type="password"
          minlength="8"
          required
          autocomplete="new-password">
      </div>

      <div class="field">
        <label for="confirm_password">Confirm new password</label>
        <input
          id="confirm_password"
          name="confirm_password"
          type="password"
          minlength="8"
          required
          autocomplete="new-password">
      </div>

      <button class="btn" type="submit">Update password</button>

    </form>
  </section>

</main>

<footer class="footer">
  <div class="container">

    <div class="footer-grid">

      <div>
        <a class="logo" href="#" aria-label="Nabta home">
          <svg class="leaf-logo" viewBox="0 0 36 36" aria-hidden="true">
            <path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z"/>
            <path d="M8 31 23 12"/>
          </svg>
          NABTA<span class="logo-sub">BOTANICAL</span>
        </a>

        <p>
          A little nature, closer to home.<br>
          Plants, thoughtful objects, and everyday growing essentials.
        </p>
      </div>

      <div>
        <div class="footer-title">GROW YOUR SPACE</div>
        <nav class="footer-links">
          <a href="#">Shop the collection</a>
          <a href="#">Plant assistant</a>
        </nav>
      </div>

      <div>
        <div class="footer-title">YOUR NABTA</div>
        <nav class="footer-links">
          <a href="profile.php">My account</a>
          <a href="wishlist.php">My wishlist</a>
        </nav>
      </div>

      <div>
        <div class="footer-title">ROOTED IN THE EVERYDAY</div>
        <p>
          For windowsills, balconies, and the small corners that make a home.
        </p>
      </div>

    </div>

    <div class="footer-bottom">
      <span>© 2026 Nabta Botanical</span>
      <span>Jordan / JOD</span>
    </div>

  </div>
</footer>

</body>
</html>
