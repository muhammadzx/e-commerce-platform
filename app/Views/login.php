<?php require __DIR__ . '/layouts/auth-layout-top.php'; ?>
    <section class="auth-card" aria-labelledby="auth-title">
      <a class="auth-back" href="index.php"><span aria-hidden="true">←</span> Back to Nabta</a>
      <h2 id="auth-title">Welcome back.</h2>
      <p class="auth-subtitle">Sign in to pick up where your growing journey left off.</p>

      <?php if (!empty($_SESSION['auth_notice'])): ?>
        <div class="auth-message" role="status"><?= e($_SESSION['auth_notice']) ?></div>
        <?php unset($_SESSION['auth_notice']); ?>
      <?php endif; ?>
      <?php if ($error !== ''): ?>
        <div class="auth-message error" role="alert"><?= e($error) ?></div>
      <?php endif; ?>

      <form class="auth-form" method="post" action="login.php" autocomplete="on">
        <?= csrf_field() ?>
        <label for="login-email">Email address
          <input id="login-email" type="email" name="email" autocomplete="email" inputmode="email" placeholder="you@example.com" value="<?= e($_POST['email'] ?? '') ?>" maxlength="150" required>
        </label>
        <label for="login-password">Password
          <span class="auth-input-wrap">
            <input id="login-password" type="password" name="password" autocomplete="current-password" placeholder="Enter your password" required>
            <button class="password-toggle" type="button" data-password-toggle="login-password" aria-label="Show password">Show</button>
          </span>
        </label>
        <button class="btn btn-primary auth-submit" type="submit">Sign in <span aria-hidden="true">↗</span></button>
      </form>
      <p class="auth-switch">New to Nabta? <a href="register.php">Create an account</a></p>
      <p class="auth-inline-note">For your privacy, we won’t tell you whether an email or password was incorrect.</p>
    </section>
<?php require __DIR__ . '/layouts/auth-layout-bottom.php'; ?>
