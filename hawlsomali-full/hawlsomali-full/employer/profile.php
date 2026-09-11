<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('employer');
$employerId=$_SESSION['user_id'];
$stmt=$pdo->prepare("SELECT * FROM employers WHERE id=?"); $stmt->execute([$employerId]); $company=$stmt->fetch();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $logo = upload_image('logo', __DIR__ . '/../assets/uploads/logo');
  $stmt=$pdo->prepare("UPDATE employers SET company_name=?, phone=?, address=?, website=?, description=?, logo=COALESCE(?,logo) WHERE id=?");
  $stmt->execute([trim($_POST['company_name']), trim($_POST['phone']), trim($_POST['address']), trim($_POST['website']), trim($_POST['description']), $logo, $employerId]);
  flash('success','Company profile updated.');
  redirect(BASE_URL . '/employer/profile.php');
}
$pageTitle='Company Profile'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Employer Panel</h4>
  <a href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/employer/post-job.php">Post Job</a>
  <a href="<?= BASE_URL ?>/employer/manage-jobs.php">Manage Jobs</a>
  <a href="<?= BASE_URL ?>/employer/applicants.php">Applicants</a>
  <a class="active" href="<?= BASE_URL ?>/employer/profile.php">Company Profile</a>
 </div>
 <div class="dashboard-main">
  <div class="form-section">
    <h2 class="section-title mb-4">Company Profile</h2>
    <form method="post" enctype="multipart/form-data" class="row g-3">
      <div class="col-md-6"><label class="form-label">Company Name</label><input name="company_name" class="form-control" value="<?= e($company['company_name']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="<?= e($company['phone']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Website</label><input name="website" class="form-control" value="<?= e($company['website']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Logo</label><input type="file" name="logo" class="form-control"></div>
      <div class="col-12"><label class="form-label">Address</label><input name="address" class="form-control" value="<?= e($company['address']) ?>"></div>
      <div class="col-12"><label class="form-label">Description</label><textarea name="description" rows="5" class="form-control"><?= e($company['description']) ?></textarea></div>
      <div class="col-12 d-grid"><button class="btn btn-primary">Save Changes</button></div>
    </form>
  </div>
 </div>
</div>
