<?php if (is_authenticated() && ($_SESSION['role'] ?? '') === 'admin' && empty($GLOBALS['report_shortcut_rendered'])):
$GLOBALS['report_shortcut_rendered'] = true;
?>
<a id="admin-report-shortcut" href="<?= htmlspecialchars(nabta_public_url('admin/ai_reports.php'), ENT_QUOTES, 'UTF-8') ?>" aria-label="Open AI reports" title="AI Reports">
  <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 3h9l4 4v14H6zM14 3v5h5M9 16v2m3-5v5m3-8v8"/></svg>
  <span>AI Reports</span>
</a>
<?php endif; ?>
