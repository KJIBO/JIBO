<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('employer');
$employerId = $_SESSION['user_id'];
$pageTitle='Employer Dashboard';
$stats = [
 'jobs' => (int)$pdo->query("SELECT COUNT(*) FROM jobs WHERE employer_id={$employerId}")->fetchColumn(),
 'active' => (int)$pdo->query("SELECT COUNT(*) FROM jobs WHERE employer_id={$employerId} AND status='active'")->fetchColumn(),
 'pending_approval' => (int)$pdo->query("SELECT COUNT(*) FROM jobs WHERE employer_id={$employerId} AND is_approved=0")->fetchColumn(),
 'applications' => (int)$pdo->query("SELECT COUNT(*) FROM applications a JOIN jobs j ON a.job_id=j.id WHERE j.employer_id={$employerId}")->fetchColumn()
];
$recentJobs = $pdo->query("SELECT * FROM jobs WHERE employer_id={$employerId} ORDER BY id DESC LIMIT 8")->fetchAll();
include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Employer Panel</h4>
  <a class="<?= nav_active('/employer/dashboard.php') ?>" href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
  <a class="<?= nav_active('/employer/post-job.php') ?>" href="<?= BASE_URL ?>/employer/post-job.php">Post Job</a>
  <a class="<?= nav_active('/employer/manage-jobs.php') ?>" href="<?= BASE_URL ?>/employer/manage-jobs.php">Manage Jobs</a>
  <a class="<?= nav_active('/employer/applicants.php') ?>" href="<?= BASE_URL ?>/employer/applicants.php">Applicants</a>
  <a class="<?= nav_active('/employer/profile.php') ?>" href="<?= BASE_URL ?>/employer/profile.php">Company Profile</a>
  <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
 </div>
 <div class="dashboard-main">
  <h2 class="section-title mb-4">Welcome, <?= e($_SESSION['user_name']) ?></h2>
  <div class="row g-4 mb-4">
   <?php foreach($stats as $label=>$value): ?><div class="col-md-3"><div class="metric-card p-4"><h3><?= $value ?></h3><p class="mb-0 text-capitalize"><?= str_replace('_',' ',$label) ?></p></div></div><?php endforeach; ?>
  </div>
  <div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3"><h5 class="mb-0">Recent Jobs</h5><a href="<?= BASE_URL ?>/employer/post-job.php" class="btn btn-sm btn-primary">New Job</a></div>
    <div class="table-responsive">
      <table class="table align-middle">
        <thead><tr><th>Title</th><th>Status</th><th>Approved</th><th>Deadline</th></tr></thead>
        <tbody>
          <?php foreach($recentJobs as $job): ?>
            <tr><td><?= e($job['title']) ?></td><td><?= app_status_badge($job['status']) ?></td><td><?= $job['is_approved'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning">No</span>' ?></td><td><?= e($job['deadline']) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
 </div>
</div>
