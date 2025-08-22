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


</head>
<style>
/* Service Cards Styling */
.services-section {
  padding: 80px 0;
  background: #fff;
  font-family: 'Poppins', sans-serif;
}

.section-header {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 50px;
}

.section-header h2 {
  font-size: 2.5rem;
  color: #1a1a1a;
  margin-bottom: 15px;
  font-weight: 600;
}

.section-header p {
  color: #666;
  font-size: 1.1rem;
  line-height: 1.6;
}

.service-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 25px;
  padding: 0 20px;
  max-width: 1400px;
  margin: 0 auto;
}

.service-card {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  height: 350px;
  background: #fff;
}

.service-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.service-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: all 0.5s ease;
}

.service-card:hover img {
  transform: scale(1.05);
}

.service-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 25px;
  background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
  color: #fff;
  font-family: 'Poppins', sans-serif;
  transition: all 0.4s ease;
}

.service-card:hover .service-overlay {
  padding-bottom: 30px;
  background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
}

.service-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin: 0 0 10px 0;
  color: #fff;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  transition: all 0.3s ease;
}

.service-description {
  font-size: 0.95rem;
  color: rgba(255,255,255,0.9);
  line-height: 1.6;
  margin: 0;
  max-height: 0;
  overflow: hidden;
  transition: all 0.4s ease;
  opacity: 0;
  transform: translateY(10px);
}

.service-card:hover .service-description {
  max-height: 150px;
  opacity: 1;
  transform: translateY(0);
}

/* Responsive adjustments */
@media (max-width: 1200px) {
  .service-grid {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  }
}

@media (max-width: 768px) {
  .services-section {
    padding: 60px 0;
  }
  
  .section-header h2 {
    font-size: 2rem;
  }
  
  .section-header p {
    font-size: 1rem;
  }
  
  .service-grid {
    grid-template-columns: 1fr;
    max-width: 500px;
    margin: 0 auto;
  }
  
  .service-card {
    height: 300px;
  }
}
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

<!-- In your HTML, update each
<body>
<?php include("includes/Top-menu.php"); ?>
  <?php include "arrays.php"; ?>

  <section class="hero-About-us">
    <div class="hero-content">
      <div class="hero-text fade-up">
        <h1>From architectural design to urban <br> planning,  complete solutions for <br> spaces, interiors, and landsca<span class="highlight">pes</span> </h1>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="services-section">
    <div class="container ">
      <!-- Section Header -->
      <div class="section-header ">
        <h2>Our Services</h2>
        <p>
          At EVAC, we provide end-to-end architectural services that turn ideas into functional, sustainable, 
          and inspiring spaces. From design and construction supervision to interiors, landscapes, 
          master planning, and urban development, each service is delivered with innovation, precision, 
          and a commitment to enriching communities.
        </p>
      </div>

      <!-- Services Grid -->
      <div class="service-grid">
        <!-- Service Item 1 -->
        <div class="service-card">
          <img src="Assests/images/all1.jpg" alt="Architectural Design">
          <div class="service-overlay">
            <h3 class="service-title">Architectural Design</h3>
            <p class="service-description">
              Innovative and functional architectural solutions tailored to your vision and needs, 
              combining aesthetics with practicality for spaces that inspire.
            </p>
          </div>
        </div>

        <!-- Service Item 2 -->
        <div class="service-card">
          <img src="Assests/images/construction-site-4020496_1280.jpg" alt="Construction Supervision">
          <div class="service-overlay">
            <h3 class="service-title">Construction Supervision</h3>
            <p class="service-description">
              Expert oversight ensuring your project is built to the highest standards, on time and within budget, 
              with meticulous attention to detail.
            </p>
          </div>
        </div>

        <!-- Service Item 3 -->
        <div class="service-card">
          <img src="Assests/images/interior-1961070_1280.jpg" alt="Interior Design">
          <div class="service-overlay">
            <h3 class="service-title">Interior Design</h3>
            <p class="service-description">
              Creating harmonious and functional interior spaces that reflect your style while optimizing 
              comfort, flow, and aesthetic appeal.
            </p>
          </div>
        </div>

        <!-- Service Item 4 -->
        <div class="service-card">
          <img src="Assests/images/japan-1805865_1280.jpg" alt="Landscape Design">
          <div class="service-overlay">
            <h3 class="service-title">Landscape Design</h3>
            <p class="service-description">
              Transforming outdoor spaces into beautiful, sustainable environments that complement 
              architecture and enhance natural beauty.
            </p>
          </div>
        </div>

        <!-- Service Item 5 -->
        <div class="service-card">
          <img src="Assests/images/agenda-2080420_1280.jpg" alt="Masterplanning">
          <div class="service-overlay">
            <h3 class="service-title">Masterplanning</h3>
            <p class="service-description">
              Comprehensive planning and design of large-scale developments, creating cohesive, 
              sustainable communities with long-term vision.
            </p>
          </div>
        </div>

        <!-- Service Item 6 -->
        <div class="service-card">
          <img src="Assests/images/grand-master-116896_1280.jpg" alt="Urban Planning">
          <div class="service-overlay">
            <h3 class="service-title">Urban Planning</h3>
            <p class="service-description">
              Strategic development of urban environments that balance growth, sustainability, 
              and quality of life for communities.
            </p>
          </div>
        </div>
      </div>
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

