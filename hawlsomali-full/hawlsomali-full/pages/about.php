<?php require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php'; $pageTitle='About'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php'; ?>
<section class="py-5 bg-white">
<div class="container">
 <div class="row g-5 align-items-center">
  <div class="col-lg-6">
   <span class="badge bg-primary mb-3">About HawlSomali</span>
   <h1 class="section-title">Connecting Somali talent with real opportunities</h1>
   <p>HawlSomali.com is a job portal built for Somalia. It helps employers publish open positions and helps job seekers apply online using a clean, professional platform.</p>
   <p>Our goal is to make hiring simple, transparent, and accessible for businesses, NGOs, schools, health facilities, government offices, and startups.</p>
   <ul>
    <li>Job search by keyword, location, and type</li>
    <li>Employer dashboards for posting and applicant review</li>
    <li>Seeker profiles with CV upload and saved jobs</li>
    <li>Admin moderation for better job quality</li>
   </ul>
  </div>
  <div class="col-lg-6">
    <div class="content-card p-4">
      <h4>Why choose us?</h4>
      <div class="row g-3 mt-1">
        <div class="col-6"><div class="p-3 rounded bg-light h-100"><strong>Trusted Jobs</strong><p class="small mb-0 text-muted">Approval workflow for public listings.</p></div></div>
        <div class="col-6"><div class="p-3 rounded bg-light h-100"><strong>Somali Focus</strong><p class="small mb-0 text-muted">Built around cities and employers in Somalia.</p></div></div>
        <div class="col-6"><div class="p-3 rounded bg-light h-100"><strong>Easy Use</strong><p class="small mb-0 text-muted">Simple dashboard for every role.</p></div></div>
        <div class="col-6"><div class="p-3 rounded bg-light h-100"><strong>Scalable</strong><p class="small mb-0 text-muted">Ready for more modules later.</p></div></div>
      </div>
    </div>
  </div>
 </div>
</div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
