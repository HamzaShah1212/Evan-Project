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

</head>
<style>
  /* General animation class */
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

/* Highlight animation */


@keyframes underline {
  to {
    width: 100%;
  }
}

</style>
<body>
<?php include("includes/Top-menu.php"); ?>
  <?php include "arrays.php"; ?>

  <section class="hero-project">
  <div class="hero-content">
    <div class="hero-text fade-up">
      <h1>
        Our Projects are crafted with <br>
        innovation, sustainability, and <br>
        functionality at its c<span class="highlight">ore</span>
      </h1>
    </div>
  </div>
</section>

    <!-- Clients Section -->
    
    <!-- Projects Section -->
    <section class="projects-section">
    <div class="container">
        <div class="section-header">
            <h2 >Our Projects</h2>
            <p style="margin-top: 7px;   font-family: 'Poppins', sans-serif;">
                At EVAC, we believe in transforming architectural visions into tangible realities that enrich <br>
                communities and inspire generations. Our portfolio showcases a diverse range of projects, <br>
                each meticulously crafted with innovation, sustainability, and functionality at its core.
            </p>
        </div>

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
        foreach ($projects as $index => $project): 
          $count++;
          $hiddenClass = $count > $limit ? 'hidden-project' : '';
        ?>
        <div class="project-wrapper <?= $hiddenClass; ?>" data-index="<?= $index; ?>">
          <!-- Card with Image -->
          <div class="project-card <?= $project['size'] ?? 'small-card'; ?>" data-category="<?= $project['category']; ?>">
            <div class="image-wrapper">
              <!-- First image is visible, others are hidden initially -->
              <?php foreach ($project['images'] as $imgIndex => $image): ?>
                <img src="<?= $image; ?>" alt="<?= $project['title']; ?>" 
                     class="project-image <?= $imgIndex === 0 ? 'active' : ''; ?>" 
                     data-index="<?= $imgIndex; ?>">
              <?php endforeach; ?>
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
      <!-- <div class="center-btn">
        <button id="viewAllBtn" class="btn-yellow" style="background:#f7ce3b; color:black; padding:10px 20px; border:none; font-weight:bold; cursor:pointer;">
          View All
        </button>
      </div>
    </div> -->
  </section>

  <!-- Testimonials Section -->
  
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
  <div id="contact-section">
    <?php include("includes/Contact-us.php"); ?>
  </div>
  <?php include("includes/Footer.php"); ?>
  
  <style>
    html {
      scroll-behavior: smooth;
    }
    
    /* Styles for image slider */
    .image-wrapper {
      position: relative;
      overflow: hidden;
    }
    
    .project-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }
    
    .project-image.active {
      opacity: 1;
      position: relative;
    }
  </style>

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

    // Project image slider functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Get all project wrappers
      const projectWrappers = document.querySelectorAll('.project-wrapper');
      
      // Function to rotate images for a specific project
      function rotateProjectImages(wrapper) {
        const images = wrapper.querySelectorAll('.project-image');
        if (images.length <= 1) return; // No need to rotate if only one image
        
        // Find the currently active image
        let activeIndex = -1;
        images.forEach((img, index) => {
          if (img.classList.contains('active')) {
            activeIndex = index;
          }
        });
        
        // Calculate next image index
        const nextIndex = (activeIndex + 1) % images.length;
        
        // Fade out current image, then fade in next image
        images[activeIndex].classList.remove('active');
        images[nextIndex].classList.add('active');
      }
      
      // Set up interval for each project
      projectWrappers.forEach(wrapper => {
        setInterval(() => {
          // Only rotate if the project is visible
          if (wrapper.offsetParent !== null) {
            rotateProjectImages(wrapper);
          }
        }, 5000); // Rotate every 5 seconds
      });
    });
  </script>
</body>
</html>