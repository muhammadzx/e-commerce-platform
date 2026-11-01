<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/Views/bootstrap.php';
require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../app/Models/User.php';
require_once __DIR__ . '/../app/Models/ContactMessage.php';
$error = ''; $sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) $error = 'Your session expired. Refresh and try again.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) $error = 'Enter a valid email address.';
    elseif (time() - (int) ($_SESSION['account_help_at'] ?? 0) < 120) $error = 'Please wait two minutes before submitting another request.';
    else {
        try {
            require __DIR__ . '/../config/connection.php';
            $user = (new User($db))->findByEmail($email);
            if ($user) (new ContactMessage($db))->create((int) $user['user_id'], '[ACCOUNT ACCESS REQUEST] Customer requested assistance signing in. Verify account ownership through an established channel before taking action. Do not disclose or reset credentials based solely on this request.');
            $_SESSION['account_help_at'] = time(); $sent = true;
        } catch (PDOException $exception) { error_log('Account assistance could not be saved: ' . $exception->getMessage()); $error = 'The request could not be saved. Please try again later.'; }
    }
}
$pageTitle = 'Account access assistance';
require __DIR__ . '/../app/Views/layouts/auth-layout-top.php';
?>
<section class="auth-card"><p class="eyebrow">ACCOUNT HELP</p><h1>Need help signing in?</h1><p>Automated password recovery is not configured. You can ask an administrator to review an access request. No email is sent and no password is changed by this form. A response time is not yet specified.</p>
<?php if ($sent): ?><p class="auth-message" role="status">If an account matches this address, an assistance request has been saved for administrator review.</p><?php else: ?>
<?php if ($error): ?><p class="auth-message error" role="alert"><?= e($error) ?></p><?php endif; ?>
<form class="auth-form" method="post"><?= csrf_field() ?><label for="help-email">Account email<input id="help-email" name="email" type="email" autocomplete="email" maxlength="150" value="<?= e($_POST['email'] ?? '') ?>" required></label><button class="btn btn-primary" type="submit">Request assistance</button></form><?php endif; ?><p><a href="login.php">Return to sign in</a> · <a href="index.php?page=information">Store information</a></p></section>
<?php require __DIR__ . '/../app/Views/layouts/auth-layout-bottom.php'; ?>
