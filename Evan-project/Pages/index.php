<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="../Assests/style.css">
</head>
<body>
    <?php include '../includes/Top-menu.php'; ?>
    
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Designing timeless, innovative, and <br> sustainable  architectural Sol<span class="highlight">utions</span> 
        </div>
    </section>

    <!-- Clients Section -->
    <section class="clients-section">
        <div class="container">
            <div class="section-header">
                <h2>Our Clients</h2>
                <p>We've had the pleasure of working with these amazing companies</p>
            </div>
            
            <div class="clients-grid">
                <div class="client-logo">
                    <img src="../Assests/images/clients/client1.png" alt="Client 1">
                </div>
                <div class="client-logo">
                    <img src="../Assests/images/clients/client2.png" alt="Client 2">
                </div>
                <div class="client-logo">
                    <img src="../Assests/images/clients/client3.png" alt="Client 3">
                </div>
                <div class="client-logo">
                    <img src="../Assests/images/clients/client4.png" alt="Client 4">
                </div>
                <div class="client-logo">
                    <img src="../Assests/images/clients/client5.png" alt="Client 5">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->


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
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Offices</button>
            <button class="filter-btn">Residential Building</button>
            <button class="filter-btn">Luxury House</button>
            <button class="filter-btn">Hotels</button>
        </div>

        <!-- Projects Grid -->
        <div class="projects-grid">
            <div class="project-card">
                <img src="../Assests/images/Hero.png" alt="Project 1">
            </div>
            <div class="project-card">
                <img src="../Assests/images/projects/project2.jpg" alt="Project 2">
            </div>
            <div class="project-card">
                <img src="../Assests/images/projects/project3.jpg" alt="Project 3">
            </div>
        </div>
    </div>
</section>




    <script src="../Assests/js/main.js"></script>
    <?php include '../includes/Footer.php'; ?>
    
    <!-- Add your JavaScript files here if needed -->
</body>
</html>