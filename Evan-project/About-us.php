<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Assests/style.css">

  <style>
    .fade-up {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 1.2s ease-out forwards;
}

/* Keyframes */
@keyframes fadeUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
  </style>
</head>
<body>
<?php include("includes/Top-menu.php"); ?>
  <?php include "arrays.php"; ?>

    <section class="hero-About-us">
        <div class="hero-content">
            <div class="hero-text fade-up">
                <h1>EVAC transforms visions into inspiring <br> spaces that reflect dreams, values, and <br> communi<span class="highlight">ties</span> </h1>
            </div>
        </div>
    </section>

    <!-- Clients Section -->
<section class="aboutus-section">
  <div class="aboutus-container">
    <div class="aboutus-header">
      <h2>About <span class="highlights">Us</span></h2>
      <p>
        At EVAC, we believe that architecture is more than just structures; it's a reflection of our collective aspirations, values, and dreams. Founded by 
        <strong>Ar. Jungiaan Dashti</strong>, an accomplished architect with 06 years of experience in the industry, our firm is dedicated to transforming spaces into inspiring environments that enrich lives and communities.
      </p>
    </div>
  </div>
</section>

<section class="aboutus-section">
  <div class="aboutus-container">
    <div class="aboutus-header">
      <h2>Our <span class="highlights">Mission</span></h2>
    </div>
    <div class="aboutus-mission-box">
      Driven by a passion for design excellence and a commitment to client satisfaction, our mission is simple yet profound: to create timeless, innovative, and sustainable architectural solutions that exceed expectations. We strive to forge meaningful connections with our clients, understanding their unique needs, aspirations, and challenges to deliver personalized designs that resonate deeply.
    </div>
  </div>
</section>

<section class="aboutus-section">
  <div class="aboutus-container">
    <div class="aboutus-header">
      <h2>Our <span class="highlights">Vision</span></h2>
    </div>
    <div class="aboutus-vision-box">
      At EVAC our vision is to redefine the boundaries of architectural excellence and innovation, shaping environments that inspire, uplift, and endure for generations to come. We envision a future where design transcends mere functionality, becoming a catalyst for social progress, environmental stewardship, and human well-being. Through a relentless pursuit of creativity, collaboration, and sustainability, we aim to leave a lasting legacy of iconic spaces that enrich lives, celebrate diversity, and harmonize with the natural world. Our vision is not just to build structures, but to create enduring landmarks that reflect the aspirations and values of the communities we serve, inspiring positive change and leaving an indelible mark on the world of architecture.
    </div>
  </div>
</section>


    <!-- Projects Section -->
    <!-- Testimonials Section -->

<!-- Testimonials Section -->

<?php if (isset($_SESSION['contact_success'])): ?>
  <div id="toast-message">Message sent successfully!</div>
  <?php unset($_SESSION['contact_success']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['contact_error'])): ?>
  <div id="toast-message" style="background:#dc3545;"><?= $_SESSION['contact_error'] ?></div>
  <?php unset($_SESSION['contact_error']); ?>
<?php endif; ?>
<div id="contact-section">
<?php include 'includes/Contact-us.php'; ?>
</div>
    <script src="Assests/js/main.js"></script>
    <?php include 'includes/Footer.php'; ?>

<script>
    // Filtering functionality
    const filterButtons = document.querySelectorAll(".filter-btn");
    const projectWrappers = document.querySelectorAll(".project-wrapper");

    filterButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Active button highlight
            filterButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");

            const filter = button.getAttribute("data-filter");

            projectWrappers.forEach(wrapper => {
                const category = wrapper.querySelector(".project-card").getAttribute("data-category");
                if (filter === "All" || category === filter) {
                    wrapper.style.display = "block";
                } else {
                    wrapper.style.display = "none";
                }
            });
        });
    });
</script>

<script>
  const testimonials = document.querySelectorAll(".testimonial");
  const dots = document.querySelectorAll(".dot");

  let currentIndex = 0;

  function showTestimonial(index) {
    testimonials.forEach((testimonial, i) => {
      testimonial.classList.remove("active");
      dots[i].classList.remove("active");
    });
    testimonials[index].classList.add("active");
    dots[index].classList.add("active");
  }

  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      currentIndex = index;
      showTestimonial(currentIndex);
    });
  });

  // Auto slide every 5 sec
  setInterval(() => {
    currentIndex = (currentIndex + 1) % testimonials.length;
    showTestimonial(currentIndex);
  }, 5000);
</script>

    
<script>
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("viewAllBtn").addEventListener("click", function() {
    document.querySelectorAll(".hidden-project").forEach(el => {
      el.classList.remove("hidden-project"); // remove the class to show all
    });
    // Optional: scroll to projects section for better UX
    document.querySelector('.projects-section').scrollIntoView({behavior: 'smooth'});
  });
});
</script>

<style>
.hidden-project {
    display: none; /* shuru mein hidden */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var toast = document.getElementById('toast-message');
  if (toast) {
    toast.style.display = 'block';
    toast.style.opacity = '1';
    setTimeout(function() {
      toast.style.opacity = '0';
      setTimeout(function() {
        toast.style.display = 'none';
      }, 400);
    }, 3000);
  }
});
</script>

</body>
</html>

