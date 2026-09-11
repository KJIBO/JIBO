<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $cv = upload_file('cv_file', __DIR__ . '/../assets/uploads/cv');
  $stmt=$pdo->prepare("INSERT INTO job_seekers(full_name,email,password,phone,gender,location,education,skills,experience,cv_file,status) VALUES (?,?,?,?,?,?,?,?,?,?,'active')");
  try{
    $stmt->execute([
      trim($_POST['full_name']),
      trim($_POST['email']),
      password_hash($_POST['password'], PASSWORD_DEFAULT),
      trim($_POST['phone']),
      trim($_POST['gender']),
      trim($_POST['location']),
      trim($_POST['education']),
      trim($_POST['skills']),
      trim($_POST['experience']),
      $cv
    ]);
    flash('success','Job seeker account created. You can login now.');
    redirect(BASE_URL . '/auth/login.php');
  } catch(Throwable $e){
    flash('error','Could not register job seeker. Email may already exist.');
    redirect(BASE_URL . '/auth/register-seeker.php');
  }
}
$pageTitle='Job Seeker Register'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5"><div class="container"><div class="row justify-content-center"><div class="col-lg-9"><div class="form-section">
<h2 class="section-title mb-4">Create Job Seeker Account</h2>
<form method="post" enctype="multipart/form-data" class="row g-3">
<div class="col-md-6"><label class="form-label">Full Name</label><input name="full_name" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Gender</label><select name="gender" class="form-select"><option>Male</option><option>Female</option></select></div>
<div class="col-md-6"><label class="form-label">Location</label><input name="location" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Education</label><input name="education" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Experience</label><input name="experience" class="form-control" placeholder="2 Years"></div>
<div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
<div class="col-12"><label class="form-label">Skills</label><textarea name="skills" rows="3" class="form-control"></textarea></div>
<div class="col-12"><label class="form-label">CV Upload</label><input type="file" name="cv_file" class="form-control"></div>
<div class="col-12 d-grid"><button class="btn btn-primary">Create Job Seeker Account</button></div>
</form>
</div></div></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
