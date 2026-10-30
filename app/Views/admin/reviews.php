
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <title>Reviews | Nabta Botanical</title>
  <meta name="description" content="Read customer reviews — plants and growing essentials at Nabta." />
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#c5d4b4" />

  <link rel="icon" href="../../../public/assets/img/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="../../../public/assets/css/shared.css">
  <link rel="stylesheet" href="../../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../../public/assets/css/canopy.css">

  <style>
    .review-hidden {
      opacity: 0.55;
    }

    .hidden-label {
      margin-left: 8px;
      font-size: 11px;
    }

    .table-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }

    .delete-button {
      color: #b42318;
    }

    .hide-button {
      color: #8a6500;
    }
  </style>
</head>

<body class="admin-body botanical-edition workspace-page">

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

      <div class="admin-top">
        <span>Workspace / Reviews</span>

        <div class="flex">
          <span>Mohammad Ahmad</span>
          <span class="pill">Admin</span>
        </div>
      </div>

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

      <div class="admin-title">
        <div>
          <h1>Reviews</h1>
          <p>Hear from the people growing with Nabta.</p>
        </div>
      </div>

      <!-- REVIEWS TABLE -->
      <section class="panel">

        <form class="toolbar" method="get" action="#">
          <label class="sr-only" for="search-records">Search reviews</label>

          <input
            class="control"
            id="search-records"
            name="q"
            type="search"
            placeholder="Search by item, customer or text"
          >

          <select class="control" name="rating" aria-label="Filter by rating">
            <option value="">All ratings</option>
            <option value="5">5 stars</option>
            <option value="4">4 stars</option>
            <option value="3">3 stars</option>
            <option value="2">2 stars</option>
            <option value="1">1 star</option>
          </select>

          <button class="btn secondary" type="submit">Search</button>
          <span class="label" id="record-count">3 records</span>
        </form>

        <div class="table-scroll">
          <table>
            <thead>
              <tr>
                <th>Item</th>
                <th>Type</th>
                <th>Customer</th>
                <th>Rating</th>
                <th>Review</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody id="reviews-table">

              <!-- REVIEW 1 -->
              <tr>
                <td data-label="Item">Monstera</td>

                <td data-label="Type">
                  <span class="pill">Product</span>
                </td>

                <td data-label="Customer">Mohammad Ahmad</td>

                <td data-label="Rating">
                  <span class="rating">★★★★★</span>
                </td>

                <td data-label="Review">
                  Excellent product, arrived in good condition
                  <span class="pill hidden-label" hidden>Hidden</span>
                </td>

                <td data-label="Actions">
                  <div class="table-actions">
                    <button class="table-button" popovertarget="view-1">
                      View
                    </button>

                    <button class="table-button hide-button" type="button" data-action="hide">
                      Hide
                    </button>

                    <button class="table-button delete-button" type="button" data-action="delete">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>

              <!-- REVIEW 2 -->
              <tr>
                <td data-label="Item">Peace Lily</td>

                <td data-label="Type">
                  <span class="pill">Product</span>
                </td>

                <td data-label="Customer">Sara Khaled</td>

                <td data-label="Rating">
                  <span class="rating">★★★★☆</span>
                </td>

                <td data-label="Review">
                  Beautiful plant and easy to care for
                  <span class="pill hidden-label" hidden>Hidden</span>
                </td>

                <td data-label="Actions">
                  <div class="table-actions">
                    <button class="table-button" popovertarget="view-2">
                      View
                    </button>

                    <button class="table-button hide-button" type="button" data-action="hide">
                      Hide
                    </button>

                    <button class="table-button delete-button" type="button" data-action="delete">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>

              <!-- REVIEW 3 -->
              <tr>
                <td data-label="Item">Organic Care Collection</td>

                <td data-label="Type">
                  <span class="pill">Collection</span>
                </td>

                <td data-label="Customer">Yasmin Samir</td>

                <td data-label="Rating">
                  <span class="rating">★★★★☆</span>
                </td>

                <td data-label="Review">
                  Useful collection at a good price
                  <span class="pill hidden-label" hidden>Hidden</span>
                </td>

                <td data-label="Actions">
                  <div class="table-actions">
                    <button class="table-button" popovertarget="view-6">
                      View
                    </button>

                    <button class="table-button hide-button" type="button" data-action="hide">
                      Hide
                    </button>

                    <button class="table-button delete-button" type="button" data-action="delete">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </section>

    </div>
  </div>

  <!-- VIEW REVIEW 1 -->
  <section id="view-1" class="popover" popover aria-labelledby="view-1-title">
    <div class="popover-top">
      <h2 id="view-1-title">Review #1</h2>
      <button class="icon-btn" popovertarget="view-1" popovertargetaction="hide" aria-label="Close window">×</button>
    </div>

    <div class="summary-row"><span>Product</span><span>Monstera</span></div>
    <div class="summary-row"><span>Customer</span><span>Mohammad Ahmad</span></div>
    <div class="summary-row"><span>Rating</span><span class="rating">★★★★★</span></div>
    <div class="summary-row"><span>From order</span><span>#1</span></div>
    <div class="summary-row"><span>Review</span><span>Excellent product, arrived in good condition</span></div>
  </section>

  <!-- VIEW REVIEW 2 -->
  <section id="view-2" class="popover" popover aria-labelledby="view-2-title">
    <div class="popover-top">
      <h2 id="view-2-title">Review #2</h2>
      <button class="icon-btn" popovertarget="view-2" popovertargetaction="hide" aria-label="Close window">×</button>
    </div>

    <div class="summary-row"><span>Product</span><span>Peace Lily</span></div>
    <div class="summary-row"><span>Customer</span><span>Sara Khaled</span></div>
    <div class="summary-row"><span>Rating</span><span class="rating">★★★★☆</span></div>
    <div class="summary-row"><span>From order</span><span>#2</span></div>
    <div class="summary-row"><span>Review</span><span>Beautiful plant and easy to care for</span></div>
  </section>

  <!-- VIEW REVIEW 3 -->
  <section id="view-6" class="popover" popover aria-labelledby="view-6-title">
    <div class="popover-top">
      <h2 id="view-6-title">Review #6</h2>
      <button class="icon-btn" popovertarget="view-6" popovertargetaction="hide" aria-label="Close window">×</button>
    </div>

    <div class="summary-row"><span>Collection</span><span>Organic Care Collection</span></div>
    <div class="summary-row"><span>Customer</span><span>Yasmin Samir</span></div>
    <div class="summary-row"><span>Rating</span><span class="rating">★★★★☆</span></div>
    <div class="summary-row"><span>From order</span><span>#6</span></div>
    <div class="summary-row"><span>Review</span><span>Useful collection at a good price</span></div>
  </section>

</main>

<script>
  const reviewsTable = document.getElementById("reviews-table");
  const recordCount = document.getElementById("record-count");

  function updateCount() {
    const count = reviewsTable.querySelectorAll("tr").length;
    recordCount.textContent = `${count} records`;
  }

  reviewsTable.addEventListener("click", function (event) {
    const button = event.target.closest("button[data-action]");

    if (!button) return;

    const row = button.closest("tr");
    const action = button.dataset.action;

    if (action === "delete") {
      const confirmed = confirm("Are you sure you want to delete this review?");

      if (confirmed) {
        row.remove();
        updateCount();
      }
    }

    if (action === "hide") {
      const isHidden = row.classList.toggle("review-hidden");
      const hiddenLabel = row.querySelector(".hidden-label");

      hiddenLabel.hidden = !isHidden;
      button.textContent = isHidden ? "Unhide" : "Hide";
    }
  });
</script>

</body>
</html>
