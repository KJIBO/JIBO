<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('admin');
if(isset($_GET['delete'])){
  $pdo->prepare("DELETE FROM contact_messages WHERE id=?")->execute([(int)$_GET['delete']]);
  flash('success','Message deleted.');
  redirect(BASE_URL . '/admin/manage-messages.php');
}
$rows=$pdo->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();
$pageTitle='Manage Messages'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout"><?php include __DIR__ . '/partials/sidebar.php'; ?><div class="dashboard-main"><div class="table-card">
<h2 class="section-title mb-4">Contact Messages</h2>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Action</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= e($r['name']) ?></td><td><?= e($r['email']) ?></td><td><?= e($r['subject']) ?></td><td style="max-width:300px"><?= e(mb_strimwidth($r['message'],0,140,'...')) ?></td><td><a class="btn btn-sm btn-outline-danger" href="?delete=<?= $r['id'] ?>" data-confirm="Delete this message?">Delete</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></div></div>
