<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('seeker');
$seekerId=$_SESSION['user_id'];
$apps=$pdo->query("SELECT a.*, j.title, e.company_name, l.name location_name FROM applications a JOIN jobs j ON a.job_id=j.id JOIN employers e ON j.employer_id=e.id JOIN locations l ON j.location_id=l.id WHERE a.seeker_id={$seekerId} ORDER BY a.id DESC")->fetchAll();
$pageTitle='My Applications'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Job Seeker Panel</h4>
  <a href="<?= BASE_URL ?>/seeker/dashboard.php">Dashboard</a>
  <a class="active" href="<?= BASE_URL ?>/seeker/my-applications.php">My Applications</a>
  <a href="<?= BASE_URL ?>/seeker/saved-jobs.php">Saved Jobs</a>
  <a href="<?= BASE_URL ?>/seeker/profile.php">My Profile</a>
  <a href="<?= BASE_URL ?>/pages/jobs.php">Browse Jobs</a>
 </div>
 <div class="dashboard-main">
   <div class="table-card">
    <h2 class="section-title mb-4">My Applications</h2>
    <div class="table-responsive">
      <table class="table align-middle">
       <thead><tr><th>Job</th><th>Company</th><th>Location</th><th>Status</th><th>Applied At</th></tr></thead>
       <tbody><?php foreach($apps as $a): ?><tr><td><?= e($a['title']) ?></td><td><?= e($a['company_name']) ?></td><td><?= e($a['location_name']) ?></td><td><?= app_status_badge($a['status']) ?></td><td><?= e($a['applied_at']) ?></td></tr><?php endforeach; ?></tbody>
      </table>
    </div>
   </div>
 </div>
</div>
