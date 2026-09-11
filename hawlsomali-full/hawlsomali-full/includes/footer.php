<footer class="footer-section mt-5">
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-lg-4">
        <h4>HawlSomali.com</h4>
        <p class="mb-0">A modern Somali jobs platform connecting employers and job seekers with clean tools for posting, searching, and applying.</p>
      </div>
      <div class="col-lg-2">
        <h6>Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="<?= BASE_URL ?>/pages/jobs.php">Jobs</a></li>
          <li><a href="<?= BASE_URL ?>/pages/companies.php">Companies</a></li>
          <li><a href="<?= BASE_URL ?>/pages/about.php">About</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>For Employers</h6>
        <ul class="list-unstyled">
          <li><a href="<?= BASE_URL ?>/auth/register-employer.php">Create Company Account</a></li>
          <li><a href="<?= BASE_URL ?>/auth/login.php">Employer Login</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6>For Job Seekers</h6>
        <ul class="list-unstyled">
          <li><a href="<?= BASE_URL ?>/auth/register-seeker.php">Create Job Seeker Account</a></li>
          <li><a href="<?= BASE_URL ?>/auth/login.php">Seeker Login</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-bottom py-3 text-center">
    <div class="container">© <?= date('Y') ?> HawlSomali. All rights reserved.</div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
