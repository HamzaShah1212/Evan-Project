<?php
include '../Db/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO `evac-contactform` 
            (`name`, `email`, `subject`, `message`, `created_at`) 
            VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $subject, $message]);

        // echo "<p style='color:green'>Message submitted successfully!</p>";
    } else {
        echo "<p style='color:red'>All fields are required!</p>";
    }
}
?>

<!-- Contact Form Section -->
<section style="background:#f7f8f9; padding:50px 0;">
  <div style="max-width:1100px; margin:auto; display:flex; flex-wrap:wrap; gap:50px; align-items:flex-start;">
    
    <!-- Left Info -->
    <div style="flex:1; min-width:300px; padding:0 20px;">
      <h2>Get in touch with us</h2>
      <p>Ready to bring your vision to life? Contact us today to discuss your project.</p>

      <p><b>Email:</b> contact@delhiveryshipping.com</p>
      <p><b>Call:</b> (00) 112 365 489</p>
      <p><b>Hours:</b> Mon - Fri (9.00 - 18.00)</p>

      <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:15px;">
        <img src="../Assests/images/sadfas (5).png" width="120">
        <img src="https://cdn.pixabay.com/photo/2015/04/20/13/25/mountains-731134_960_720.jpg" width="120">
        <img src="https://cdn.pixabay.com/photo/2017/05/08/13/15/aircraft-2290644_960_720.jpg" width="120">
        <img src="https://cdn.pixabay.com/photo/2016/11/29/02/24/alaska-1867223_960_720.jpg" width="120">
      </div>
    </div>

    <!-- Right Form -->
    <div style="flex:1; min-width:300px; padding:0 20px;">
      <form id="contactForm" method="POST" style="display:grid; gap:15px;">
        <input type="text" name="name" placeholder="Your Name*" required style="padding:10px; border:1px solid #ccc;">
        <input type="email" id="email" name="email" placeholder="Email*" required style="padding:10px; border:1px solid #ccc;">
        <input type="text" name="subject" placeholder="Subject*" required style="padding:10px; border:1px solid #ccc;">
        <textarea name="message" placeholder="Your Message*" rows="5" required style="padding:10px; border:1px solid #ccc;"></textarea>
        <button type="submit" style="background:#f8c100; border:none; padding:12px; font-weight:bold; cursor:pointer;">
          Submit Message
        </button>
      </form>
    </div>
  </div>
</section>

<!-- JS Email Validation -->
<script>
  document.getElementById("contactForm").addEventListener("submit", function(e) {
    const emailField = document.getElementById("email");
    const email = emailField.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Reset previous styles
    emailField.style.border = "1px solid #ccc";

    if (!emailPattern.test(email)) {
      e.preventDefault(); // stop form submission
      emailField.style.border = "2px solid red";
      alert("Please enter a valid email address!");
      emailField.focus();
    }
  });
</script>

<style>
  @media (max-width: 768px) {
    section > div {
      flex-direction: column;
      gap: 30px;
    }
    
    section > div > div {
      width: 100%;
      padding: 0 15px;
    }
    
    .contact-images {
      justify-content: center;
    }
  }
</style>