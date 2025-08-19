<?php
// No need for session_start() here since it's already started in index.php

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    
    include_once 'Db/conn.php';  // Make sure this file doesn't output anything
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO `evac-contactform` (`name`, `email`, `subject`, `message`, `created_at`) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $subject, $message]);
            
            $_SESSION['contact_success'] = "Your message has been sent successfully!";
            echo "<script>window.location.href = window.location.href;</script>";
            exit();
        } catch (PDOException $e) {
            $_SESSION['contact_error'] = "Database error: " . $e->getMessage();
            echo "<script>window.location.href = window.location.href;</script>";
            exit();
        }
    } else {
        $_SESSION['contact_error'] = "All fields are required!";
        echo "<script>window.location.href = window.location.href;</script>";
        exit();
    }
}
?>

<!-- Rest of your contact form HTML -->

<!-- Rest of your Contact-us.php HTML content -->
<!-- Contact Section -->
<section style="background:#f7f8f9; padding:50px 0;">
  <div style="max-width:1100px; margin:auto; display:flex; flex-wrap:wrap; gap:50px; align-items:flex-start;">
    
    <!-- Left Info -->
    <div style="flex:1; min-width:300px; padding:0 20px;">
      <h2>Get in touch with us</h2>
      <p>Ready to bring your vision to life? Contact us today to discuss your project and discover how our expertise can shape spaces that inspire.</p>

      <!-- Contact Info with Circle Icons -->
      <div style="display:flex; align-items:center; margin:15px 0;">
        <div style="width:40px; height:40px; background:#f8c100; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:15px;">
          <i class="fas fa-envelope" style="color:#fff;"></i>
        </div>
        <span>contact@delhiveryshipping.com</span>
      </div>

      <div style="display:flex; align-items:center; margin:15px 0;">
        <div style="width:40px; height:40px; background:#f8c100; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:15px;">
          <i class="fas fa-phone" style="color:#fff;"></i>
        </div>
        <span>(00) 112 365 489</span>
      </div>

      <div style="display:flex; align-items:center; margin:15px 0;">
        <div style="width:40px; height:40px; background:#f8c100; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:15px;">
          <i class="fas fa-clock" style="color:#fff;"></i>
        </div>
        <span>Mon - Fri 9.00 - 18.00<br>Sat & Sun Closed</span>
      </div>

      <!-- Images Row -->
      <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:20px;">
          <img src="Assests/images/all3.jpg" width="200" height="120" style="object-fit:cover;">
        <img src="Assests/images/foot3.jpg" width="200" height="120" style="object-fit:cover;">
        <img src="Assests/images/foot1.png" width="200" height="120" style="object-fit:cover;">
        <img src="Assests/images/foot4.jpg" width="200" height="120" style="object-fit:cover;">
  
      </div>
    </div>

    <!-- Right Form -->
    <div style="flex:1; min-width:300px; padding:0 20px;">
      <form method="POST" style="display:grid; gap:15px;">
        <div style="display:flex; gap:15px;">
          <input type="text" name="name" placeholder="Your name*" required style="flex:1; padding:10px; border:1px solid #ccc;">
          <input type="email" name="email" placeholder="Email*" required style="flex:1; padding:10px; border:1px solid #ccc;">
        </div>
        
        <input type="text" name="subject" placeholder="Subject*" required style="padding:10px; border:1px solid #ccc;">
        
        <textarea name="message" placeholder="Your Message*" rows="5" required style="padding:10px; border:1px solid #ccc;"></textarea>
        
        <button type="submit" style="background:#f8c100; border:none; padding:12px; font-weight:bold; cursor:pointer;">
          Submit Message
        </button>
      </form>
    </div>
  </div>
</section>

<!-- Toast Message -->
<?php if (isset($_SESSION['contact_success']) || isset($_SESSION['contact_error'])): ?>
<div id="toast-message" style="position: fixed; top: 30px; right: 30px; z-index: 9999; min-width: 220px; padding: 16px 30px; color: #fff; font-weight: bold; border-radius: 6px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); font-size: 18px; background: <?php echo isset($_SESSION['contact_success']) ? '#28a745' : '#dc3545'; ?>">
    <?php 
    echo isset($_SESSION['contact_success']) ? $_SESSION['contact_success'] : $_SESSION['contact_error'];
    unset($_SESSION['contact_success']);
    unset($_SESSION['contact_error']);
    ?>
</div>

<script>
// Auto-hide toast message after 3 seconds
document.addEventListener('DOMContentLoaded', function() {
    var toast = document.getElementById('toast-message');
    if (toast) {
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                toast.style.display = 'none';
            }, 400);
        }, 3000);
    }
});
</script>
<?php endif; ?>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">