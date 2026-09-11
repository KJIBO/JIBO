<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('seeker');
$seekerId=$_SESSION['user_id'];
$stats=[
 'applied'=> (int)$pdo->query("SELECT COUNT(*) FROM applications WHERE seeker_id={$seekerId}")->fetchColumn(),
 'saved'=> (int)$pdo->query("SELECT COUNT(*) FROM saved_jobs WHERE seeker_id={$seekerId}")->fetchColumn(),
 'pending'=> (int)$pdo->query("SELECT COUNT(*) FROM applications WHERE seeker_id={$seekerId} AND status='pending'")->fetchColumn(),
 'accepted'=> (int)$pdo->query("SELECT COUNT(*) FROM applications WHERE seeker_id={$seekerId} AND status='accepted'")->fetchColumn(),
];
$apps=$pdo->query("SELECT a.*, j.title, e.company_name FROM applications a JOIN jobs j ON a.job_id=j.id JOIN employers e ON j.employer_id=e.id WHERE a.seeker_id={$seekerId} ORDER BY a.id DESC LIMIT 8")->fetchAll();
$pageTitle='Seeker Dashboard'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Job Seeker Panel</h4>
  <a class="active" href="<?= BASE_URL ?>/seeker/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/seeker/my-applications.php">My Applications</a>
  <a href="<?= BASE_URL ?>/seeker/saved-jobs.php">Saved Jobs</a>
  <a href="<?= BASE_URL ?>/seeker/profile.php">My Profile</a>
  <a href="<?= BASE_URL ?>/pages/jobs.php">Browse Jobs</a>
  <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
 </div>
 <div class="dashboard-main">
  <h2 class="section-title mb-4">Welcome, <?= e($_SESSION['user_name']) ?></h2>
  <div class="row g-4 mb-4"><?php foreach($stats as $label=>$value): ?><div class="col-md-3"><div class="metric-card p-4"><h3><?= $value ?></h3><p class="mb-0 text-capitalize"><?= str_replace('_',' ',$label) ?></p></div></div><?php endforeach; ?></div>
  <div class="table-card">
    <h5 class="mb-3">Recent Applications</h5>
    <div class="table-responsive">
      <table class="table align-middle">
        <thead><tr><th>Job</th><th>Company</th><th>Status</th><th>Date</th></tr></thead>
        <tbody><?php foreach($apps as $a): ?><tr><td><?= e($a['title']) ?></td><td><?= e($a['company_name']) ?></td><td><?= app_status_badge($a['status']) ?></td><td><?= e($a['applied_at']) ?></td></tr><?php endforeach; ?></tbody>
      </table>
    </div>
  </div>
 </div>
</div>
