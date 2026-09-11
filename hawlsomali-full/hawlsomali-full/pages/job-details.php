<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt=$pdo->prepare("SELECT j.*, e.company_name, e.description AS company_description, c.name AS category_name, l.name AS location_name
FROM jobs j
JOIN employers e ON j.employer_id=e.id
JOIN categories c ON j.category_id=c.id
JOIN locations l ON j.location_id=l.id
WHERE j.id=? AND j.is_approved=1");
$stmt->execute([$id]); $job=$stmt->fetch();
if(!$job){ die('Job not found'); }

if(isset($_GET['save']) && is_logged_in('seeker')){
  $check = $pdo->prepare("SELECT id FROM saved_jobs WHERE seeker_id=? AND job_id=?");
  $check->execute([$_SESSION['user_id'], $id]);
  if(!$check->fetch()){
    $pdo->prepare("INSERT INTO saved_jobs(seeker_id,job_id) VALUES (?,?)")->execute([$_SESSION['user_id'], $id]);
    flash('success','Job saved.');
  }
  redirect(BASE_URL . '/pages/job-details.php?id=' . $id);
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  require_login('seeker');
  $check=$pdo->prepare("SELECT id FROM applications WHERE job_id=? AND seeker_id=?");
  $check->execute([$id,$_SESSION['user_id']]);
  if($check->fetch()){
    flash('error','You already applied for this job.');
  } else {
    $pdo->prepare("INSERT INTO applications(job_id,seeker_id,cover_letter,status) VALUES (?,?,?,'pending')")->execute([$id,$_SESSION['user_id'], trim($_POST['cover_letter'])]);
    flash('success','Application submitted successfully.');
  }
  redirect(BASE_URL . '/pages/job-details.php?id=' . $id);
}
$pageTitle='Job Details'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5">
 <div class="container">
  <div class="row g-4">
   <div class="col-lg-8">
    <div class="form-section">
      <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
        <div>
          <span class="badge bg-primary"><?= e($job['category_name']) ?></span>
          <?php if($job['is_featured']): ?><span class="badge bg-success ms-1">Featured</span><?php endif; ?>
        </div>
        <span class="badge-soft"><?= e($job['job_type']) ?></span>
      </div>
      <h1 class="section-title"><?= e($job['title']) ?></h1>
      <p class="mb-1"><i class="fa-solid fa-building me-2"></i><?= e($job['company_name']) ?></p>
      <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i><?= e($job['location_name']) ?></p>
      <p class="mb-4"><i class="fa-solid fa-money-bill-wave me-2"></i>$<?= number_format((float)$job['salary_min']) ?> - $<?= number_format((float)$job['salary_max']) ?></p>
      <h5>Description</h5>
      <p><?= nl2br(e($job['description'])) ?></p>
      <h5>Requirements</h5>
      <p><?= nl2br(e($job['requirements'])) ?></p>
      <h5>Responsibilities</h5>
      <p><?= nl2br(e($job['responsibilities'])) ?></p>
      <h5>Education Level</h5>
      <p><?= e($job['education_level']) ?></p>
      <h5>Experience Level</h5>
      <p><?= e($job['experience_level']) ?></p>
    </div>
   </div>
   <div class="col-lg-4">
    <div class="form-section mb-4">
      <h5>Apply for this Job</h5>
      <p class="text-muted">Deadline: <?= e($job['deadline']) ?></p>
      <?php if(is_logged_in('seeker')): ?>
        <form method="post" class="row g-3">
          <div class="col-12"><label class="form-label">Cover Letter</label><textarea name="cover_letter" class="form-control" rows="6" required></textarea></div>
          <div class="col-12 d-grid"><button class="btn btn-success">Submit Application</button></div>
        </form>
        <a href="<?= BASE_URL ?>/pages/job-details.php?id=<?= $job['id'] ?>&save=1" class="btn btn-outline-primary mt-3 w-100">Save Job</a>
      <?php else: ?>
        <div class="alert alert-info">Login as a job seeker to apply or save this job.</div>
        <a href="<?= BASE_URL ?>/auth/login.php" class="btn btn-primary w-100">Login</a>
      <?php endif; ?>
    </div>
    <div class="form-section">
      <h5>Company Information</h5>
      <p><strong><?= e($job['company_name']) ?></strong></p>
      <p class="mb-0"><?= e($job['company_description']) ?></p>
    </div>
   </div>
  </div>
 </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
