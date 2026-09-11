<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('employer');
$employerId=$_SESSION['user_id']; $id=(int)($_GET['id'] ?? 0);
$stmt=$pdo->prepare("SELECT * FROM jobs WHERE id=? AND employer_id=?"); $stmt->execute([$id,$employerId]); $job=$stmt->fetch();
if(!$job) die('Job not found');
$cats=$pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(); $locs=$pdo->query("SELECT * FROM locations ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $stmt=$pdo->prepare("UPDATE jobs SET category_id=?,location_id=?,title=?,job_type=?,salary_min=?,salary_max=?,experience_level=?,education_level=?,vacancy_count=?,deadline=?,description=?,requirements=?,responsibilities=?,is_approved=0 WHERE id=? AND employer_id=?");
  $stmt->execute([(int)$_POST['category_id'],(int)$_POST['location_id'],trim($_POST['title']),trim($_POST['job_type']),(float)$_POST['salary_min'],(float)$_POST['salary_max'],trim($_POST['experience_level']),trim($_POST['education_level']),(int)$_POST['vacancy_count'],$_POST['deadline'],trim($_POST['description']),trim($_POST['requirements']),trim($_POST['responsibilities']),$id,$employerId]);
  flash('success','Job updated and returned for approval.');
  redirect(BASE_URL . '/employer/manage-jobs.php');
}
$pageTitle='Edit Job'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Employer Panel</h4>
  <a href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/employer/post-job.php">Post Job</a>
  <a class="active" href="<?= BASE_URL ?>/employer/manage-jobs.php">Manage Jobs</a>
  <a href="<?= BASE_URL ?>/employer/applicants.php">Applicants</a>
  <a href="<?= BASE_URL ?>/employer/profile.php">Company Profile</a>
 </div>
 <div class="dashboard-main"><div class="form-section"><h2 class="section-title mb-4">Edit Job</h2>
 <form method="post" class="row g-3">
   <div class="col-md-8"><label class="form-label">Job Title</label><input name="title" class="form-control" value="<?= e($job['title']) ?>" required></div>
   <div class="col-md-4"><label class="form-label">Vacancy Count</label><input type="number" name="vacancy_count" class="form-control" value="<?= e($job['vacancy_count']) ?>"></div>
   <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select"><?php foreach($cats as $c): ?><option value="<?= $c['id'] ?>" <?= $c['id']==$job['category_id']?'selected':'' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
   <div class="col-md-4"><label class="form-label">Location</label><select name="location_id" class="form-select"><?php foreach($locs as $l): ?><option value="<?= $l['id'] ?>" <?= $l['id']==$job['location_id']?'selected':'' ?>><?= e($l['name']) ?></option><?php endforeach; ?></select></div>
   <div class="col-md-4"><label class="form-label">Job Type</label><input name="job_type" class="form-control" value="<?= e($job['job_type']) ?>"></div>
   <div class="col-md-3"><label class="form-label">Salary Min</label><input name="salary_min" class="form-control" value="<?= e($job['salary_min']) ?>"></div>
   <div class="col-md-3"><label class="form-label">Salary Max</label><input name="salary_max" class="form-control" value="<?= e($job['salary_max']) ?>"></div>
   <div class="col-md-3"><label class="form-label">Experience Level</label><input name="experience_level" class="form-control" value="<?= e($job['experience_level']) ?>"></div>
   <div class="col-md-3"><label class="form-label">Education Level</label><input name="education_level" class="form-control" value="<?= e($job['education_level']) ?>"></div>
   <div class="col-md-4"><label class="form-label">Deadline</label><input type="date" name="deadline" class="form-control" value="<?= e($job['deadline']) ?>"></div>
   <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4"><?= e($job['description']) ?></textarea></div>
   <div class="col-md-6"><label class="form-label">Requirements</label><textarea name="requirements" class="form-control" rows="4"><?= e($job['requirements']) ?></textarea></div>
   <div class="col-md-6"><label class="form-label">Responsibilities</label><textarea name="responsibilities" class="form-control" rows="4"><?= e($job['responsibilities']) ?></textarea></div>
   <div class="col-12 d-grid"><button class="btn btn-primary">Update Job</button></div>
 </form></div></div>
</div>
