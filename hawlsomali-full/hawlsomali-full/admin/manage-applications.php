<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; require_login('admin');
$rows=$pdo->query("SELECT a.*, j.title, e.company_name, s.full_name FROM applications a JOIN jobs j ON a.job_id=j.id JOIN employers e ON j.employer_id=e.id JOIN job_seekers s ON a.seeker_id=s.id ORDER BY a.id DESC")->fetchAll();
$pageTitle='Manage Applications'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<div class="dashboard-layout"><?php include __DIR__ . '/partials/sidebar.php'; ?><div class="dashboard-main"><div class="table-card">
<h2 class="section-title mb-4">Applications</h2>
<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Applicant</th><th>Job</th><th>Company</th><th>Status</th><th>Applied At</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= e($r['full_name']) ?></td><td><?= e($r['title']) ?></td><td><?= e($r['company_name']) ?></td><td><?= app_status_badge($r['status']) ?></td><td><?= e($r['applied_at']) ?></td></tr><?php endforeach; ?>
</tbody></table></div></div></div></div>
