<?php
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
require_once __DIR__ . '/../../../config/paths.php';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />

  <title>Reviews | Nabta Botanical</title>
  <meta name="description" content="Read customer reviews — plants and growing essentials at Nabta." />
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#c5d4b4" />

  <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">

  <style>
    .review-hidden {
      opacity: 0.55;
    }

    .hidden-label {
      margin-left: 8px;
      font-size: 13px;
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
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>

<body class="admin-body botanical-edition workspace-page admin-reviews">

<main id="main">
  <div class="admin-shell">

    <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>

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

        <form class="toolbar admin-search" method="get" action="<?= htmlspecialchars(nabta_public_url('admin/reviews.php'), ENT_QUOTES, 'UTF-8') ?>">
          <label class="sr-only" for="search-records">Search reviews</label>

          <input
            class="control"
            id="search-records"
            name="q"
            type="search"
            placeholder="Search by item, customer or text"
          >

          <select class="control" id="rating-filter" name="rating" aria-label="Filter by rating">
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
                  <span class="pill">Package</span>
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

    <div class="summary-row"><span>Package</span><span>Organic Care Collection</span></div>
    <div class="summary-row"><span>Customer</span><span>Yasmin Samir</span></div>
    <div class="summary-row"><span>Rating</span><span class="rating">★★★★☆</span></div>
    <div class="summary-row"><span>From order</span><span>#6</span></div>
    <div class="summary-row"><span>Review</span><span>Useful collection at a good price</span></div>
  </section>

</main>

<script>
  const reviewsTable = document.getElementById("reviews-table");
  const recordCount = document.getElementById("record-count");

  const searchForm = document.querySelector('.admin-search');
  const searchInput = document.getElementById('search-records');
  const ratingFilter = document.getElementById('rating-filter');

  function updateCount() {
    const visibleRows = [...reviewsTable.querySelectorAll('tr')].filter((row) => !row.hidden).length;
    recordCount.textContent = `${visibleRows} record${visibleRows === 1 ? '' : 's'}`;
  }

  function filterReviews() {
    const term = searchInput.value.trim().toLocaleLowerCase();
    const rating = ratingFilter.value;
    reviewsTable.querySelectorAll('tr').forEach((row) => {
      const textMatches = row.textContent.toLocaleLowerCase().includes(term);
      const stars = row.querySelector('.rating')?.textContent.trim().match(/★/g)?.length ?? 0;
      row.hidden = !textMatches || (rating !== '' && stars !== Number(rating));
    });
    updateCount();
  }

  searchForm.addEventListener('submit', (event) => { event.preventDefault(); filterReviews(); });
  searchInput.addEventListener('input', filterReviews);
  ratingFilter.addEventListener('change', filterReviews);

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
