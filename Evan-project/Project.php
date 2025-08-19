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
<body>
<?php include("includes/Top-menu.php"); ?>
  <?php include "arrays.php"; ?>

    <section class="hero-project">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Our Projects are crafted with <br> innovation, sustainability, and <br> functionality at its <span class="highlight">core</span> </h1>
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
            <h2 >Our Projects</h2>
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
    $limit = 6; // Pehle 6 projects hi dikhayenge
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
<div style="text-align:center; margin-top:20px;">
    <button id="viewAllBtn" style="background:#f7ce3b; color:black; padding:10px 20px; border:none; font-weight:bold; cursor:pointer;">
        View All
    </button>
</div>



</section>
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
<?php include 'includes/Contact-us.php'; ?>

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

