<footer class="footer">
  <div class="footer-container">

    <!-- Logo and Company Name -->
    <div class="footer-logo">
      <img src="../Assests/images/logo 1.png" alt="EVAC Logo1" class="footer-img">
      <div class="footer-title">
        <h2>ECO VISTA</h2>
        <p>ARCHITECTS AND CONSULTANTS</p>
      </div>
    </div>

    <!-- Navigation Links -->
    <ul class="footer-nav">
      <li><a href="/">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#projects">Projects</a></li>
      <li><a href="#testimonials">Testimonials</a></li>
      <li><a href="#contact">Contact Us</a></li>
    </ul>

    <!-- Social Links -->
    <div class="footer-social">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div>
    
  </div>

  <!-- Copyright -->
  <div class="footer-bottom">
    <p>&copy; 2025 <span>ECO VISTA ARCHITECTS AND CONSULTANTS</span> All Rights Reserved, Inc.</p>
  </div>
</footer>
<!-- FontAwesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Logo Section */
.footer-logo {
  display: flex;
  align-items: center;    /* vertical center align */
  justify-content: center; /* center whole block horizontally */
  gap: 12px;              /* space between logo and text */
}

.footer-logo .footer-img {
  height: 55px;  /* adjust size */
  width: auto;
}

.footer-title {
  text-align: left; /* text ko left align rakhen logo ke side pe */
}

.footer-title h2 {
  margin: 0;
  font-size: 22px;
  font-weight: 700;
  color: #d4af37; /* golden color */
  letter-spacing: 1px;
}

.footer-title p {
  margin: 0;
  font-size: 13px;
  color: #555;
  text-transform: uppercase;
  font-weight: 500;
}

.footer {
  background: #fff;
  color: #000;
  padding: 40px 0 0;
  font-family: 'Poppins', sans-serif;
  text-align: center; /* ensures text based elements center */
}

/* Container ko column aur center align */
.footer-container {
  display: flex;
  flex-direction: column;
  align-items: center;  /* sab elements horizontally center */
  gap: 25px;
}

/* Logo Section */
.footer-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
}

.footer-logo .footer-img {
  height: 55px;
  width: auto;
}

.footer-title {
  text-align: left;
}

.footer-title h2 {
  margin: 0;
  font-size: 22px;
  font-weight: 700;
  color: #d4af37;
  letter-spacing: 1px;
}

.footer-title p {
  margin: 0;
  font-size: 13px;
  color: #555;
  text-transform: uppercase;
  font-weight: 500;
}

/* Navigation */
.footer-nav {
  display: flex;
  justify-content: center;  /* center navigation row */
  gap: 30px;
  list-style: none;
  padding: 0;
  margin: 0;
  flex-wrap: wrap;
}

.footer-nav a {
  color: #000;
  text-decoration: none;
  font-size: 15px;
  transition: 0.3s;
}

.footer-nav a:hover {
  color: #d4af37;
}

/* Social Icons */
.footer-social {
  display: flex;
  justify-content: center; /* center icons row */
  gap: 20px;
}

.footer-social a {
  color: #000;
  font-size: 18px;
  transition: 0.3s;
}

.footer-social a:hover {
  color: #d4af37;
}

/* Bottom */
.footer-bottom {
  margin-top: 30px;
  background: #333;
  padding: 15px 10px;
  text-align: center; /* ensure copyright center */
}

.footer-bottom p {
  margin: 0;
  color: #fff;
  font-size: 14px;
}

.footer-bottom span {
  color: #d4af37;
  font-weight: 600;
}
/* Responsive for Mobile */
@media (max-width: 768px) {
  .footer-container {
    align-items: center; /* centers all child elements */
    gap: 20px; /* reduces gap between stacked elements */
  }
  
  .footer-logo {
    flex-direction: column; /* stacks logo and text vertically */
    text-align: center; /* centers the text below logo */
    gap: 8px;
  }
  
  .footer-title {
    text-align: center; /* centers the company name and tagline */
  }
  
  .footer-nav {
    flex-direction: column;
    gap: 15px;
    align-items: center; /* centers nav items */
  }
  
  .footer-social {
    margin-top: 10px; /* adds some space above social icons */
  }
}


/* Responsive */
@media (max-width: 768px) {
  .footer-nav {
    flex-direction: column;
    gap: 15px;
  }
}

</style>
