<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="../Assests/style.css">
</head>
<body>
    <?php include '../includes/Top-menu.php'; ?>
<?php include("arrays.php"); ?>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Designing timeless, innovative, and <br> sustainable architectural Sol<span class="highlight">utions</span></h1>
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
                    <img src="../Assests/images/Hero.png" alt="Client 1">
                </div>
                <div class="client-logo">
                    <img src="../Assests/images/sadfas (5).png" alt="Client 2">
                </div>
                <div class="client-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/2560px-Google_2015_logo.svg.png" alt="Google">
                </div>
                <div class="client-logo">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Nike_Logo.svg/2560px-Nike_Logo.svg.png" alt="Nike">
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <!-- Projects Section -->
<section class="projects-section">
    <div class="container">
        <div class="section-header">
            <h2 class="highlight-heading">Our Projects</h2>
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
        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <div class="project-card <?= $project['size'] ?? 'small-card'; ?>" data-category="<?= $project['category']; ?>">
                    <img src="<?= $project['image']; ?>" alt="<?= $project['title']; ?>">
                    <div class="info">
                        <h3><?= $project['title']; ?></h3>
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
    </div>
</section>
<!-- Testimonials Section -->
<!-- Testimonials Section -->
<section class="testimonials-section">
  <div class="container">
    <div class="section-header">
      <h2>Testimonials</h2>
      <p>
        Clients praise our architecture firm for creative designs, precise execution, 
        and spaces that inspire lasting impressions.
      </p>
    </div>

    <div class="testimonial-slider">
      <!-- Slide 1 -->
      <div class="testimonial active">
        <div class="testimonial-content">
          <img src="../Assests/images/image.png" alt="Client 1" class="testimonial-img">
          <div class="testimonial-text">
            <span class="quote">“</span>
            <p>
              Lorem ipsum dolor sit amet consectetur. Id purus placerat scelerisque 
              ullamcorper habitasse egestas. Nunc gravida egestas suspendisse volutpat 
              suscipit suspendisse faucibus amet convallis.
            </p>
            <span class="quote">”</span>
            <h4>Michael Smith</h4>
            <span>CEO</span>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="testimonial">
        <div class="testimonial-content">
          <img src="../Assests/images/image2.png" alt="Client 2" class="testimonial-img">
          <div class="testimonial-text">
            <span class="quote">“</span>
            <p>
              Great experience! They understood our vision and delivered beyond expectations.
            </p>
            <span class="quote">”</span>
            <h4>Sarah Johnson</h4>
            <span>Founder</span>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="testimonial">
        <div class="testimonial-content">
          <img src="../Assests/images/image3.png" alt="Client 3" class="testimonial-img">
          <div class="testimonial-text">
            <span class="quote">“</span>
            <p>
              Professional, creative, and reliable. Highly recommend for any architectural needs.
            </p>
            <span class="quote">”</span>
            <h4>David Lee</h4>
            <span>Entrepreneur</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Slider Dots -->
    <div class="testimonial-dots">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </div>
</section>



    <script src="../Assests/js/main.js"></script>
    <?php include '../includes/Footer.php'; ?>

<script>
    // Filtering functionality
    const filterButtons = document.querySelectorAll(".filter-btn");
    const projectCards = document.querySelectorAll(".project-card");

    filterButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Active button highlight
            filterButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");

            const filter = button.getAttribute("data-filter");

            projectCards.forEach(card => {
                if (filter === "All" || card.getAttribute("data-category") === filter) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
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

    
</body>
</html>