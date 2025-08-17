<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-about">
                <div class="footer-logo">
                    <img src="/Assests/images/Logo.png" alt="EVAC Architects Logo" class="footer-logo-img">
                    <h3>EVAC Architects</h3>
                </div>
                <p>Designing timeless, innovative, and sustainable architectural solutions that inspire and transform spaces.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="footer-services">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Architectural Design</a></li>
                    <li><a href="#">Interior Design</a></li>
                    <li><a href="#">Urban Planning</a></li>
                    <li><a href="#">Renovation</a></li>
                    <li><a href="#">3D Visualization</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contact Us</h4>
                <ul class="contact-info">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Design Street, Creative City, 10001</li>
                    <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> info@evacarchitects.com</li>
                    <li><i class="fas fa-clock"></i> Mon - Fri: 9:00 AM - 6:00 PM</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> EVAC Architects. All Rights Reserved.</p>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <span>|</span>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<style>
/* Footer Styles */
.site-footer {
    background-color: #1a1a1a;
    color: #fff;
    padding: 70px 0 0;
    font-family: 'Poppins', sans-serif;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 50px;
}

.footer-about {
    padding-right: 20px;
}

.footer-logo {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.footer-logo-img {
    height: 40px;
    margin-right: 15px;
}

.footer-logo h3 {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    color: #fff;
}

.footer-about p {
    color: #b3b3b3;
    line-height: 1.6;
    margin-bottom: 25px;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #fff;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: #e5b700;
    transform: translateY(-3px);
}

.footer-links h4,
.footer-services h4,
.footer-contact h4 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}

.footer-links h4::after,
.footer-services h4::after,
.footer-contact h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 40px;
    height: 2px;
    background: #e5b700;
}

.footer-links ul,
.footer-services ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li,
.footer-services li {
    margin-bottom: 12px;
}

.footer-links a,
.footer-services a {
    color: #b3b3b3;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-links a:hover,
.footer-services a:hover {
    color: #e5b700;
    transform: translateX(5px);
}

.contact-info {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact-info li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
    color: #b3b3b3;
    line-height: 1.5;
}

.contact-info i {
    color: #e5b700;
    margin-right: 15px;
    margin-top: 4px;
    min-width: 20px;
    text-align: center;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 25px 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}

.footer-bottom p {
    margin: 0;
    color: #b3b3b3;
    font-size: 14px;
}

.footer-legal {
    display: flex;
    align-items: center;
    gap: 15px;
}

.footer-legal a {
    color: #b3b3b3;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.footer-legal a:hover {
    color: #e5b700;
}

.footer-legal span {
    color: #4d4d4d;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .footer-about {
        padding-right: 0;
    }

    .footer-bottom {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .footer-legal {
        margin-top: 10px;
    }
}

@media (max-width: 480px) {
    .footer-links,
    .footer-services,
    .footer-contact {
        text-align: center;
    }

    .footer-links h4::after,
    .footer-services h4::after,
    .footer-contact h4::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .social-links {
        justify-content: center;
    }
}
</style>