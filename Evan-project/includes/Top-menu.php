<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- CSS -->
  <link rel="stylesheet" href="style.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<nav>
  <div class="nav-container">

    <!-- Logo -->
    <div class="logo-section">
      <img src="Assests/images/logo 1.png" alt="Logo">
      <div class="logo-text">
        <h1>ECO VISTA</h1>
        <p>ARCHITECTS AND CONSULTANTS</p>
      </div>
    </div>

    <!-- Mobile menu button -->
    <button class="hamburger" aria-label="Menu">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
    </button>

    <!-- Navigation Links -->
    <div class="nav-links">
      <a href="/Evan-project/index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">HOME</a>
      <a href="/Evan-project/Project.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Project.php' ? 'active' : '' ?>">PROJECTS</a>
      <a href="/Evan-project/Teams.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Teams.php' ? 'active' : '' ?>">OUR TEAM</a>
      <a href="/Evan-project/About-us.php" class="<?= basename($_SERVER['PHP_SELF']) == 'About-us.php' ? 'active' : '' ?>">ABOUT US</a>
      <a href="/Evan-project/Services.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Services.php' ? 'active' : '' ?>">SERVICES</a>
    </div>

    <!-- Contact Button -->
    <div class="nav-links">
      <a href="#contact-section" class="contact-link" onclick="event.preventDefault(); document.getElementById('contact-section').scrollIntoView({ behavior: 'smooth' });">
        <button class="btn-yellow" style="background:#f7ce3b; color:black; padding:10px 20px; border:none; font-weight:bold; cursor:pointer;">
          <i class="fa-regular fa-message"style="margin-right:8px;"></i> Contact Us
        </button>
      </a>
    </div>

  </div>
</nav>

</body>
</html>
