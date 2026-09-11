<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('admin');
if(isset($_GET['toggle'])){
  $pdo->prepare("UPDATE job_seekers SET status = IF(status='active','inactive','active') WHERE id=?")->execute([(int)$_GET['toggle']]);
  flash('success','Seeker status updated.');
  redirect(BASE_URL . '/admin/manage-seekers.php');
}
$rows=$pdo->query("SELECT * FROM job_seekers ORDER BY id DESC")->fetchAll();
$pageTitle='Manage Seekers'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout"><?php include __DIR__ . '/partials/sidebar.php'; ?><div class="dashboard-main"><div class="table-card">
<h2 class="section-title mb-4">Job Seekers</h2>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Location</th><th>Education</th><th>Status</th><th>Action</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= e($r['full_name']) ?></td><td><?= e($r['email']) ?></td><td><?= e($r['phone']) ?></td><td><?= e($r['location']) ?></td><td><?= e($r['education']) ?></td><td><?= app_status_badge($r['status']) ?></td><td><a class="btn btn-sm btn-outline-primary" href="?toggle=<?= $r['id'] ?>">Toggle Status</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></div></div>
