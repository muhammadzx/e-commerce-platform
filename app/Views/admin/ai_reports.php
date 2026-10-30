<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Reports | NABTA Botanical</title>
    <meta name="description" content="Create and review store reports for NABTA Botanical.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">

    <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/php/e-commerce%20platform/public/assets/css/shared.css">
    <link rel="stylesheet" href="/php/e-commerce%20platform/public/assets/css/style.css">
    <link rel="stylesheet" href="/php/e-commerce%20platform/public/assets/css/canopy.css">

    <style>
        .admin-content .report-form-background {
            background:
                linear-gradient(115deg, rgba(12, 28, 18, .91), rgba(16, 38, 24, .78) 55%, rgba(12, 27, 18, .88)),
                url("/php/e-commerce%20platform/public/assets/img/editorial.jpg") center 48% / cover no-repeat !important;
            color: #edf3e7;
        }

        .admin-content .report-form-background h3 {
            color: #edf3e7 !important;
        }

        .admin-content .report-form-background p,
        .admin-content .report-form-background .small {
            color: #c2d0bc !important;
        }
    </style>
</head>

<body class="admin-body botanical-edition workspace-page admin-overview admin-reports">
    <main id="main">
        <div class="admin-shell">

            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>

            <div class="admin-content">
                <div class="admin-top">
                    <span>Workspace / AI Reports</span>
                    <div class="flex">
                        <span>NABTA Botanical</span>
                        <span class="pill">Report studio</span>
                    </div>
                </div>

                <div class="admin-photo-strip" role="img" aria-label="Botanical greenhouse">
                    <span>
                        STORE INTELLIGENCE / REPORT STUDIO
                        <small>GROWTH · SALES · CUSTOMER DEMAND</small>
                    </span>
                </div>

                <section class="desk-intro" aria-labelledby="reports-title">
                    <div>
                        <div class="season-mark">STORE INTELLIGENCE · REPORT STUDIO</div>
                        <h1 id="reports-title">AI Reports</h1>
                        <p>Choose a period and request an analysis of your store data.</p>
                    </div>

                    <div class="overview-intro-actions">
                        <span class="desk-date">PRIVATE ADMIN WORKSPACE</span>
                    </div>
                </section>

                <section class="overview-section" aria-labelledby="create-report-title">
                    <div class="overview-section-heading">
                        <div>
                            <div class="eyebrow">NEW ANALYSIS</div>
                            <h2 id="create-report-title">Create a store report</h2>
                        </div>
                    </div>

                    <section class="panel report-form-background">
                        <h3>Report details</h3>
                        <p class="small">Select the dates and describe what you want the report to focus on.</p>

                        <form action="#" method="post">
                            <div class="form-grid">
                                <div class="field">
                                    <label for="date-from">Start date</label>
                                    <input class="control" id="date-from" name="date_from" type="date" required>
                                </div>

                                <div class="field">
                                    <label for="date-to">End date</label>
                                    <input class="control" id="date-to" name="date_to" type="date" required>
                                </div>
                            </div>

                            <div class="field">
                                <label for="request-prompt">What should the report analyze?</label>
                                <textarea class="control" id="request-prompt" name="request_prompt" rows="5"
                                    placeholder="For example: Compare product and collection sales, summarize order trends, and identify products that may need restocking."
                                    required></textarea>
                                <small class="small">Describe the questions you want the report to answer.</small>
                            </div>

                            <button class="btn" type="submit">
                                Generate report
                                <span aria-hidden="true">↗</span>
                            </button>
                        </form>
                    </section>
                </section>

                <section class="overview-section" aria-labelledby="history-title">
                    <div class="overview-section-heading">
                        <div>
                            <div class="eyebrow">SAVED ANALYSES</div>
                            <h2 id="history-title">Report history</h2>
                        </div>
                        <span class="pill">0 reports</span>
                    </div>

                    <section class="panel">
                        <div class="table-scroll">
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Report title</th>
                                        <th scope="col">Generated</th>
                                        <th scope="col">Reporting period</th>
                                        <th scope="col">Requested by</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="5" style="text-align:center; padding:32px 16px;">
                                            <strong>No reports yet</strong>
                                            <p class="small" style="margin-top:6px;">
                                                Reports you generate will appear here.
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>

                <div class="dashboard-footer-note">
                    Reports are based on the store data available for the selected period.
                </div>
            </div>
        </div>
    </main>
</body>

</html>