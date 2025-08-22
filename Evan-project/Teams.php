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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

    <section class="hero-Teams">
        <div class="hero-content">
            <div class="hero-teams-text fade-up">
                <h1>Every EVAC project is driven <br> by passionate experts <br> dedicated to redefining <br> architectural in<span class="highlight">novation</span> </h1>
            </div>
        </div>
    </section>

    <!-- Clients Section -->
<section class="team-section">
  <div class="container">
    <div class="section-header">
      <h2>Our Team</h2>
      <p style="margin-top: 7px; font-family: 'Poppins', sans-serif;">
        Behind every successful project at EVAC lies a team of passionate and skilled professionals dedicated to pushing the boundaries of architectural innovation. Our diverse team brings together expertise from various disciplines, united by a shared commitment to excellence and a relentless pursuit of design excellence.
      </p>
    </div>

    <div class="team-cards">
      <!-- Top single card -->
      <div class="team-card">
        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=400&q=80" alt="Team Member" />
        <div class="team-info">
          <h3>Alyssa Trent</h3>
          <p class="role">CEO</p>
          <p class="desc">There are many variations of passages of Lorem Ipsum available</p>
          <div class="socials">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>

      <!-- First row -->
      <div class="team-row">
        <div class="team-card">
          <img src="./Assests/images/testopic.jpg" alt="Team Member" />
          <div class="team-info">
            <h3>Sarah James</h3>
            <p class="role">Project Manager</p>
            <p class="desc">There are many variations of passages of Lorem Ipsum available</p>
            <div class="socials">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>

        <div class="team-card">
          <img src="https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=400&q=80" alt="Team Member" />
          <div class="team-info">
            <h3>Franklin Hale</h3>
            <p class="role">Software Engineer</p>
            <p class="desc">There are many variations of passages of Lorem Ipsum available</p>
            <div class="socials">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Second row -->
      <div class="team-row">
        <div class="team-card">
          <img src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=400&q=80" alt="Team Member" />
          <div class="team-info">
            <h3>Linda Ray</h3>
            <p class="role">Architect</p>
            <p class="desc">There are many variations of passages of Lorem Ipsum available</p>
            <div class="socials">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>

        <div class="team-card">
          <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=400&q=80" alt="Team Member" />
          <div class="team-info">
            <h3>Michael Scott</h3>
            <p class="role">Designer</p>
            <p class="desc">There are many variations of passages of Lorem Ipsum available</p>
            <div class="socials">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div><!-- END .team-cards -->
  </div><!-- END .container -->
</section>

<!-- Projects Section -->
   
<!-- View All Button -->



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

