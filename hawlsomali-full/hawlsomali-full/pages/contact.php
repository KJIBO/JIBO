<?php
require_once __DIR__ . '/../config/db.php'; require_once __DIR__ . '/../includes/functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $stmt=$pdo->prepare("INSERT INTO contact_messages(name,email,subject,message) VALUES (?,?,?,?)");
 $stmt->execute([trim($_POST['name']),trim($_POST['email']),trim($_POST['subject']),trim($_POST['message'])]);
 flash('success','Your message has been sent.');
 redirect(BASE_URL . '/pages/contact.php');
}
$pageTitle='Contact'; include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="py-5">
 <div class="container">
  <div class="row g-4">
   <div class="col-lg-5">
    <div class="form-section h-100">
      <h2 class="section-title">Contact Us</h2>
      <p>Send a message to the HawlSomali team.</p>
      <p><strong>Email:</strong> info@hawlsomali.com</p>
      <p><strong>Phone:</strong> +252 61 0000000</p>
      <p><strong>Office:</strong> Mogadishu, Somalia</p>
    </div>
   </div>
   <div class="col-lg-7">
    <div class="form-section">
      <form method="post" class="row g-3">
        <div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Subject</label><input name="subject" class="form-control" required></div>
        <div class="col-12"><label class="form-label">Message</label><textarea name="message" class="form-control" rows="6" required></textarea></div>
        <div class="col-12"><button class="btn btn-primary">Send Message</button></div>
      </form>
    </div>
   </div>
  </div>
 </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
