<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Website</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  
  <!-- CSS -->
  <link rel="stylesheet" href="Assests/style.css">
</head>
<body>
  
  <!-- Top Menu -->
  <?php include("includes/Top-menu.php"); ?>
  <?php include "arrays.php"; ?>


  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <div class="hero-text">
        <h1>
          Designing timeless, innovative, and <br>
          sustainable architectural Sol<span class="highlight">utions</span>
        </h1>
      </div>
    </div>
  </section>

  <!-- Clients Section -->
  <section class="clients-section">
    <div class="container">
      <div class="section-header">
        <h2>Our Clients</h2>
        <p>We've had the pleasure of working with these amazing companies and organizations</p>
      </div>

      <div class="clients-grid">
        <div class="client-logo">
          <img src="Assests/images/pic 1.png" alt="Client 1">
        </div>
        <div class="client-logo">
          <img src="Assests/images/pic 2.png" alt="Client 2">
        </div>
        <div class="client-logo">
          <img src="Assests/images/pic 3.jpg" alt="Google">
        </div>
        <div class="client-logo">
          <img src="Assests/images/pic 4.png" alt="Nike">
        </div>
      </div>
    </div>
  </section>

  <!-- Projects Section -->
  <section class="projects-section">
    <div class="container">
      <div class="section-header">
        <h2>Our Projects</h2>
        <p>
          At EVAC, we believe in transforming architectural visions into tangible realities that enrich
          communities and inspire generations. Our portfolio showcases a diverse range of projects,
          each meticulously crafted with innovation, sustainability, and functionality at its core.
        </p>
      </div>

      <!-- Filter Buttons -->
      <div class="projects-filter">
        <button class="filter-btn active" data-filter="All">All</button>
        <button class="filter-btn" data-filter="Offices">Offices</button>
        <button class="filter-btn" data-filter="Residential Building">Residential Building</button>
        <button class="filter-btn" data-filter="Luxury House">Luxury House</button>
        <button class="filter-btn" data-filter="Hotels">Hotels</button>
      </div>

      <!-- Projects Grid -->
      <div class="projects-grid" id="projectsGrid">
        <?php 
        $limit = 6; 
        $count = 0;
        foreach ($projects as $project): 
          $count++;
          $hiddenClass = $count > $limit ? 'hidden-project' : '';
        ?>
        <div class="project-wrapper <?= $hiddenClass; ?>">
          <!-- Card with Image -->
          <div class="project-card <?= $project['size'] ?? 'small-card'; ?>" data-category="<?= $project['category']; ?>">
            <div class="image-wrapper">
              <img src="<?= $project['image']; ?>" alt="<?= $project['title']; ?>">
              <div class="overlay-title">
                <?= $project['title']; ?>
              </div>
            </div>
          </div>

          <!-- Info OUTSIDE the card -->
          <div class="info">
            <p>
              ARCHITECT: <?= $project['architect']; ?><br>
              AREA: <?= $project['area']; ?><br>
              CLIENT: <?= $project['client']; ?><br>
              PHOTOGRAPHS: <?= $project['photographs']; ?>
            </p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <!-- View All Button -->
      <div class="center-btn">
        <button id="viewAllBtn" class="btn-yellow">
          View All
        </button>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials-section">
    <div class="testimonials-header">
      <h2>Testimonials</h2>
      <p>Clients praise our architecture firm for creative designs, precise execution, and spaces that inspire lasting impressions.</p>
    </div>
    <div class="testimonial-slider">

      <!-- Testimonial 1 -->
      <div class="testimonial active">
        <div class="testimonial-content">
          <img src="Assests/images/testopic.jpg" class="testimonial-img" alt="Client 1">
          <div class="testimonial-text">
            <span class="quote">“</span>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <h4>Ali Khan</h4>
            <span>CEO, Company</span>
          </div>
        </div>
      </div>

      <!-- Testimonial 2 -->
      <div class="testimonial">
        <div class="testimonial-content">
          <img src="Assests/images/pic 2.png" class="testimonial-img" alt="Client 2">
          <div class="testimonial-text">
            <span class="quote">“</span>
            <p>Vestibulum ante ipsum primis in faucibus orci luctus.</p>
            <h4>Sara Ahmed</h4>
            <span>Designer</span>
          </div>
        </div>
      </div>

      <!-- Testimonial 3 -->
      <div class="testimonial">
        <div class="testimonial-content">
          <img src="Assess/images/foot1.png" class="testimonial-img" alt="Client 3">
          <div class="testimonial-text">
            <span class="quote">“</span>
            <p>Donec sit amet eros. Lorem ipsum dolor sit amet.</p>
            <h4>Usman Khan</h4>
            <span>Developer</span>
          </div>
        </div>
      </div>

    </div>

    <!-- Dots -->
    <div class="testimonial-dots">
      <span class="dot active" onclick="showTestimonial(0)"></span>
      <span class="dot" onclick="showTestimonial(1)"></span>
      <span class="dot" onclick="showTestimonial(2)"></span>
    </div>
  </section>

  <!-- Toast Messages -->
  <?php if (isset($_SESSION['contact_success'])): ?>
    <div id="toast-message" class="toast-success">Message sent successfully!</div>
    <?php unset($_SESSION['contact_success']); ?>
  <?php endif; ?>
  <?php if (isset($_SESSION['contact_error'])): ?>
    <div id="toast-message" class="toast-error"><?= $_SESSION['contact_error'] ?></div>
    <?php unset($_SESSION['contact_error']); ?>
  <?php endif; ?>

  <!-- Contact + Footer -->
  <?php include("includes/Contact-us.php"); ?>
  <?php include("includes/Footer.php"); ?>

  <!-- JS -->
  <script src="Assests/js/main.js"></script>
  <script>
    // Filtering functionality
    const filterButtons = document.querySelectorAll(".filter-btn");
    const projectWrappers = document.querySelectorAll(".project-wrapper");

    filterButtons.forEach(button => {
      button.addEventListener("click", () => {
        filterButtons.forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");

        const filter = button.getAttribute("data-filter");

        projectWrappers.forEach(wrapper => {
          const category = wrapper.querySelector(".project-card").getAttribute("data-category");
          wrapper.style.display = (filter === "All" || category === filter) ? "block" : "none";
        });
      });
    });

    // Testimonials slider
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

    setInterval(() => {
      currentIndex = (currentIndex + 1) % testimonials.length;
      showTestimonial(currentIndex);
    }, 5000);

    // View All Projects
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("viewAllBtn").addEventListener("click", function() {
        document.querySelectorAll(".hidden-project").forEach(el => {
          el.classList.remove("hidden-project");
        });
        document.querySelector('.projects-section').scrollIntoView({behavior: 'smooth'});
      });
    });

    // Toast message
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
