<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('admin');
$pageTitle='Admin Dashboard';
$stats=[
 'jobs'=>count_row($pdo,'jobs'),
 'approved_jobs'=>count_row($pdo,'jobs','is_approved=1'),
 'pending_jobs'=>count_row($pdo,'jobs','is_approved=0'),
 'employers'=>count_row($pdo,'employers'),
 'seekers'=>count_row($pdo,'job_seekers'),
 'applications'=>count_row($pdo,'applications'),
 'messages'=>count_row($pdo,'contact_messages')
];
$recent=$pdo->query("SELECT j.id,j.title,j.status,j.is_approved,e.company_name FROM jobs j JOIN employers e ON j.employer_id=e.id ORDER BY j.id DESC LIMIT 8")->fetchAll();
include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <?php include __DIR__ . '/partials/sidebar.php'; ?>
 <div class="dashboard-main">
  <h2 class="section-title mb-4">Admin Dashboard</h2>
  <div class="row g-4 mb-4">
    <?php foreach($stats as $label=>$value): ?><div class="col-md-3"><div class="metric-card p-4"><h3><?= $value ?></h3><p class="mb-0 text-capitalize"><?= str_replace('_',' ',$label) ?></p></div></div><?php endforeach; ?>
  </div>
  <div class="table-card">
    <h5 class="mb-3">Recent Jobs</h5>
    <div class="table-responsive">
      <table class="table"><thead><tr><th>Job</th><th>Company</th><th>Status</th><th>Approved</th></tr></thead><tbody>
        <?php foreach($recent as $r): ?><tr><td><?= e($r['title']) ?></td><td><?= e($r['company_name']) ?></td><td><?= app_status_badge($r['status']) ?></td><td><?= $r['is_approved'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning">No</span>' ?></td></tr><?php endforeach; ?>
      </tbody></table>
    </div>
  </div>
 </div>
</div>
