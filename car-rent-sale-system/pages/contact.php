<?php
 $pageTitle='Contact Us'; 
 require_once __DIR__ . '/../includes/header.php';
  if($_SERVER['REQUEST_METHOD']==='POST')
  { $name=trim($_POST['name']);
   $email=trim($_POST['email']);
    $subject=trim($_POST['subject']);
     $message=trim($_POST['message']);
      if($name&&$email&&$message)
      { $stmt=db()->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)'); 
      $stmt->execute([$name,$email,$subject,$message]); 
      set_flash('success','Message sent successfully.');
       redirect('/car-rent-sale-system/pages/contact.php'); }} 
       ?>
       <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="form-box">
                    <h1 class="section-title">Contact Us</h1>
                    <form method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input class="form-control" name="name" placeholder="Your Name" required></div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required></div>
                                    <div class="col-12"><input class="form-control" name="subject" placeholder="Subject"></div>
                                    <div class="col-12"><textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea></div>
                                    <div class="col-12"><button class="btn btn-primary">Send Message</button></div></div></form></div></div><div class="col-lg-5">
                                        <div class="form-box h-100"><h4>Office Information</h4><p><i class="fa-solid fa-location-dot me-2"></i> Bosaso, Somalia</p>
                                        <p><i class="fa-solid fa-phone me-2"></i> +252 0907798585</p><p><i class="fa-solid fa-envelope me-2"></i> JIBO-Car Rental-info@gmail.com</p></div></div></div></div>
                                        <?php 
                                        require_once __DIR__ . '/../includes/footer.php'; ?>
