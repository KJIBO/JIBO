<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $role = $_POST['role'];

  $tableMap = ['admin'=>'admins','employer'=>'employers','seeker'=>'job_seekers'];
  if(!isset($tableMap[$role])){ flash('error','Invalid role.'); redirect(BASE_URL . '/auth/login.php'); }
  $stmt=$pdo->prepare("SELECT * FROM {$tableMap[$role]} WHERE email=? LIMIT 1");
  $stmt->execute([$email]);
  $user=$stmt->fetch();
  if($user && password_verify($password, $user['password'])){
    $_SESSION['user_id']=$user['id'];
    $_SESSION['role']=$role;
    $_SESSION['user_name']=$role==='employer' ? $user['company_name'] : ($user['full_name'] ?? $user['email']);
    flash('success','Welcome back.');
    if($role==='admin') redirect(BASE_URL . '/admin/dashboard.php');
    if($role==='employer') redirect(BASE_URL . '/employer/dashboard.php');
    redirect(BASE_URL . '/seeker/dashboard.php');
  } else {
    flash('error','Invalid login credentials.');
    redirect(BASE_URL . '/auth/login.php');
  }
}
$pageTitle='Login'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5">
 <div class="container">
  <div class="row justify-content-center">
   <div class="col-lg-5">
    <div class="form-section">
      <h2 class="section-title mb-4">Login</h2>
      <form method="post" class="row g-3">
        <div class="col-12"><label class="form-label">Role</label>
          <select name="role" class="form-select" required>
            <option value="seeker">Job Seeker</option>
            <option value="employer">Employer</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="col-12"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
        <div class="col-12 d-grid"><button class="btn btn-primary">Login</button></div>
      </form>
      <hr>
      <p class="mb-1">Employer? <a href="<?= BASE_URL ?>/auth/register-employer.php">Create company account</a></p>
      <p class="mb-0">Job seeker? <a href="<?= BASE_URL ?>/auth/register-seeker.php">Create seeker account</a></p>
    </div>
   </div>
  </div>
 </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
