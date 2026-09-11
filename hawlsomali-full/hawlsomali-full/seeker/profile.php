<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('seeker');
$seekerId=$_SESSION['user_id'];
$stmt=$pdo->prepare("SELECT * FROM job_seekers WHERE id=?"); $stmt->execute([$seekerId]); $seeker=$stmt->fetch();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $cv = upload_file('cv_file', __DIR__ . '/../assets/uploads/cv');
  $stmt=$pdo->prepare("UPDATE job_seekers SET full_name=?, phone=?, gender=?, location=?, education=?, skills=?, experience=?, cv_file=COALESCE(?,cv_file) WHERE id=?");
  $stmt->execute([trim($_POST['full_name']), trim($_POST['phone']), trim($_POST['gender']), trim($_POST['location']), trim($_POST['education']), trim($_POST['skills']), trim($_POST['experience']), $cv, $seekerId]);
  flash('success','Profile updated.');
  redirect(BASE_URL . '/seeker/profile.php');
}
$pageTitle='My Profile'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Job Seeker Panel</h4>
  <a href="<?= BASE_URL ?>/seeker/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/seeker/my-applications.php">My Applications</a>
  <a href="<?= BASE_URL ?>/seeker/saved-jobs.php">Saved Jobs</a>
  <a class="active" href="<?= BASE_URL ?>/seeker/profile.php">My Profile</a>
  <a href="<?= BASE_URL ?>/pages/jobs.php">Browse Jobs</a>
 </div>
 <div class="dashboard-main">
  <div class="form-section">
    <h2 class="section-title mb-4">My Profile</h2>
    <form method="post" enctype="multipart/form-data" class="row g-3">
      <div class="col-md-6"><label class="form-label">Full Name</label><input name="full_name" class="form-control" value="<?= e($seeker['full_name']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="<?= e($seeker['phone']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Gender</label><input name="gender" class="form-control" value="<?= e($seeker['gender']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Location</label><input name="location" class="form-control" value="<?= e($seeker['location']) ?>"></div>
      <div class="col-md-4"><label class="form-label">Education</label><input name="education" class="form-control" value="<?= e($seeker['education']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Experience</label><input name="experience" class="form-control" value="<?= e($seeker['experience']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Upload CV</label><input type="file" name="cv_file" class="form-control"></div>
      <div class="col-12"><label class="form-label">Skills</label><textarea name="skills" rows="5" class="form-control"><?= e($seeker['skills']) ?></textarea></div>
      <div class="col-12 d-grid"><button class="btn btn-primary">Save Profile</button></div>
    </form>
  </div>
 </div>
</div>
