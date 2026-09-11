<nav class="top-strip py-2 small">
  <div class="container d-flex justify-content-between">
    <div><i class="fa-solid fa-phone me-2"></i>+252 61 0000000 <span class="mx-3">|</span> <i class="fa-solid fa-envelope me-2"></i>info@hawlsomali.com</div>
    <div><a href="<?= BASE_URL ?>/pages/contact.php" class="text-white text-decoration-none">Contact</a></div>
  </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light sticky-top site-nav">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">HawlSomali<span class="text-success">.com</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?= nav_active('/index.php') ?>" href="<?= BASE_URL ?>/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('/pages/jobs.php') ?>" href="<?= BASE_URL ?>/pages/jobs.php">Jobs</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('/pages/companies.php') ?>" href="<?= BASE_URL ?>/pages/companies.php">Companies</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('/pages/about.php') ?>" href="<?= BASE_URL ?>/pages/about.php">About</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('/pages/contact.php') ?>" href="<?= BASE_URL ?>/pages/contact.php">Contact</a></li>
      </ul>
      <div class="d-flex gap-2">
        <?php if (is_logged_in()): ?>
            <?php if (current_user_role() === 'admin'): ?>
                <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>/admin/dashboard.php">Dashboard</a>
            <?php elseif (current_user_role() === 'employer'): ?>
                <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
            <?php else: ?>
                <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>/seeker/dashboard.php">Dashboard</a>
            <?php endif; ?>
            <a class="btn btn-success btn-sm" href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
        <?php else: ?>
            <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>/auth/login.php">Login</a>
            <a class="btn btn-success btn-sm" href="<?= BASE_URL ?>/auth/register-employer.php">Post a Job</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<?php if ($msg = flash('success')): ?><div class="container mt-3"><div class="alert alert-success"><?= e($msg) ?></div></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="container mt-3"><div class="alert alert-danger"><?= e($msg) ?></div></div><?php endif; ?>
