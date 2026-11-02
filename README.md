# Nabta Botanical

Nabta Botanical is a PHP e-commerce website for plants, pots, seeds, gardening tools and plant-care products. It combines a customer storefront, an admin workspace, curated product packages and AI-generated sales reports.

**Current checkout scope:** checkout creates a pending request for order confirmation. It does not collect payment. Delivery fees, payment arrangements and availability require later approval.

## Features

### Customer storefront

- Botanical home page with promotional slides and links to the shop and packages.
- Product search, category filters, sorting and pagination.
- Product pages with image galleries, price, stock information and customer reviews.
- Wishlist, registration, sign-in and account/profile pages.
- Packages with component quantities, a shared discount and stock-based availability.
- Three-product package previews with full details in a popup when more products are included.
- Basket quantity changes and removal controls. The first three product types appear on the page; **See more** opens all items in a popup.
- Compact checkout with delivery fields, selected products, totals and a review step before sending a confirmation request.
- About, store information and account-access assistance pages.

### Admin workspace

- Role-restricted dashboard with statistics and charts.
- Product management, images, categories and stock visibility.
- Product filters for search, category, stock and price, plus sorting.
- Package creation/editing, component selection, quantities, discounts and visibility controls.
- Package removal hides the package while preserving historical records.
- Customer, order, message and review management, including hidden/published reviews.
- A shared page header with a welcome message and an admin-only floating AI Reports shortcut.

### AI reports

Admins describe the analysis they want. The server calculates summaries from completed orders and purchased line-item prices, then sends the reporting data and request to Gemini.

The name is optional. An empty name becomes `Store report: YYYY-MM-DD to YYYY-MM-DD` using the resolved period.

| Date selection | Reporting period |
| --- | --- |
| Neither date | One calendar month before today through today; clamp the day if the previous month is shorter |
| Start date only | Selected start through today |
| End date only | Earliest recorded completed-order date through the selected end |
| Both dates | Selected inclusive date range |

Dates use `Asia/Amman`. Invalid dates, future dates and reversed ranges are rejected. If no sales exist on or before an end-only date, that period contains no sales.

Completed reports appear in the requesting admin's history and support PDF export. HTTP/connection errors, malformed responses, blocked or incomplete generations and empty content are rejected before saving. A final model-level check also rejects empty/error content. Administrators should still review generated analysis; validating a response does not establish the factual quality of its prose.

## Technology

| Layer | Technology |
| --- | --- |
| Interface | HTML, CSS and JavaScript |
| Application | PHP controllers, models and views |
| Database | MySQL/MariaDB through PDO |
| Hosted product images | Cloudinary |
| AI analysis | Gemini API |
| Markdown and PDF | League CommonMark and Dompdf |
| Local development | Apache and MySQL through XAMPP |

Application controls include password hashing, session handling, role checks, CSRF validation and server-side input validation. Product uploads accept JPG, PNG and WebP files up to 5 MB. Unavailable gallery thumbnails are hidden and the displayed count is recalculated.

## Local setup

### Requirements

- Apache with PHP; PHP 8.1 or later is recommended. Check installed Composer dependencies against your PHP version.
- MySQL or MariaDB, and Composer for installing dependencies.
- PHP extensions used by the application/dependencies, including `pdo_mysql`, `curl`, `mbstring`, `fileinfo`, `dom` and `gd`.
- Internet access for Cloudinary and Gemini.

### 1. Start the local server

The current project location is `C:\xampp\htdocs\php\e-commerce platform`. Start Apache and MySQL in the XAMPP control panel.

### 2. Install dependencies

From the project directory:

```powershell
composer install
```

The application loads dependencies from `vendor/autoload.php`.

### 3. Configure the database

Set the host, database name, username and password in `config/database.php`. The database approved for this workspace is **`nabta_store`**. `config/connection.php` uses `app/Core/Database.php` to open a PDO connection with `utf8mb4`.

A complete base-schema SQL export is not included in this repository. A fresh installation needs an authorized database backup/schema from the project owner; creating an empty database is insufficient.

After installing the base schema and checking the database configuration, this incremental migration adds the review visibility field if missing:

```powershell
C:\xampp\php\php.exe migrations\20261102_review_visibility.php
```

### 4. Configure integrations

| File | Configuration |
| --- | --- |
| `config/cloudinary.php` | Cloud name, API key and API secret used by the upload helper |
| `config/gemini.php` | Returns the Gemini API key as a string |
| `config/paths.php` | Public-path and image URL helpers |

Use your own credentials. Do not include API secrets, database passwords or account passwords in shared documentation. The current code reads these PHP files directly; it does not automatically load a `.env` file.

### 5. Open the website

With the current XAMPP folder layout:

- [Storefront](http://localhost/php/e-commerce%20platform/public/index.php)
- [Sign in](http://localhost/php/e-commerce%20platform/public/login.php)
- [Admin overview](http://localhost/php/e-commerce%20platform/public/admin/dashboard.php)
- [AI Reports](http://localhost/php/e-commerce%20platform/public/admin/ai_reports.php)

Use an existing authorized, active admin account for admin pages. Public registration creates a customer account. No default admin credentials are supplied here.

For a dedicated virtual host, use `public/` as the document root so configuration and dependencies remain outside the public document root. Adjust the URL for that deployment.

## Project structure

```text
app/
  Controllers/       Request handling and workflows
  Core/              Database, security, admin access and integration helpers
  Models/            Catalog, basket, orders and reporting data access
  Views/             Storefront, admin pages and shared layouts
config/              Database, integrations and path configuration
migrations/          Incremental database changes
public/
  admin/             Admin entry points
  assets/css/        Styles
  assets/js/         Interface behavior
  assets/img/        Local images
  index.php          Storefront entry point and API dispatch
routes.php           API route handling
composer.json        PHP dependencies
```

The interface calls bundled product groups **Packages**. Internal routes, model names and database tables retain the `collection`/`collections` terminology.

## Verification and troubleshooting

For a demo, check product search/filtering, galleries, package details, basket quantities/removal and checkout review. Use an authorized admin to check the dashboard, management screens and four AI date cases. Review phone and desktop layouts. A successful AI generation uses an external API and may incur usage charges; failed generations should not add history records.

| Symptom | Action |
| --- | --- |
| Database connection fails | Check MySQL, credentials and the `nabta_store` schema |
| Product image missing | Check its Cloudinary URL. A 404 means that stored URL is unavailable; replace or remove the image through product management |
| Gemini HTTP 503 | Retry later; the external service is temporarily unavailable |
| Upload fails | Check file type/size, PHP upload limits, network access and Cloudinary configuration |
| Admin access denied | Use an active admin account |
| Old styles remain visible | Refresh the browser and check asset caching |

## Current commercial scope

Before a full commercial launch, finalize delivery rates, payment arrangements, support contact details and store policies. Account-access assistance collects requests; it does not itself prove ownership, send a password-reset email or reset credentials. Automated payment processing is not implemented by the current confirmation-request checkout. Keep these limits clear when demonstrating the site.
