<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/functions.php';
$pageTitle='Home';
$jobs = $pdo->query("SELECT jobs.*, employers.company_name, categories.name AS category_name, locations.name AS location_name
FROM jobs
JOIN employers ON jobs.employer_id=employers.id
JOIN categories ON jobs.category_id=categories.id
JOIN locations ON jobs.location_id=locations.id
WHERE jobs.status='active' AND jobs.is_approved=1
ORDER BY jobs.is_featured DESC, jobs.id DESC LIMIT 8")->fetchAll();
$categories = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM jobs j WHERE j.category_id=c.id AND j.status='active' AND j.is_approved=1) total_jobs FROM categories c ORDER BY total_jobs DESC, c.name ASC LIMIT 6")->fetchAll();
$stats = [
 'jobs'=>count_row($pdo,'jobs',"status='active' AND is_approved=1"),
 'companies'=>count_row($pdo,'employers',"status='active'"),
 'seekers'=>count_row($pdo,'job_seekers',"status='active'"),
 'applications'=>count_row($pdo,'applications')
];
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <span class="badge bg-light text-primary mb-3 px-3 py-2">Somali Jobs Platform</span>
        <h1 class="display-5 fw-bold mb-3">Find Jobs in Somalia and Connect with Real Employers</h1>
        <p class="lead mb-4">HawlSomali helps employers post opportunities and helps job seekers discover work across Mogadishu, Bosaso, Hargeisa, Garowe, Kismayo, and remote roles.</p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="<?= BASE_URL ?>/pages/jobs.php" class="btn btn-success btn-lg">Find Jobs</a>
          <a href="<?= BASE_URL ?>/auth/register-employer.php" class="btn btn-outline-light btn-lg">Post a Job</a>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="hero-card p-4 text-dark">
          <h4 class="mb-3">Search Opportunities</h4>
          <form action="<?= BASE_URL ?>/pages/jobs.php" method="get" class="row g-3">
            <div class="col-12">
              <label class="form-label">Keyword</label>
              <input type="text" name="keyword" class="form-control" placeholder="Job title or skill">
            </div>
            <div class="col-md-6">
              <label class="form-label">Location</label>
              <input type="text" name="location" class="form-control" placeholder="Bosaso">
            </div>
            <div class="col-md-6">
              <label class="form-label">Job Type</label>
              <select name="job_type" class="form-select">
                <option value="">Any type</option>
                <option>Full Time</option>
                <option>Part Time</option>
                <option>Contract</option>
                <option>Remote</option>
                <option>Internship</option>
              </select>
            </div>
            <div class="col-12"><button class="btn btn-primary w-100">Search Jobs</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="py-5">
 <div class="container">
  <div class="row g-4 text-center">
    <?php foreach ($stats as $label=>$value): ?>
      <div class="col-md-3">
        <div class="metric-card p-4">
          <h3><?= e($value) ?>+</h3>
          <p class="mb-0 text-capitalize"><?= e($label) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
 </div>
</section>
<section class="py-5 bg-white">
 <div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div><h2 class="section-title mb-1">Popular Categories</h2><p class="text-muted mb-0">Explore jobs by field.</p></div>
    <a href="<?= BASE_URL ?>/pages/jobs.php" class="btn btn-outline-primary">Browse Jobs</a>
  </div>
  <div class="row g-4">
    <?php foreach($categories as $cat): ?>
    <div class="col-md-4 col-lg-2">
      <div class="feature-card p-4 text-center h-100">
        <div class="icon-circle mx-auto mb-3"><i class="fa-solid fa-layer-group"></i></div>
        <h6><?= e($cat['name']) ?></h6>
        <small class="text-muted"><?= e($cat['total_jobs']) ?> open jobs</small>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
 </div>
</section>
<section class="py-5">
 <div class="container">
   <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
     <div><h2 class="section-title mb-1">Featured & Latest Jobs</h2><p class="text-muted mb-0">Fresh roles from Somali employers.</p></div>
     <a href="<?= BASE_URL ?>/pages/jobs.php" class="btn btn-success">View All Jobs</a>
   </div>
   <div class="row g-4">
     <?php foreach($jobs as $job): ?>
       <div class="col-lg-3 col-md-6">
         <div class="job-card p-4 h-100">
           <div class="d-flex justify-content-between align-items-center mb-3">
             <span class="badge bg-primary"><?= e($job['category_name']) ?></span>
             <?= $job['is_featured'] ? '<span class="badge bg-success">Featured</span>' : '' ?>
           </div>
           <h5><?= e($job['title']) ?></h5>
           <p class="mb-1"><i class="fa-solid fa-building me-2"></i><?= e($job['company_name']) ?></p>
           <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i><?= e($job['location_name']) ?></p>
           <p class="mb-1"><i class="fa-solid fa-briefcase me-2"></i><?= e($job['job_type']) ?></p>
           <p class="mb-3"><i class="fa-solid fa-money-bill-wave me-2"></i>$<?= number_format((float)$job['salary_min']) ?> - $<?= number_format((float)$job['salary_max']) ?></p>
           <div class="mt-auto d-flex justify-content-between align-items-center">
             <small class="text-muted">Deadline: <?= e($job['deadline']) ?></small>
             <a href="<?= BASE_URL ?>/pages/job-details.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-primary">Details</a>
           </div>
         </div>
       </div>
     <?php endforeach; ?>
   </div>
 </div>
</section>
<section class="py-5 bg-white">
 <div class="container">
   <div class="row g-4">
     <div class="col-lg-4"><div class="content-card p-4 h-100"><div class="icon-circle mb-3"><i class="fa-solid fa-file-arrow-up"></i></div><h5>Upload CV</h5><p class="mb-0">Create a job seeker profile and keep your CV ready for applications.</p></div></div>
     <div class="col-lg-4"><div class="content-card p-4 h-100"><div class="icon-circle mb-3"><i class="fa-solid fa-building-user"></i></div><h5>Employer Dashboard</h5><p class="mb-0">Companies can post jobs, review applicants, and update application statuses.</p></div></div>
     <div class="col-lg-4"><div class="content-card p-4 h-100"><div class="icon-circle mb-3"><i class="fa-solid fa-shield-halved"></i></div><h5>Admin Approval</h5><p class="mb-0">Jobs can be reviewed and approved before they go live to keep quality high.</p></div></div>
   </div>
 </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
