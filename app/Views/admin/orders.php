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
    <title>Manage orders | Nabta Botanical</title>
    <meta
      name="description"
      content="Manage orders — plants and growing essentials at Nabta."
    />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="theme-color" content="#c5d4b4" />
    <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
      <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
  <body class="admin-body botanical-edition workspace-page admin-orders">
    <main id="main">
      <div class="admin-shell">
      <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
        <div class="admin-content">
          <div class="admin-top">
            <span>Workspace / Orders</span>
            <div class="flex">
              <span>Nabta Botanical</span><span class="pill">Preview</span>
            </div>
          </div>
          <div
            class="admin-photo-strip"
            role="img"
            aria-label="Soft-focus botanical greenhouse photograph"
          >
            <span
              >CANOPY / BOTANICAL OPERATIONS<small
                >GROWTH · STOCK · CUSTOMER CARE</small
              ></span
            >
          </div>
          <div class="admin-title">
            <div>
              <h1>Orders</h1>
              <p>Track every order from basket to delivery.</p>
            </div>
            <button class="btn" popovertarget="add">+ Add new</button>
          </div>
          <section class="panel">
            <div class="toolbar">
              <label class="sr-only" for="search-records">Search orders</label
              ><input
                class="control"
                id="search-records"
                type="search"
                placeholder="Search orders"
              /><button class="btn secondary" popovertarget="preview">
                Search
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                  <circle cx="10" cy="10" r="6" />
                  <path d="m15 15 5 5" />
                </svg></button
              ><span class="label">3 records</span>
            </div>
            <div class="table-scroll">
              <table>
                <thead>
                  <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td data-label="Order">#1042</td>
                    <td data-label="Customer">Alex Morgan</td>
                    <td data-label="Date">27 Oct 2026</td>
                    <td data-label="Total">42.00 JOD</td>
                    <td data-label="Status">
                      <span class="pill pending">Processing</span>
                    </td>
                    <td data-label="Actions">
                      <div class="table-actions">
                        <button class="table-button" popovertarget="view-0">
                          View</button
                        ><button class="table-button" popovertarget="edit-0">
                          Edit</button
                        ><button class="table-button" popovertarget="delete-0">
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td data-label="Order">#1041</td>
                    <td data-label="Customer">Sam Taylor</td>
                    <td data-label="Date">26 Oct 2026</td>
                    <td data-label="Total">16.00 JOD</td>
                    <td data-label="Status">
                      <span class="pill">Shipped</span>
                    </td>
                    <td data-label="Actions">
                      <div class="table-actions">
                        <button class="table-button" popovertarget="view-1">
                          View</button
                        ><button class="table-button" popovertarget="edit-1">
                          Edit</button
                        ><button class="table-button" popovertarget="delete-1">
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td data-label="Order">#1031</td>
                    <td data-label="Customer">Alex Morgan</td>
                    <td data-label="Date">18 Oct 2026</td>
                    <td data-label="Total">14.00 JOD</td>
                    <td data-label="Status">
                      <span class="pill">Delivered</span>
                    </td>
                    <td data-label="Actions">
                      <div class="table-actions">
                        <button class="table-button" popovertarget="view-2">
                          View</button
                        ><button class="table-button" popovertarget="edit-2">
                          Edit</button
                        ><button class="table-button" popovertarget="delete-2">
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
      <section
        id="view-0"
        class="popover"
        popover
        aria-labelledby="view-0-title"
      >
        <div class="popover-top">
          <h2 id="view-0-title">Orders / Record 1</h2>
          <button
            class="icon-btn"
            popovertarget="view-0"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="summary-row"><span>Order</span><span>#1042</span></div>
        <div class="summary-row">
          <span>Customer</span><span>Alex Morgan</span>
        </div>
        <div class="summary-row"><span>Date</span><span>27 Oct 2026</span></div>
        <div class="summary-row"><span>Total</span><span>42.00 JOD</span></div>
        <div class="summary-row">
          <span>Status</span
          ><span><span class="pill pending">Processing</span></span>
        </div>
      </section>
      <section
        id="edit-0"
        class="popover"
        popover
        aria-labelledby="edit-0-title"
      >
        <div class="popover-top">
          <h2 id="edit-0-title">Edit record</h2>
          <button
            class="icon-btn"
            popovertarget="edit-0"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="field">
          <label for="edit-0-customer">Customer</label
          ><input
            id="edit-0-customer"
            name="edit-0-customer"
            type="text"
            value="Alex Morgan"
          />
        </div>
        <div class="field">
          <label for="edit-0-product">Product</label
          ><select id="edit-0-product" name="edit-0-product">
            <option>The Rubber Plant</option>
            <option>The Stone Planter</option>
            <option>Everyday Potting Mix</option>
            <option>The Garden Duo</option>
            <option>The Desk Garden</option>
            <option>Leaf-care Treatment</option>
          </select>
        </div>
        <div class="form-grid">
          <div class="field">
            <label for="edit-0-qty">Quantity</label
            ><input
              id="edit-0-qty"
              name="edit-0-qty"
              type="number"
              min="1"
              value="1"
            />
          </div>
          <div class="field">
            <label for="edit-0-status">Order status</label
            ><select id="edit-0-status" name="edit-0-status">
              <option>Processing</option>
              <option>Shipped</option>
              <option>Delivered</option>
              <option>Cancelled</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="edit-0-address">Delivery address</label
          ><input
            id="edit-0-address"
            name="edit-0-address"
            type="text"
            value=""
          />
        </div>
        <div class="field">
          <label for="edit-0-note">Order note</label
          ><textarea id="edit-0-note" rows="2"></textarea>
        </div>
        <button class="btn" type="button" popovertarget="preview">
          Save changes
        </button>
      </section>
      <section
        id="delete-0"
        class="popover"
        popover
        aria-labelledby="delete-0-title"
      >
        <div class="popover-top">
          <h2 id="delete-0-title">Delete this record?</h2>
          <button
            class="icon-btn"
            popovertarget="delete-0"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <p>
          Confirm removal of the selected record. No data is deleted in this
          static preview.
        </p>
        <div class="flex" style="margin-top: 18px">
          <button class="btn" type="button" popovertarget="preview">
            Delete record</button
          ><button
            class="btn secondary"
            popovertarget="delete-0"
            popovertargetaction="hide"
          >
            Keep record
          </button>
        </div>
      </section>
      <section
        id="view-1"
        class="popover"
        popover
        aria-labelledby="view-1-title"
      >
        <div class="popover-top">
          <h2 id="view-1-title">Orders / Record 2</h2>
          <button
            class="icon-btn"
            popovertarget="view-1"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="summary-row"><span>Order</span><span>#1041</span></div>
        <div class="summary-row">
          <span>Customer</span><span>Sam Taylor</span>
        </div>
        <div class="summary-row"><span>Date</span><span>26 Oct 2026</span></div>
        <div class="summary-row"><span>Total</span><span>16.00 JOD</span></div>
        <div class="summary-row">
          <span>Status</span><span><span class="pill">Shipped</span></span>
        </div>
      </section>
      <section
        id="edit-1"
        class="popover"
        popover
        aria-labelledby="edit-1-title"
      >
        <div class="popover-top">
          <h2 id="edit-1-title">Edit record</h2>
          <button
            class="icon-btn"
            popovertarget="edit-1"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="field">
          <label for="edit-1-customer">Customer</label
          ><input
            id="edit-1-customer"
            name="edit-1-customer"
            type="text"
            value="Sam Taylor"
          />
        </div>
        <div class="field">
          <label for="edit-1-product">Product</label
          ><select id="edit-1-product" name="edit-1-product">
            <option>The Rubber Plant</option>
            <option>The Stone Planter</option>
            <option>Everyday Potting Mix</option>
            <option>The Garden Duo</option>
            <option>The Desk Garden</option>
            <option>Leaf-care Treatment</option>
          </select>
        </div>
        <div class="form-grid">
          <div class="field">
            <label for="edit-1-qty">Quantity</label
            ><input
              id="edit-1-qty"
              name="edit-1-qty"
              type="number"
              min="1"
              value="1"
            />
          </div>
          <div class="field">
            <label for="edit-1-status">Order status</label
            ><select id="edit-1-status" name="edit-1-status">
              <option>Processing</option>
              <option>Shipped</option>
              <option>Delivered</option>
              <option>Cancelled</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="edit-1-address">Delivery address</label
          ><input
            id="edit-1-address"
            name="edit-1-address"
            type="text"
            value=""
          />
        </div>
        <div class="field">
          <label for="edit-1-note">Order note</label
          ><textarea id="edit-1-note" rows="2"></textarea>
        </div>
        <button class="btn" type="button" popovertarget="preview">
          Save changes
        </button>
      </section>
      <section
        id="delete-1"
        class="popover"
        popover
        aria-labelledby="delete-1-title"
      >
        <div class="popover-top">
          <h2 id="delete-1-title">Delete this record?</h2>
          <button
            class="icon-btn"
            popovertarget="delete-1"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <p>
          Confirm removal of the selected record. No data is deleted in this
          static preview.
        </p>
        <div class="flex" style="margin-top: 18px">
          <button class="btn" type="button" popovertarget="preview">
            Delete record</button
          ><button
            class="btn secondary"
            popovertarget="delete-1"
            popovertargetaction="hide"
          >
            Keep record
          </button>
        </div>
      </section>
      <section
        id="view-2"
        class="popover"
        popover
        aria-labelledby="view-2-title"
      >
        <div class="popover-top">
          <h2 id="view-2-title">Orders / Record 3</h2>
          <button
            class="icon-btn"
            popovertarget="view-2"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="summary-row"><span>Order</span><span>#1031</span></div>
        <div class="summary-row">
          <span>Customer</span><span>Alex Morgan</span>
        </div>
        <div class="summary-row"><span>Date</span><span>18 Oct 2026</span></div>
        <div class="summary-row"><span>Total</span><span>14.00 JOD</span></div>
        <div class="summary-row">
          <span>Status</span><span><span class="pill">Delivered</span></span>
        </div>
      </section>
      <section
        id="edit-2"
        class="popover"
        popover
        aria-labelledby="edit-2-title"
      >
        <div class="popover-top">
          <h2 id="edit-2-title">Edit record</h2>
          <button
            class="icon-btn"
            popovertarget="edit-2"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="field">
          <label for="edit-2-customer">Customer</label
          ><input
            id="edit-2-customer"
            name="edit-2-customer"
            type="text"
            value="Alex Morgan"
          />
        </div>
        <div class="field">
          <label for="edit-2-product">Product</label
          ><select id="edit-2-product" name="edit-2-product">
            <option>The Rubber Plant</option>
            <option>The Stone Planter</option>
            <option>Everyday Potting Mix</option>
            <option>The Garden Duo</option>
            <option>The Desk Garden</option>
            <option>Leaf-care Treatment</option>
          </select>
        </div>
        <div class="form-grid">
          <div class="field">
            <label for="edit-2-qty">Quantity</label
            ><input
              id="edit-2-qty"
              name="edit-2-qty"
              type="number"
              min="1"
              value="1"
            />
          </div>
          <div class="field">
            <label for="edit-2-status">Order status</label
            ><select id="edit-2-status" name="edit-2-status">
              <option>Processing</option>
              <option>Shipped</option>
              <option>Delivered</option>
              <option>Cancelled</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="edit-2-address">Delivery address</label
          ><input
            id="edit-2-address"
            name="edit-2-address"
            type="text"
            value=""
          />
        </div>
        <div class="field">
          <label for="edit-2-note">Order note</label
          ><textarea id="edit-2-note" rows="2"></textarea>
        </div>
        <button class="btn" type="button" popovertarget="preview">
          Save changes
        </button>
      </section>
      <section
        id="delete-2"
        class="popover"
        popover
        aria-labelledby="delete-2-title"
      >
        <div class="popover-top">
          <h2 id="delete-2-title">Delete this record?</h2>
          <button
            class="icon-btn"
            popovertarget="delete-2"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <p>
          Confirm removal of the selected record. No data is deleted in this
          static preview.
        </p>
        <div class="flex" style="margin-top: 18px">
          <button class="btn" type="button" popovertarget="preview">
            Delete record</button
          ><button
            class="btn secondary"
            popovertarget="delete-2"
            popovertargetaction="hide"
          >
            Keep record
          </button>
        </div>
      </section>
      <section id="add" class="popover" popover aria-labelledby="add-title">
        <div class="popover-top">
          <h2 id="add-title">Create a record</h2>
          <button
            class="icon-btn"
            popovertarget="add"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <div class="field">
          <label for="new-customer">Customer</label
          ><input id="new-customer" name="new-customer" type="text" value="" />
        </div>
        <div class="field">
          <label for="new-product">Product</label
          ><select id="new-product" name="new-product">
            <option>The Rubber Plant</option>
            <option>The Stone Planter</option>
            <option>Everyday Potting Mix</option>
            <option>The Garden Duo</option>
            <option>The Desk Garden</option>
            <option>Leaf-care Treatment</option>
          </select>
        </div>
        <div class="form-grid">
          <div class="field">
            <label for="new-qty">Quantity</label
            ><input
              id="new-qty"
              name="new-qty"
              type="number"
              min="1"
              value="1"
            />
          </div>
          <div class="field">
            <label for="new-status">Order status</label
            ><select id="new-status" name="new-status">
              <option>Processing</option>
              <option>Shipped</option>
              <option>Delivered</option>
              <option>Cancelled</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label for="new-address">Delivery address</label
          ><input id="new-address" name="new-address" type="text" value="" />
        </div>
        <div class="field">
          <label for="new-note">Order note</label
          ><textarea id="new-note" rows="2"></textarea>
        </div>
        <button class="btn" type="button" popovertarget="preview">
          Create record
        </button>
      </section>
      <section
        id="preview"
        class="popover"
        popover
        aria-labelledby="preview-title"
      >
        <div class="popover-top">
          <h2 id="preview-title">Ready for the next step.</h2>
          <button
            class="icon-btn"
            popovertarget="preview"
            popovertargetaction="hide"
            aria-label="Close window"
          >
            ×
          </button>
        </div>
        <p>
          This action is part of the HTML &amp; CSS preview. Saving, accounts,
          and transactions will be connected to PHP later. No information has
          been submitted.
        </p>
        <button class="btn" popovertarget="preview" popovertargetaction="hide">
          Got it
        </button>
      </section>
    </main>
  </body>
</html>
