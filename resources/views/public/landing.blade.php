<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RobtheLabStudios | Visuals That Speak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- NAVIGATION -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="{{ asset('images/rtlzoom.jpg') }}" alt="RobtheLabStudios">
                <span>RobtheLabStudios</span>
            </div>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#portfolio">Portfolio</a>
                <a href="#contact">Contact</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <video class="hero-background" autoplay muted loop playsinline>
            <source src="{{ asset('videos/robvideo.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content">
            <div class="hero-logo">
                <img src="{{ asset('images/rtllogo.png') }}" alt="RobtheLabStudios Logo">
            </div>
            <h1 class="hero-title">
                <span class="line">Rob</span>
                <span class="line">the</span>
                <span class="line">Lab</span>
                <span class="line highlight">Studios</span>
            </h1>
            <p class="hero-subtitle">Visuals that speak louder than words.</p>
            <div class="hero-actions">
                <a href="{{ route('booking.create') }}" class="cta-btn primary">
                    <i class="fas fa-camera"></i>
                    Book a Shoot
                </a>
                <a href="#portfolio" class="cta-btn secondary">
                    <i class="fas fa-play"></i>
                    View Our Work
                </a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="about" id="about">
        <div class="container">
            <div class="section-header">
                <h2>About Us</h2>
                <div class="section-divider"></div>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p class="lead">
                        RobtheLabStudios is a creative video production studio delivering
                        cinematic visuals, brand stories, corporate films, and unforgettable moments.
                    </p>
                    <p>
                        We collaborate closely with clients to turn ideas into powerful visuals that 
                        resonate with audiences and drive results. Our team combines technical expertise 
                        with creative vision to produce content that stands out.
                    </p>
                </div>
                <div class="about-stats">
                    <div class="stat">
                        <h3>500+</h3>
                        <p>Projects Completed</p>
                    </div>
                    <div class="stat">
                        <h3>50+</h3>
                        <p>Happy Clients</p>
                    </div>
                    <div class="stat">
                        <h3>5+</h3>
                        <p>Years Experience</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-header">
                <h2>Our Services</h2>
                <div class="section-divider"></div>
                <p>We specialize in creating visual content that tells your story</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Wedding Films</h3>
                    <p>Cinematic wedding videography that captures your special moments with artistic flair and emotional depth.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-camera-retro"></i>
                    </div>
                    <h3>Product Shoots</h3>
                    <p>Professional product photography and videography that showcases your products in their best light.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Corporate Videos</h3>
                    <p>Engaging corporate content that communicates your brand message and company culture effectively.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Promotional Ads</h3>
                    <p>Creative promotional content designed to captivate audiences and drive engagement with your brand.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PORTFOLIO SECTION -->
    <section class="portfolio" id="portfolio">
        <div class="container">
            <div class="section-header">
                <h2>Our Work</h2>
                <div class="section-divider"></div>
                <p>A showcase of our recent projects</p>
            </div>
            <div class="portfolio-grid">
                <div class="portfolio-item">
                    <img src="{{ asset('images/aai.jpg') }}" alt="Wedding Film" class="portfolio-image">
                    <div class="portfolio-overlay">
                        <h4>Wedding Film</h4>
                        <p>Sarah & Mike's Special Day</p>
                        <a href="#" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="portfolio-item">
                    <img src="{{ asset('images/bupai.jpg') }}" alt="Product Launch" class="portfolio-image">
                    <div class="portfolio-overlay">
                        <h4>Product Launch</h4>
                        <p>TechCorp Brand Video</p>
                        <a href="#" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="portfolio-item">
                    <img src="{{ asset('images/forestman.jpg') }}" alt="Corporate Video" class="portfolio-image">
                    <div class="portfolio-overlay">
                        <h4>Corporate Video</h4>
                        <p>Company Culture Story</p>
                        <a href="#" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Create Something Amazing?</h2>
                <p>Let's bring your vision to life with stunning visuals that make an impact.</p>
                <a href="{{ route('booking.create') }}" class="cta-btn primary large">
                    <i class="fas fa-calendar-alt"></i>
                    Schedule Your Consultation
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="{{ asset('images/rtlzoom.jpg') }}" alt="RobtheLabStudios">
                        <h3>RobtheLabStudios</h3>
                    </div>
                    <p>Creating visuals that speak louder than words.</p>
                </div>
                <div class="footer-section">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="#">Wedding Films</a></li>
                        <li><a href="#">Product Shoots</a></li>
                        <li><a href="#">Corporate Videos</a></li>
                        <li><a href="#">Promotional Ads</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li><i class="fas fa-envelope"></i> **hello@robthelabstudios.com**</li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt"></i> Your City, State</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} RobtheLabStudios. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
