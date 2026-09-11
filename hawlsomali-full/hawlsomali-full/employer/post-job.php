<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('employer');
$cats=$pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$locs=$pdo->query("SELECT * FROM locations ORDER BY name")->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $stmt=$pdo->prepare("INSERT INTO jobs(employer_id,category_id,location_id,title,job_type,salary_min,salary_max,experience_level,education_level,vacancy_count,deadline,description,requirements,responsibilities,status,is_approved,is_featured) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?, 'active',0,0)");
  $stmt->execute([
    $_SESSION['user_id'], (int)$_POST['category_id'], (int)$_POST['location_id'], trim($_POST['title']), trim($_POST['job_type']),
    (float)str_replace(',','',$_POST['salary_min']), (float)str_replace(',','',$_POST['salary_max']), trim($_POST['experience_level']), trim($_POST['education_level']),
    (int)$_POST['vacancy_count'], $_POST['deadline'], trim($_POST['description']), trim($_POST['requirements']), trim($_POST['responsibilities'])
  ]);
  flash('success','Job posted successfully and sent for admin approval.');
  redirect(BASE_URL . '/employer/manage-jobs.php');
}
$pageTitle='Post Job'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Employer Panel</h4>
  <a href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
  <a class="active" href="<?= BASE_URL ?>/employer/post-job.php">Post Job</a>
  <a href="<?= BASE_URL ?>/employer/manage-jobs.php">Manage Jobs</a>
  <a href="<?= BASE_URL ?>/employer/applicants.php">Applicants</a>
  <a href="<?= BASE_URL ?>/employer/profile.php">Company Profile</a>
  <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
 </div>
 <div class="dashboard-main">
  <div class="form-section">
    <h2 class="section-title mb-4">Post a New Job</h2>
    <form method="post" class="row g-3">
      <div class="col-md-8"><label class="form-label">Job Title</label><input name="title" class="form-control" required></div>
      <div class="col-md-4"><label class="form-label">Vacancy Count</label><input type="number" name="vacancy_count" class="form-control" value="1"></div>
      <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select" required><?php foreach($cats as $c): ?><option value="<?= $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-4"><label class="form-label">Location</label><select name="location_id" class="form-select" required><?php foreach($locs as $l): ?><option value="<?= $l['id'] ?>"><?= e($l['name']) ?></option><?php endforeach; ?></select></div>
      <div class="col-md-4"><label class="form-label">Job Type</label><select name="job_type" class="form-select"><option>Full Time</option><option>Part Time</option><option>Contract</option><option>Remote</option><option>Internship</option></select></div>
      <div class="col-md-3"><label class="form-label">Salary Min</label><input name="salary_min" class="form-control" value="300"></div>
      <div class="col-md-3"><label class="form-label">Salary Max</label><input name="salary_max" class="form-control" value="600"></div>
      <div class="col-md-3"><label class="form-label">Experience Level</label><input name="experience_level" class="form-control"></div>
      <div class="col-md-3"><label class="form-label">Education Level</label><input name="education_level" class="form-control"></div>
      <div class="col-md-4"><label class="form-label">Deadline</label><input type="date" name="deadline" class="form-control" required></div>
      <div class="col-12"><label class="form-label">Description</label><textarea name="description" rows="5" class="form-control" required></textarea></div>
      <div class="col-md-6"><label class="form-label">Requirements</label><textarea name="requirements" rows="5" class="form-control"></textarea></div>
      <div class="col-md-6"><label class="form-label">Responsibilities</label><textarea name="responsibilities" rows="5" class="form-control"></textarea></div>
      <div class="col-12 d-grid"><button class="btn btn-success">Post Job</button></div>
    </form>
  </div>
 </div>
</div>
