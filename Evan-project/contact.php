<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - ECO VISTA ARCHITECTS AND CONSULTANTS</title>
  
  <!-- CSS -->
  <link rel="stylesheet" href="Assests/main.css">
  <link rel="stylesheet" href="Assests/style.css">
  
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <style>
    /* Add any additional styles for the contact page here */
    .contact-page {
      padding: 80px 0;
      background: #f7f8f9;
    }
    .contact-container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 20px;
    }
  </style>
</head>
<body>
  <?php include("includes/Top-menu.php"); ?>
  
  <main class="contact-page">
    <div class="contact-container">
      <?php include("includes/Contact-us.php"); ?>
    </div>
  </main>
  
  <?php include("includes/Footer.php"); ?>
  
  <!-- JS -->
  <script src="Assests/js/main.js"></script>
  
  <script>
    // Highlight the active menu item
    document.addEventListener('DOMContentLoaded', function() {
      // Remove active class from all menu items
      document.querySelectorAll('.nav-links a').forEach(link => {
        link.classList.remove('active');
      });
      
      // Add active class to current page
      const currentPage = window.location.pathname.split('/').pop();
      document.querySelectorAll('.nav-links a').forEach(link => {
        if (link.getAttribute('href').includes(currentPage)) {
          link.classList.add('active');
        }
      });
    });
  </script>
</body>
</html>
