<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('admin');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $pdo->prepare("INSERT INTO categories(name) VALUES (?)")->execute([trim($_POST['name'])]);
  flash('success','Category added.');
  redirect(BASE_URL . '/admin/manage-categories.php');
}
if(isset($_GET['delete'])){
  $pdo->prepare("DELETE FROM categories WHERE id=?")->execute([(int)$_GET['delete']]);
  flash('success','Category deleted.');
  redirect(BASE_URL . '/admin/manage-categories.php');
}
$rows=$pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$pageTitle='Manage Categories'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout"><?php include __DIR__ . '/partials/sidebar.php'; ?><div class="dashboard-main">
<div class="row g-4"><div class="col-lg-4"><div class="form-section"><h5 class="mb-3">Add Category</h5><form method="post"><label class="form-label">Name</label><input name="name" class="form-control mb-3" required><button class="btn btn-primary w-100">Add</button></form></div></div>
<div class="col-lg-8"><div class="table-card"><h2 class="section-title mb-4">Categories</h2><table class="table"><thead><tr><th>Name</th><th>Action</th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?= e($r['name']) ?></td><td><a class="btn btn-sm btn-outline-danger" href="?delete=<?= $r['id'] ?>" data-confirm="Delete this category?">Delete</a></td></tr><?php endforeach; ?></tbody></table></div></div></div>
</div></div>
