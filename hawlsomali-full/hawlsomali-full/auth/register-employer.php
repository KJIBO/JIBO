<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $logo = upload_image('logo', __DIR__ . '/../assets/uploads/logo');
  $stmt=$pdo->prepare("INSERT INTO employers(company_name,email,password,phone,address,website,description,logo,status) VALUES (?,?,?,?,?,?,?,?, 'active')");
  try{
    $stmt->execute([
      trim($_POST['company_name']),
      trim($_POST['email']),
      password_hash($_POST['password'], PASSWORD_DEFAULT),
      trim($_POST['phone']),
      trim($_POST['address']),
      trim($_POST['website']),
      trim($_POST['description']),
      $logo
    ]);
    flash('success','Employer account created. You can login now.');
    redirect(BASE_URL . '/auth/login.php');
  } catch(Throwable $e){
    flash('error','Could not register employer. Email may already exist.');
    redirect(BASE_URL . '/auth/register-employer.php');
  }
}
$pageTitle='Employer Register'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5"><div class="container"><div class="row justify-content-center"><div class="col-lg-8"><div class="form-section">
<h2 class="section-title mb-4">Create Employer Account</h2>
<form method="post" enctype="multipart/form-data" class="row g-3">
<div class="col-md-6"><label class="form-label">Company Name</label><input name="company_name" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Website</label><input name="website" class="form-control"></div>
<div class="col-12"><label class="form-label">Address</label><input name="address" class="form-control"></div>
<div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">Company Logo</label><input type="file" name="logo" class="form-control"></div>
<div class="col-12"><label class="form-label">Description</label><textarea name="description" rows="5" class="form-control"></textarea></div>
<div class="col-12 d-grid"><button class="btn btn-success">Create Employer Account</button></div>
</form>
</div></div></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
