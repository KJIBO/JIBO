<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('employer');
$employerId=$_SESSION['user_id'];
if(isset($_GET['close'])){
  $pdo->prepare("UPDATE jobs SET status='closed' WHERE id=? AND employer_id=?")->execute([(int)$_GET['close'],$employerId]);
  flash('success','Job closed successfully.');
  redirect(BASE_URL . '/employer/manage-jobs.php');
}
if(isset($_GET['delete'])){
  $pdo->prepare("DELETE FROM jobs WHERE id=? AND employer_id=?")->execute([(int)$_GET['delete'],$employerId]);
  flash('success','Job deleted successfully.');
  redirect(BASE_URL . '/employer/manage-jobs.php');
}
$jobs=$pdo->query("SELECT j.*, c.name category_name, l.name location_name FROM jobs j JOIN categories c ON j.category_id=c.id JOIN locations l ON j.location_id=l.id WHERE j.employer_id={$employerId} ORDER BY j.id DESC")->fetchAll();
$pageTitle='Manage Jobs'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Employer Panel</h4>
  <a href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/employer/post-job.php">Post Job</a>
  <a class="active" href="<?= BASE_URL ?>/employer/manage-jobs.php">Manage Jobs</a>
  <a href="<?= BASE_URL ?>/employer/applicants.php">Applicants</a>
  <a href="<?= BASE_URL ?>/employer/profile.php">Company Profile</a>
  <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
 </div>
 <div class="dashboard-main">
  <div class="table-card">
   <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="section-title mb-0">Manage Jobs</h2><a href="<?= BASE_URL ?>/employer/post-job.php" class="btn btn-primary">Post New</a></div>
   <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Title</th><th>Category</th><th>Location</th><th>Status</th><th>Approved</th><th>Deadline</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach($jobs as $job): ?>
        <tr>
          <td><?= e($job['title']) ?></td><td><?= e($job['category_name']) ?></td><td><?= e($job['location_name']) ?></td>
          <td><?= app_status_badge($job['status']) ?></td>
          <td><?= $job['is_approved'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning">Pending</span>' ?></td>
          <td><?= e($job['deadline']) ?></td>
          <td>
            <a href="<?= BASE_URL ?>/employer/edit-job.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
            <a href="?close=<?= $job['id'] ?>" class="btn btn-sm btn-outline-dark" data-confirm="Close this job?">Close</a>
            <a href="?delete=<?= $job['id'] ?>" class="btn btn-sm btn-outline-danger" data-confirm="Delete this job?">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   </div>
  </div>
 </div>
</div>
