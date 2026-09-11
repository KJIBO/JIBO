<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
$pageTitle='Jobs';
$where = ["j.is_approved=1"];
$params = [];
if (!empty($_GET['keyword'])) { $where[]="(j.title LIKE ? OR j.description LIKE ? OR j.requirements LIKE ?)"; $kw='%'.trim($_GET['keyword']).'%'; array_push($params,$kw,$kw,$kw); }
if (!empty($_GET['location'])) { $where[]="l.name LIKE ?"; $params[]='%'.trim($_GET['location']).'%'; }
if (!empty($_GET['job_type'])) { $where[]="j.job_type=?"; $params[]=trim($_GET['job_type']); }
if (!empty($_GET['category_id'])) { $where[]="j.category_id=?"; $params[]=(int)$_GET['category_id']; }
$sql = "SELECT j.*, e.company_name, c.name AS category_name, l.name AS location_name
        FROM jobs j
        JOIN employers e ON j.employer_id=e.id
        JOIN categories c ON j.category_id=c.id
        JOIN locations l ON j.location_id=l.id
        WHERE " . implode(' AND ', $where) . " ORDER BY j.is_featured DESC, j.id DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($params); $jobs=$stmt->fetchAll();
$cats=$pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5">
 <div class="container">
  <div class="row g-4">
   <div class="col-lg-3">
     <div class="form-section">
      <h5>Filter Jobs</h5>
      <form method="get" class="row g-3">
       <div class="col-12"><label class="form-label">Keyword</label><input name="keyword" value="<?= e($_GET['keyword'] ?? '') ?>" class="form-control"></div>
       <div class="col-12"><label class="form-label">Location</label><input name="location" value="<?= e($_GET['location'] ?? '') ?>" class="form-control"></div>
       <div class="col-12"><label class="form-label">Category</label>
         <select name="category_id" class="form-select">
           <option value="">All Categories</option>
           <?php foreach($cats as $cat): ?>
             <option value="<?= $cat['id'] ?>" <?= ((string)($cat['id'])===($_GET['category_id'] ?? ''))?'selected':'' ?>><?= e($cat['name']) ?></option>
           <?php endforeach; ?>
         </select>
       </div>
       <div class="col-12"><label class="form-label">Job Type</label>
         <select name="job_type" class="form-select">
           <option value="">Any Type</option>
           <?php foreach(['Full Time','Part Time','Contract','Remote','Internship'] as $jt): ?>
             <option <?= (($jt===($_GET['job_type'] ?? ''))?'selected':'') ?>><?= e($jt) ?></option>
           <?php endforeach; ?>
         </select>
       </div>
       <div class="col-12 d-grid"><button class="btn btn-primary">Apply Filters</button></div>
      </form>
     </div>
   </div>
   <div class="col-lg-9">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div><h1 class="section-title mb-1">Available Jobs</h1><p class="text-muted mb-0"><?= count($jobs) ?> jobs found</p></div>
    </div>
    <div class="row g-4">
      <?php foreach($jobs as $job): ?>
      <div class="col-md-6">
        <div class="job-card p-4 h-100">
          <div class="d-flex justify-content-between mb-3">
            <div>
              <span class="badge bg-primary"><?= e($job['category_name']) ?></span>
              <?php if($job['is_featured']): ?><span class="badge bg-success ms-1">Featured</span><?php endif; ?>
            </div>
            <span class="badge-soft"><?= e($job['job_type']) ?></span>
          </div>
          <h5><?= e($job['title']) ?></h5>
          <p class="mb-1"><i class="fa-solid fa-building me-2"></i><?= e($job['company_name']) ?></p>
          <p class="mb-1"><i class="fa-solid fa-location-dot me-2"></i><?= e($job['location_name']) ?></p>
          <p class="mb-1"><i class="fa-solid fa-money-bill-wave me-2"></i>$<?= number_format((float)$job['salary_min']) ?> - $<?= number_format((float)$job['salary_max']) ?></p>
          <p class="text-muted"><?= e(mb_strimwidth(strip_tags($job['description']),0,120,'...')) ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Deadline: <?= e($job['deadline']) ?></small>
            <a href="<?= BASE_URL ?>/pages/job-details.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-primary">View Details</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if(!$jobs): ?><div class="col-12"><div class="alert alert-warning">No jobs found.</div></div><?php endif; ?>
    </div>
   </div>
  </div>
 </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
