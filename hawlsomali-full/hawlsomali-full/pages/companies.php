<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$pageTitle='Companies';
$companies=$pdo->query("SELECT e.*, (SELECT COUNT(*) FROM jobs j WHERE j.employer_id=e.id AND j.status='active' AND j.is_approved=1) AS total_jobs FROM employers e ORDER BY total_jobs DESC, company_name ASC")->fetchAll();
include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5">
 <div class="container">
  <div class="mb-4"><h1 class="section-title">Companies</h1><p class="text-muted">Browse employers using HawlSomali.</p></div>
  <div class="row g-4">
   <?php foreach($companies as $c): ?>
   <div class="col-md-6 col-lg-4">
    <div class="content-card p-4 h-100">
      <div class="d-flex align-items-center gap-3 mb-3">
        <div class="company-logo"><?= strtoupper(substr($c['company_name'],0,1)) ?></div>
        <div>
          <h5 class="mb-0"><?= e($c['company_name']) ?></h5>
          <small class="text-muted"><?= e($c['address']) ?></small>
        </div>
      </div>
      <p><?= e($c['description']) ?></p>
      <div class="d-flex justify-content-between align-items-center">
        <span class="badge-soft"><?= e($c['total_jobs']) ?> active jobs</span>
        <span><?= app_status_badge($c['status']) ?></span>
      </div>
    </div>
   </div>
   <?php endforeach; ?>
  </div>
 </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
