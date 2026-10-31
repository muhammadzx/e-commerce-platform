<?php
require_once __DIR__ . '/../../../config/paths.php';
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
if (!isset($reportHistory)) {
    header('Location: ' . nabta_public_url('admin/ai_reports.php'));
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Reports | NABTA Botanical</title>
    <meta name="description" content="Create and review store reports for NABTA Botanical.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">

    <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/admin.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/ai-reports.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/popups.css'), ENT_QUOTES, 'UTF-8') ?>">
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

                <section class="admin-photo-strip reports-hero" aria-labelledby="reports-title">
                    <div class="reports-hero-copy">
                        <div class="reports-hero-kicker">STORE INTELLIGENCE · REPORT STUDIO</div>
                        <h1 id="reports-title">AI Reports</h1>
                        <p>Choose a period and request an analysis of your store data.</p>
                    </div>
                    <span class="desk-date reports-workspace-tag">PRIVATE ADMIN WORKSPACE</span>
                </section>

                <section class="overview-section reports-create" aria-labelledby="create-report-title">
                    <div class="overview-section-heading">
                        <div>
                            <div class="eyebrow">NEW ANALYSIS</div>
                            <h2 id="create-report-title">Create a store report</h2>
                        </div>
                    </div>

                    <section class="panel report-form-background">
                        <h3>Report details</h3>

                        <?php if (!empty($message)): ?>
                            <?php
                            $messageTone = 'info';
                            if (preg_match('/error|invalid|failed|fail|cannot|must be|please fill|please enter/i', (string) $message)) {
                                $messageTone = 'error';
                            } elseif (preg_match('/success|saved|generated|is valid/i', (string) $message)) {
                                $messageTone = 'success';
                            }
                            ?>
                            <div class="report-message report-message--<?= $messageTone ?>"
                                role="<?= $messageTone === 'error' ? 'alert' : 'status' ?>">
                                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                            </div>
                        <?php endif; ?>

                        <p class="small">Select the dates and describe what you want the report to focus on.</p>

                        <form class="report-generation-form" method="POST"
                            action="<?= htmlspecialchars(nabta_public_url('admin/ai_reports.php'), ENT_QUOTES, 'UTF-8') ?>">
                            <div class="field">
                                <label for="report-title">Report name</label>
                                <input class="control" id="report-title" name="report_title" type="text" maxlength="150"
                                    value="<?= htmlspecialchars($reportTitle ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    placeholder="For example: October sales analysis" required>
                            </div>

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

                            <div class="report-form-actions">
                                <button class="btn" type="submit">
                                    Generate report
                                    <span aria-hidden="true">↗</span>
                                </button>

                                <?php if (!empty($reportContent) && !empty($reportId)): ?>
                                    <a class="btn report-download-button"
                                        href="<?= htmlspecialchars(nabta_public_url('admin/download-report.php') . '?id=' . (int) $reportId, ENT_QUOTES, 'UTF-8') ?>">
                                        Download PDF
                                        <span aria-hidden="true">↓</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>

                        <?php if (!empty($reportContent)): ?>
                            <?php $isLongReport = strlen(strip_tags($reportHtml)) > 2200; ?>

                            <section class="report-result" aria-labelledby="generated-report-title">
                                <div class="report-result-title">
                                    <div class="eyebrow">GENERATED REPORT</div>
                                    <h2 id="generated-report-title">
                                        <?= htmlspecialchars($reportTitle ?? 'Store report', ENT_QUOTES, 'UTF-8') ?>
                                    </h2>
                                </div>

                                <section class="panel ai-report-panel" aria-label="Generated report content">
                                    <?php if ($isLongReport): ?>
                                        <div class="ai-report-collapse">
                                            <input class="ai-report-toggle" type="checkbox" id="ai-report-toggle">

                                            <div class="ai-report-content">
                                                <?= $reportHtml ?>
                                            </div>

                                            <label class="ai-report-toggle-label" for="ai-report-toggle">
                                                <span class="show-more">Show full report ↓</span>
                                                <span class="show-less">Show less ↑</span>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <div class="ai-report-content">
                                            <?= $reportHtml ?>
                                        </div>
                                    <?php endif; ?>
                                </section>
                            </section>
                        <?php endif; ?>
                    </section>
                </section>

                <section class="overview-section reports-history" aria-labelledby="history-title">
                    <div class="overview-section-heading">
                        <div>
                            <div class="eyebrow">SAVED ANALYSES</div>
                            <h2 id="history-title">Report history</h2>
                        </div>
                        <span class="pill"><?= count($reportHistory) ?> reports</span>
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
                                    <?php if (!empty($reportHistory)): ?>
                                        <?php foreach ($reportHistory as $report): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($report['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($report['generated_at'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>
                                                    <?= htmlspecialchars($report['date_from'], ENT_QUOTES, 'UTF-8') ?>
                                                    to
                                                    <?= htmlspecialchars($report['date_to'], ENT_QUOTES, 'UTF-8') ?>
                                                </td>
                                                <td>Store admin</td>
                                                <td>
                                                    <a class="table-button"
                                                        href="<?= htmlspecialchars(nabta_public_url('admin/download-report.php') . '?id=' . (int) $report['report_id'], ENT_QUOTES, 'UTF-8') ?>">
                                                        Download PDF
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="report-empty-state">
                                                <strong>No reports yet</strong>
                                                <p class="small">Reports you generate will appear here.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
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
