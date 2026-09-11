<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('seeker');
$seekerId=$_SESSION['user_id'];
if(isset($_GET['remove'])){
  $pdo->prepare("DELETE FROM saved_jobs WHERE id=? AND seeker_id=?")->execute([(int)$_GET['remove'],$seekerId]);
  flash('success','Saved job removed.');
  redirect(BASE_URL . '/seeker/saved-jobs.php');
}
$rows=$pdo->query("SELECT s.id save_id, j.*, e.company_name, l.name location_name FROM saved_jobs s JOIN jobs j ON s.job_id=j.id JOIN employers e ON j.employer_id=e.id JOIN locations l ON j.location_id=l.id WHERE s.seeker_id={$seekerId} ORDER BY s.id DESC")->fetchAll();
$pageTitle='Saved Jobs'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Job Seeker Panel</h4>
  <a href="<?= BASE_URL ?>/seeker/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/seeker/my-applications.php">My Applications</a>
  <a class="active" href="<?= BASE_URL ?>/seeker/saved-jobs.php">Saved Jobs</a>
  <a href="<?= BASE_URL ?>/seeker/profile.php">My Profile</a>
  <a href="<?= BASE_URL ?>/pages/jobs.php">Browse Jobs</a>
 </div>
 <div class="dashboard-main">
  <div class="table-card">
    <h2 class="section-title mb-4">Saved Jobs</h2>
    <div class="row g-4">
      <?php foreach($rows as $r): ?>
      <div class="col-md-6">
        <div class="job-card p-4 h-100">
          <h5><?= e($r['title']) ?></h5>
          <p class="mb-1"><i class="fa-solid fa-building me-2"></i><?= e($r['company_name']) ?></p>
          <p class="mb-3"><i class="fa-solid fa-location-dot me-2"></i><?= e($r['location_name']) ?></p>
          <div class="d-flex gap-2">
            <a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/pages/job-details.php?id=<?= $r['id'] ?>">View</a>
            <a class="btn btn-sm btn-outline-danger" href="?remove=<?= $r['save_id'] ?>" data-confirm="Remove saved job?">Remove</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if(!$rows): ?><div class="col-12"><div class="alert alert-warning">No saved jobs yet.</div></div><?php endif; ?>
    </div>
  </div>
 </div>
</div>
