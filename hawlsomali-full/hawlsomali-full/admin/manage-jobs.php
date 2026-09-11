<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('admin');
if(isset($_GET['approve'])){
  $pdo->prepare("UPDATE jobs SET is_approved=1 WHERE id=?")->execute([(int)$_GET['approve']]);
  flash('success','Job approved.');
  redirect(BASE_URL . '/admin/manage-jobs.php');
}
if(isset($_GET['feature'])){
  $pdo->prepare("UPDATE jobs SET is_featured = IF(is_featured=1,0,1) WHERE id=?")->execute([(int)$_GET['feature']]);
  flash('success','Featured status changed.');
  redirect(BASE_URL . '/admin/manage-jobs.php');
}
if(isset($_GET['delete'])){
  $pdo->prepare("DELETE FROM jobs WHERE id=?")->execute([(int)$_GET['delete']]);
  flash('success','Job deleted.');
  redirect(BASE_URL . '/admin/manage-jobs.php');
}
$rows=$pdo->query("SELECT j.*, e.company_name, c.name category_name, l.name location_name FROM jobs j JOIN employers e ON j.employer_id=e.id JOIN categories c ON j.category_id=c.id JOIN locations l ON j.location_id=l.id ORDER BY j.id DESC")->fetchAll();
$pageTitle='Manage Jobs'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout"><?php include __DIR__ . '/partials/sidebar.php'; ?><div class="dashboard-main">
<div class="table-card">
<h2 class="section-title mb-4">Manage Jobs</h2>
<div class="table-responsive"><table class="table align-middle">
<thead><tr><th>Title</th><th>Company</th><th>Category</th><th>Location</th><th>Status</th><th>Approved</th><th>Featured</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?><tr>
<td><?= e($r['title']) ?></td><td><?= e($r['company_name']) ?></td><td><?= e($r['category_name']) ?></td><td><?= e($r['location_name']) ?></td>
<td><?= app_status_badge($r['status']) ?></td>
<td><?= $r['is_approved'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning">No</span>' ?></td>
<td><?= $r['is_featured'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
<td>
 <a class="btn btn-sm btn-outline-success" href="?approve=<?= $r['id'] ?>">Approve</a>
 <a class="btn btn-sm btn-outline-primary" href="?feature=<?= $r['id'] ?>">Feature</a>
 <a class="btn btn-sm btn-outline-danger" href="?delete=<?= $r['id'] ?>" data-confirm="Delete this job?">Delete</a>
</td></tr><?php endforeach; ?>
</tbody></table></div></div></div></div>
