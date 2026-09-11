<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('employer');
$employerId=$_SESSION['user_id'];
if(isset($_GET['status'], $_GET['id'])){
  $allowed=['pending','shortlisted','accepted','rejected'];
  if(in_array($_GET['status'],$allowed,true)){
    $stmt=$pdo->prepare("UPDATE applications a JOIN jobs j ON a.job_id=j.id SET a.status=? WHERE a.id=? AND j.employer_id=?");
    $stmt->execute([$_GET['status'], (int)$_GET['id'], $employerId]);
    flash('success','Application status updated.');
  }
  redirect(BASE_URL . '/employer/applicants.php');
}
$applications=$pdo->query("SELECT a.*, j.title, s.full_name, s.email, s.phone, s.location, s.cv_file
FROM applications a
JOIN jobs j ON a.job_id=j.id
JOIN job_seekers s ON a.seeker_id=s.id
WHERE j.employer_id={$employerId}
ORDER BY a.id DESC")->fetchAll();
$pageTitle='Applicants'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout">
 <div class="dashboard-sidebar">
  <h4 class="mb-4">Employer Panel</h4>
  <a href="<?= BASE_URL ?>/employer/dashboard.php">Dashboard</a>
  <a href="<?= BASE_URL ?>/employer/post-job.php">Post Job</a>
  <a href="<?= BASE_URL ?>/employer/manage-jobs.php">Manage Jobs</a>
  <a class="active" href="<?= BASE_URL ?>/employer/applicants.php">Applicants</a>
  <a href="<?= BASE_URL ?>/employer/profile.php">Company Profile</a>
  <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
 </div>
 <div class="dashboard-main">
  <div class="table-card">
    <h2 class="section-title mb-4">Applicants</h2>
    <div class="table-responsive">
      <table class="table align-middle">
        <thead><tr><th>Applicant</th><th>Job</th><th>Contact</th><th>Cover Letter</th><th>Status</th><th>CV</th><th>Action</th></tr></thead>
        <tbody>
          <?php foreach($applications as $a): ?>
          <tr>
            <td><?= e($a['full_name']) ?><br><small class="text-muted"><?= e($a['location']) ?></small></td>
            <td><?= e($a['title']) ?></td>
            <td><?= e($a['email']) ?><br><small><?= e($a['phone']) ?></small></td>
            <td style="max-width:220px"><?= e(mb_strimwidth($a['cover_letter'],0,100,'...')) ?></td>
            <td><?= app_status_badge($a['status']) ?></td>
            <td><?php if($a['cv_file']): ?><a target="_blank" href="<?= BASE_URL ?>/assets/uploads/cv/<?= e($a['cv_file']) ?>">Download</a><?php else: ?>-<?php endif; ?></td>
            <td>
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">Update</button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="?id=<?= $a['id'] ?>&status=shortlisted">Shortlist</a></li>
                  <li><a class="dropdown-item" href="?id=<?= $a['id'] ?>&status=accepted">Accept</a></li>
                  <li><a class="dropdown-item" href="?id=<?= $a['id'] ?>&status=rejected">Reject</a></li>
                  <li><a class="dropdown-item" href="?id=<?= $a['id'] ?>&status=pending">Pending</a></li>
                </ul>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
 </div>
</div>
