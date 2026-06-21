<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RobtheLabStudios | Visuals That Speak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --white: #ffffff; --off-white: #f7f5f2; --cream: #ede9e3;
            --ink: #0f0f0f; --charcoal: #2a2a2a; --mid: #7a7a7a;
            --gold: #b89c6e; --gold-light: #d4ba8a; --line: rgba(15,15,15,0.10);
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'DM Sans', sans-serif; background: #0f0f0f; color: #fff; overflow-x: hidden; }

        /* MAIN CANVAS — full page WebGL */
        #rtl-bg {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0; pointer-events: none;
        }

        /* All sections sit above canvas */
        .page-wrap { position: relative; z-index: 1; }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
            padding: 22px 0;
            background: rgba(10,10,10,0.0);
            backdrop-filter: blur(0px);
            border-bottom: 1px solid rgba(255,255,255,0);
            transition: background .4s, backdrop-filter .4s, border-color .4s, padding .3s;
        }
        .navbar.scrolled {
            padding: 14px 0;
            background: rgba(10,10,10,0.82);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(184,156,110,0.18);
        }
        .nav-container {
            max-width: 1200px; margin: 0 auto; padding: 0 48px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; color: #fff; }
        .nav-logo img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--gold); }
        .nav-logo span { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 600; letter-spacing: .04em; }
        .nav-links { display: flex; gap: 40px; }
        .nav-links a {
            font-size: .78rem; font-weight: 500; letter-spacing: .14em;
            text-transform: uppercase; color: rgba(255,255,255,.75);
            text-decoration: none; position: relative; padding-bottom: 3px; transition: color .25s;
        }
        .nav-links a::after {
            content:''; position:absolute; bottom:0; left:0;
            width:0; height:1px; background: var(--gold); transition: width .3s ease;
        }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: #fff; }
        .nav-hamburger {
            display: none; flex-direction: column; gap: 5px;
            background: none; border: none; cursor: pointer; padding: 4px; z-index: 300;
        }
        .nav-hamburger span { display: block; width: 24px; height: 1.5px; background: #fff; transition: all .3s ease; }
        .nav-hamburger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
        .nav-hamburger.open span:nth-child(2) { opacity: 0; }
        .nav-hamburger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }
        .mobile-menu {
            display: none; position: fixed; inset: 0; z-index: 250;
            background: rgba(10,10,10,.97); backdrop-filter: blur(20px);
            flex-direction: column; align-items: center; justify-content: center; gap: 36px;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a { font-family: 'Cormorant Garamond', serif; font-size: 2.4rem; font-weight: 300; color: #fff; text-decoration: none; letter-spacing: .04em; transition: color .2s; }
        .mobile-menu a:hover { color: var(--gold); }

        /* HERO */
        .hero {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            text-align: center; padding: 0 24px; position: relative;
        }
        .hero-content { animation: heroIn 1.1s cubic-bezier(.22,.68,0,1.2) both; padding-top: 80px; }
        @keyframes heroIn { from { opacity:0; transform:translateY(50px); } to { opacity:1; transform:translateY(0); } }
        .hero-logo img {
            width: 90px; height: 90px; border-radius: 50%;
            border: 2px solid var(--gold); object-fit: cover; margin-bottom: 32px;
            box-shadow: 0 0 0 8px rgba(184,156,110,.12), 0 0 60px rgba(184,156,110,.15);
        }
        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3.2rem, 8vw, 7rem);
            line-height: .9; color: #fff; letter-spacing: .04em;
            display: flex; flex-direction: column; align-items: center;
        }
        .hero-title .highlight { color: var(--gold); text-shadow: 0 0 80px rgba(184,156,110,.4); }
        .hero-subtitle {
            font-family: 'Cormorant Garamond', serif; font-style: italic;
            font-size: clamp(1.1rem, 2.5vw, 1.6rem); color: rgba(255,255,255,.6);
            margin: 20px 0 44px; letter-spacing: .05em;
        }
        .hero-actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .cta-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 34px; font-size: .82rem; font-weight: 500;
            letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; border-radius: 2px;
            transition: all .28s ease; cursor: pointer;
        }
        .cta-btn.primary { background: var(--gold); color: #0f0f0f; border: 1.5px solid var(--gold); }
        .cta-btn.primary:hover { background: transparent; color: var(--gold-light); }
        .cta-btn.secondary { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,.35); }
        .cta-btn.secondary:hover { border-color: var(--gold); color: var(--gold); }
        .cta-btn.large { padding: 17px 44px; font-size: .85rem; }
        .scroll-indicator { position: absolute; bottom: 36px; left: 50%; transform: translateX(-50%); }
        .scroll-arrow {
            width: 1px; height: 60px;
            background: linear-gradient(to bottom, transparent, var(--gold));
            margin: 0 auto; animation: scrollPulse 2s ease infinite;
        }
        @keyframes scrollPulse { 0%,100%{opacity:.2;transform:scaleY(.5);transform-origin:top} 50%{opacity:1;transform:scaleY(1);transform-origin:top} }

        /* GLASS PANEL base — used by all sections */
        .glass-section {
            margin: 0 auto 60px; max-width: 1200px; padding: 0 24px;
        }
        .glass-panel {
            background: rgba(15,15,15,0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(184,156,110,0.15);
            border-radius: 4px;
            padding: 80px 80px;
        }

        /* SECTION HEADER */
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 300; letter-spacing: -.01em; color: #fff;
        }
        .section-header p { margin-top: 14px; color: rgba(255,255,255,.45); font-size: .93rem; letter-spacing: .05em; }
        .section-divider { width: 40px; height: 1px; background: var(--gold); margin: 16px auto 0; }

        /* ABOUT */
        .about-content { display: grid; grid-template-columns: 1fr 1fr; gap: 72px; align-items: start; }
        .about-text .lead {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.2rem, 2vw, 1.55rem);
            font-weight: 300; line-height: 1.65; color: rgba(255,255,255,.9); margin-bottom: 20px;
        }
        .about-text p { color: rgba(255,255,255,.45); font-size: .93rem; line-height: 1.9; }
        .about-stats { display: flex; flex-direction: column; gap: 36px; border-left: 1px solid rgba(184,156,110,.25); padding-left: 56px; }
        .stat h3 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2.8rem, 5vw, 4rem); font-weight: 300; color: var(--gold); line-height: 1; }
        .stat p { font-size: .75rem; letter-spacing: .16em; text-transform: uppercase; color: rgba(255,255,255,.4); margin-top: 6px; }

        /* SERVICES */
        .services-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1px; background: rgba(184,156,110,.12); }
        .service-card {
            background: rgba(10,10,10,.6); padding: 44px 30px;
            position: relative; overflow: hidden;
            transition: background .3s ease;
        }
        .service-card::before {
            content:''; position:absolute; bottom:0; left:0;
            width:100%; height:2px; background: var(--gold);
            transform: scaleX(0); transform-origin: left; transition: transform .35s ease;
        }
        .service-card:hover { background: rgba(184,156,110,.07); }
        .service-card:hover::before { transform: scaleX(1); }
        .service-icon {
            width: 50px; height: 50px; border-radius: 50%;
            border: 1px solid rgba(184,156,110,.5);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px; color: var(--gold); font-size: 1.05rem;
            transition: background .3s, color .3s;
        }
        .service-card:hover .service-icon { background: var(--gold); color: #0f0f0f; border-color: var(--gold); }
        .service-card h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.35rem; font-weight: 600; color: #fff; margin-bottom: 14px; }
        .service-card p { font-size: .85rem; color: rgba(255,255,255,.42); line-height: 1.8; }

        /* PORTFOLIO */
        .portfolio-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
        .portfolio-item { position: relative; overflow: hidden; border-radius: 3px; background: #1a1a1a; }
        .portfolio-image { width: 100%; height: auto; display: block; transition: transform .6s cubic-bezier(.22,.68,0,1.2), filter .4s; filter: grayscale(20%) brightness(.9); }
        .portfolio-item:hover .portfolio-image { transform: scale(1.05); filter: grayscale(0%) brightness(1); }
        .portfolio-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,.9) 0%, rgba(10,10,10,0) 55%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 26px; opacity: 0; transition: opacity .35s ease;
        }
        .portfolio-item:hover .portfolio-overlay { opacity: 1; }
        .portfolio-overlay h4 { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; color: #fff; margin-bottom: 4px; }
        .portfolio-overlay p { font-size: .78rem; color: rgba(255,255,255,.6); margin-bottom: 16px; }
        .portfolio-link {
            width: 42px; height: 42px; border-radius: 50%;
            border: 1.5px solid var(--gold); color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; transition: background .25s, color .25s;
        }
        .portfolio-link:hover { background: var(--gold); color: #0f0f0f; }
        .portfolio-footer { display: flex; justify-content: center; margin-top: 48px; }
        .see-more-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 34px; font-size: .82rem; font-weight: 500;
            letter-spacing: .1em; text-transform: uppercase; text-decoration: none;
            border-radius: 2px; background: var(--gold); color: #0f0f0f;
            border: 1.5px solid var(--gold); transition: all .28s ease; cursor: pointer;
        }
        .see-more-btn:hover { background: transparent; color: var(--gold); }

        /* ARTISTS */
        .artists-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
        .artist-card { position: relative; overflow: hidden; border-radius: 3px; background: #1a1a1a; }
        .artist-image { width: 100%; height: auto; display: block; transition: transform .6s cubic-bezier(.22,.68,0,1.2), filter .4s; filter: grayscale(20%); }
        .artist-card:hover .artist-image { transform: scale(1.05); filter: grayscale(0%); }
        .artist-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,.88) 0%, rgba(10,10,10,0) 55%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 26px; opacity: 0; transition: opacity .35s ease;
        }
        .artist-card:hover .artist-overlay { opacity: 1; }
        .artist-overlay h4 { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; color: #fff; margin-bottom: 4px; }
        .artist-overlay p { font-size: .78rem; color: rgba(255,255,255,.6); }

        /* CTA */
        .cta-panel { text-align: center; }
        .cta-panel h2 { font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 4.5vw, 3.6rem); font-weight: 300; color: #fff; margin-bottom: 18px; }
        .cta-panel p { color: rgba(255,255,255,.42); font-size: .96rem; margin-bottom: 40px; letter-spacing: .03em; }

        /* FOOTER */
        footer { position: relative; z-index: 1; }
        .footer-glass {
            max-width: 1200px; margin: 0 auto 0; padding: 0 24px 40px;
        }
        .footer-inner {
            background: rgba(10,10,10,.8);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(184,156,110,.15);
            border-radius: 4px;
            padding: 60px 80px 36px;
        }
        .footer-content { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 52px; padding-bottom: 48px; border-bottom: 1px solid rgba(255,255,255,.07); }
        .footer-logo { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
        .footer-logo img { width: 42px; height: 42px; border-radius: 50%; border: 1.5px solid var(--gold); object-fit: cover; }
        .footer-logo h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 600; color: #fff; }
        .footer-section > p { font-size: .86rem; color: rgba(255,255,255,.38); line-height: 1.75; }
        .footer-section h4 { font-size: .7rem; letter-spacing: .2em; text-transform: uppercase; color: rgba(255,255,255,.5); margin-bottom: 20px; font-weight: 500; }
        .footer-section ul { list-style: none; }
        .footer-section ul li { font-size: .85rem; color: rgba(255,255,255,.38); margin-bottom: 10px; display: flex; align-items: center; gap: 10px; }
        .footer-section ul li i { color: var(--gold); font-size: .82rem; flex-shrink: 0; }
        .footer-section ul a { color: rgba(255,255,255,.38); text-decoration: none; transition: color .2s; }
        .footer-section ul a:hover { color: var(--gold); }
        .social-links { display: flex; gap: 12px; flex-wrap: wrap; }
        .social-links a {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid rgba(255,255,255,.12);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.38); text-decoration: none;
            transition: border-color .25s, color .25s; font-size: .88rem;
        }
        .social-links a:hover { border-color: var(--gold); color: var(--gold); }
        .footer-bottom { padding-top: 28px; text-align: center; }
        .footer-bottom p { font-size: .76rem; color: rgba(255,255,255,.28); letter-spacing: .08em; }

        /* REVEAL */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .glass-panel { padding: 60px 48px; }
            .footer-inner { padding: 48px 48px 28px; }
            .services-grid { grid-template-columns: repeat(2,1fr); }
            .portfolio-grid { grid-template-columns: repeat(2,1fr); }
            .footer-content { grid-template-columns: 1fr 1fr; gap: 36px; }
            .about-content { gap: 48px; }
        }
        @media (max-width: 768px) {
            .nav-container { padding: 0 20px; }
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
            .glass-panel { padding: 48px 28px; }
            .footer-inner { padding: 40px 28px 24px; }
            .about-content { grid-template-columns: 1fr; gap: 36px; }
            .about-stats { border-left: none; padding-left: 0; flex-direction: row; border-top: 1px solid rgba(184,156,110,.2); padding-top: 32px; }
            .stat { flex: 1; text-align: center; border-right: 1px solid rgba(255,255,255,.08); padding: 0 12px; }
            .stat:last-child { border-right: none; }
            .services-grid { grid-template-columns: 1fr; }
            .portfolio-grid, .artists-grid { grid-template-columns: 1fr; }
            .portfolio-overlay, .artist-overlay { opacity: 1; }
            .footer-content { grid-template-columns: 1fr; gap: 28px; }
            .hero-actions { flex-direction: column; align-items: center; }
            .cta-btn { width: 100%; max-width: 300px; justify-content: center; }
        }
        @media (max-width: 480px) {
            .glass-panel { padding: 36px 20px; }
            .footer-inner { padding: 32px 20px 20px; }
            .hero-title { font-size: clamp(2.8rem, 13vw, 4rem); }
            .about-stats { flex-direction: column; gap: 0; border-top: none; }
            .stat { border-right: none; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,.07); display: flex; justify-content: space-between; align-items: center; }
            .stat:last-child { border-bottom: none; }
        }
    </style>
</head>
<body>

<!-- THREE.JS FULL-PAGE BACKGROUND CANVAS -->
<canvas id="rtl-bg"></canvas>

<div class="page-wrap">

    <!-- MOBILE MENU -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#about"     onclick="closeMobileMenu()">About</a>
        <a href="#services"  onclick="closeMobileMenu()">Services</a>
        <a href="#portfolio" onclick="closeMobileMenu()">Portfolio</a>
        <a href="#contact"   onclick="closeMobileMenu()">Contact</a>
    </div>

    <!-- NAV -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a class="nav-logo" href="/">
                <img src="{{ asset('images/rtlzoom.jpg') }}" alt="RobtheLabStudios">
                <span>RobtheLabStudios</span>
            </a>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#portfolio">Portfolio</a>
                <a href="#contact">Contact</a>
            </div>
            <button class="nav-hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-logo">
                <img src="{{ asset('images/rtlzoom.jpg') }}" alt="RobtheLabStudios">
            </div>
            <h1 class="hero-title">
                <span>Rob the Lab</span>
                <span class="highlight">Studios</span>
            </h1>
            <p class="hero-subtitle">Visuals that speak louder than words.</p>
            <div class="hero-actions">
                <a href="{{ route('booking.create') }}" class="cta-btn primary">
                    <i class="fas fa-camera"></i> Book a Shoot
                </a>
                <a href="#portfolio" class="cta-btn secondary">
                    <i class="fas fa-play"></i> View Our Work
                </a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about">
        <div class="glass-section">
            <div class="glass-panel reveal">
                <div class="section-header">
                    <h2>About Us</h2>
                    <div class="section-divider"></div>
                </div>
                <div class="about-content">
                    <div class="about-text">
                        <p class="lead">RobtheLabStudios is a creative video production studio delivering cinematic visuals, brand stories, corporate films, and unforgettable moments.</p>
                        <p>We collaborate closely with clients to turn ideas into powerful visuals that resonate with audiences and drive results. Our team combines technical expertise with creative vision to produce content that stands out.</p>
                    </div>
                    <div class="about-stats">
                        <div class="stat"><h3>500+</h3><p>Projects Completed</p></div>
                        <div class="stat"><h3>50+</h3><p>Happy Clients</p></div>
                        <div class="stat"><h3>5+</h3><p>Years Experience</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services">
        <div class="glass-section">
            <div class="glass-panel reveal">
                <div class="section-header">
                    <h2>Our Services</h2>
                    <div class="section-divider"></div>
                    <p>We specialize in creating visual content that tells your story</p>
                </div>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-music"></i></div>
                        <h3>Audio Production</h3>
                        <p>Professional audio composition, lyrics, music production, arrangement, and mixing & mastering services.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-camera-retro"></i></div>
                        <h3>Film Production</h3>
                        <p>TVC/DVC, music videos, web films, and promotional ads. High-quality visuals that showcase your brand effectively.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-building"></i></div>
                        <h3>Line Production</h3>
                        <p>End-to-end production services for creating compelling visual content aligned with your brand and messaging.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-wrench"></i></div>
                        <h3>Equipment Rental</h3>
                        <p>Access to high-end film equipment for your production needs, ensuring professional quality and reliability.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PORTFOLIO -->
    <section id="portfolio">
        <div class="glass-section">
            <div class="glass-panel reveal">
                <div class="section-header">
                    <h2>Our Work</h2>
                    <div class="section-divider"></div>
                    <p>A showcase of our recent projects</p>
                </div>
                <div class="portfolio-grid">
                    <div class="portfolio-item">
                        <img src="{{ asset('images/aai.jpg') }}" alt="AAI O AAI" class="portfolio-image">
                        <div class="portfolio-overlay">
                            <h4>AAI O AAI</h4>
                            <p>by Joi Barua X Lakhya</p>
                            <a href="https://youtu.be/T1ZSL0wkZW4?si=OQQC2L-Vomxk_5dC" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                        </div>
                    </div>
                    <div class="portfolio-item">
                        <img src="{{ asset('images/bupai.jpg') }}" alt="BUPAI" class="portfolio-image">
                        <div class="portfolio-overlay">
                            <h4>BUPAI (বোপাই)</h4>
                            <p>LAKHYA | BIDYUT ROBIN | Official Music Video</p>
                            <a href="https://youtu.be/VM0dM8n4UYs?si=eeslMgxNJ9HjSwlF" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                        </div>
                    </div>
                    <div class="portfolio-item">
                        <img src="{{ asset('images/nongola.jpg') }}" alt="Nongola Sur" class="portfolio-image">
                        <div class="portfolio-overlay">
                            <h4>Nongola Sur (নঙলা চোৰ)</h4>
                            <p>Lakhya | Triv | Bidyut Robin | Official Music Video</p>
                            <a href="https://youtu.be/0ZXj8x2nZ3A?si=NUpDcfkXVUdKMbY7" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div class="portfolio-footer">
                    <a href="https://www.youtube.com/@robthelabstudios" target="_blank" rel="noopener noreferrer" class="see-more-btn">
                        <i class="fab fa-youtube"></i> See More on YouTube
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ARTISTS -->
    <section id="artists">
        <div class="glass-section">
            <div class="glass-panel reveal">
                <div class="section-header">
                    <h2>Our Artists</h2>
                    <div class="section-divider"></div>
                    <p>Talented creatives who bring vision to life</p>
                </div>
                <div class="artists-grid">
                    <div class="artist-card">
                        <img src="{{ asset('images/rtlzoom.jpg') }}" alt="Artist 1" class="artist-image">
                        <div class="artist-overlay">
                            <h4>Artist Name</h4>
                            <p>Cinematographer & Director</p>
                        </div>
                    </div>
                    <div class="artist-card">
                        <img src="{{ asset('images/rtlzoom.jpg') }}" alt="Artist 2" class="artist-image">
                        <div class="artist-overlay">
                            <h4>Artist Name</h4>
                            <p>Producer & Editor</p>
                        </div>
                    </div>
                    <div class="artist-card">
                        <img src="{{ asset('images/rtlzoom.jpg') }}" alt="Artist 3" class="artist-image">
                        <div class="artist-overlay">
                            <h4>Artist Name</h4>
                            <p>Audio Engineer & Composer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section>
        <div class="glass-section">
            <div class="glass-panel reveal cta-panel">
                <h2>Ready to Create Something Amazing?</h2>
                <p>Let's bring your vision to life with stunning visuals that make an impact.</p>
                <a href="{{ route('booking.create') }}" class="cta-btn primary large">
                    <i class="fas fa-calendar-alt"></i> Schedule Your Consultation
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="contact">
        <div class="footer-glass">
            <div class="footer-inner reveal">
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
                            <li><a href="#">Audio Production</a></li>
                            <li><a href="#">Film Production</a></li>
                            <li><a href="#">Line Production</a></li>
                            <li><a href="#">Equipment Rental</a></li>
                            <li><a href="#">Artist Pool</a></li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h4>Contact</h4>
                        <ul>
                            <li><i class="fas fa-envelope"></i><a href="mailto:robthelabofficial@gmail.com">robthelabofficial@gmail.com</a></li>
                            <li><i class="fas fa-phone"></i> 7638841414 / 6003613656</li>
                            <li><i class="fas fa-map-marker-alt"></i> Mumbai, Maharashtra</li>
                        </ul>
                    </div>
                    <div class="footer-section">
                        <h4>Follow Us</h4>
                        <div class="social-links">
                            <a href="https://www.instagram.com/robthelabstudios?igsh=MWlvZW0yanh1OGl5Nw==" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                            <a href="https://youtube.com/@robthelabstudios?si=iUT3Ukfem83YKu2T" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>© {{ date('Y') }} RobtheLabStudios. All rights reserved.</p>
                    <p style="margin-top:10px;font-size:.68rem;">
                        Developed by
                        <a href="https://www.linkedin.com/in/kabyashreeb/" target="_blank" rel="noopener noreferrer" style="color:var(--gold);text-decoration:none;">Kabyashree</a>
                        and
                        <a href="https://www.linkedin.com/in/sidhartha-gourav-sarmah-9a6322224/" target="_blank" rel="noopener noreferrer" style="color:var(--gold);text-decoration:none;">Sidhartha.</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

</div><!-- end .page-wrap -->

<!-- =====================================================
     SCRIPTS
====================================================== -->
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('js/landing.js') }}"></script>

<!-- Three.js r128 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

<!-- THREE.JS FULL-PAGE SCENE -->
<script>
(function () {
    'use strict';

    const canvas   = document.getElementById('rtl-bg');
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x080808, 1);

    const scene  = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(65, window.innerWidth / window.innerHeight, 0.1, 300);
    camera.position.set(0, 0, 50);

    /* ── LAYER 1: STAR FIELD (tiny white dots, deep z) ── */
    const STARS = 3000;
    const starPos = new Float32Array(STARS * 3);
    for (let i = 0; i < STARS; i++) {
        starPos[i*3]   = (Math.random() - 0.5) * 300;
        starPos[i*3+1] = (Math.random() - 0.5) * 200;
        starPos[i*3+2] = (Math.random() - 0.5) * 200 - 40;
    }
    const starGeo = new THREE.BufferGeometry();
    starGeo.setAttribute('position', new THREE.BufferAttribute(starPos, 3));
    const starMat = new THREE.PointsMaterial({ color: 0xffffff, size: 0.18, transparent: true, opacity: 0.55, sizeAttenuation: true });
    scene.add(new THREE.Points(starGeo, starMat));

    /* ── LAYER 2: GOLD PARTICLE FIELD (mid z) ── */
    const GP = 1800;
    const gpPos    = new Float32Array(GP * 3);
    const gpSpeeds = new Float32Array(GP);
    const gpOffset = new Float32Array(GP);
    for (let i = 0; i < GP; i++) {
        gpPos[i*3]   = (Math.random() - 0.5) * 140;
        gpPos[i*3+1] = (Math.random() - 0.5) * 90;
        gpPos[i*3+2] = (Math.random() - 0.5) * 60;
        gpSpeeds[i]  = 0.08 + Math.random() * 0.18;
        gpOffset[i]  = Math.random() * Math.PI * 2;
    }
    const gpGeo = new THREE.BufferGeometry();
    gpGeo.setAttribute('position', new THREE.BufferAttribute(gpPos, 3));
    const gpMat = new THREE.PointsMaterial({ color: 0xb89c6e, size: 0.28, transparent: true, opacity: 0.65, sizeAttenuation: true });
    const goldPoints = new THREE.Points(gpGeo, gpMat);
    scene.add(goldPoints);

    /* ── LAYER 3: FLOATING WIREFRAME RINGS (cinematic feel) ── */
    const rings = [];
    const ringData = [
        { r: 18, tube: 0.06, seg: 120, tSeg: 12, x: -22, y: 8,  z: -20, rx: 0.4, ry: 0.2 },
        { r: 11, tube: 0.05, seg: 100, tSeg: 10, x:  20, y: -6, z: -10, rx: 0.2, ry: 0.5 },
        { r: 7,  tube: 0.04, seg: 80,  tSeg: 8,  x:  0,  y: 14, z: -30, rx: 0.6, ry: 0.1 },
        { r: 28, tube: 0.04, seg: 140, tSeg: 12, x:  5,  y: -18, z: -50, rx: 0.1, ry: 0.3 },
    ];
    ringData.forEach(d => {
        const geo = new THREE.TorusGeometry(d.r, d.tube, d.tSeg, d.seg);
        const mat = new THREE.MeshBasicMaterial({ color: 0xb89c6e, wireframe: false, transparent: true, opacity: 0.18 });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.position.set(d.x, d.y, d.z);
        mesh.rotation.x = d.rx;
        mesh.rotation.y = d.ry;
        scene.add(mesh);
        rings.push({ mesh, rx: d.rx, ry: d.ry });
    });

    /* ── LAYER 4: FLOATING GRID LINES (horizontal, subtle) ── */
    const gridMat = new THREE.LineBasicMaterial({ color: 0xb89c6e, transparent: true, opacity: 0.06 });
    for (let row = -6; row <= 6; row++) {
        const pts = [];
        for (let x = -80; x <= 80; x += 4) {
            pts.push(new THREE.Vector3(x, row * 6, -60));
        }
        const lineGeo = new THREE.BufferGeometry().setFromPoints(pts);
        scene.add(new THREE.Line(lineGeo, gridMat));
    }
    for (let col = -20; col <= 20; col++) {
        const pts = [new THREE.Vector3(col * 8, -40, -60), new THREE.Vector3(col * 8, 40, -60)];
        const lineGeo = new THREE.BufferGeometry().setFromPoints(pts);
        scene.add(new THREE.Line(lineGeo, gridMat));
    }

    /* ── SCROLL + MOUSE ── */
    let scrollY  = 0;
    let targetSY = 0;
    let mouse    = { x: 0, y: 0 };
    let targetMX = 0, targetMY = 0;

    window.addEventListener('scroll', () => { targetSY = window.scrollY; });
    window.addEventListener('mousemove', e => {
        mouse.x = (e.clientX / window.innerWidth  - 0.5) * 2;
        mouse.y = (e.clientY / window.innerHeight - 0.5) * 2;
    });

    /* ── RESIZE ── */
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    /* ── ANIMATE ── */
    const gpPosAttr = gpGeo.attributes.position;
    let t = 0;

    function animate() {
        requestAnimationFrame(animate);
        t += 0.007;

        // smooth scroll & mouse
        scrollY  += (targetSY - scrollY)  * 0.06;
        targetMX += (mouse.x - targetMX)  * 0.04;
        targetMY += (mouse.y - targetMY)  * 0.04;

        // camera drifts with scroll and mouse
        camera.position.y  = -scrollY * 0.012 + targetMY * -2;
        camera.position.x  = targetMX * 2;
        camera.rotation.z  = targetMX * 0.018;

        // gold particles float upward + sway
        for (let i = 0; i < GP; i++) {
            gpPosAttr.array[i*3+1] += gpSpeeds[i] * 0.03;
            gpPosAttr.array[i*3]   += Math.sin(t * gpSpeeds[i] + gpOffset[i]) * 0.01;
            if (gpPosAttr.array[i*3+1] > 48) gpPosAttr.array[i*3+1] = -48;
        }
        gpPosAttr.needsUpdate = true;

        // gold points rotate gently with mouse
        goldPoints.rotation.y += (targetMX * 0.04 - goldPoints.rotation.y) * 0.025;
        goldPoints.rotation.x += (-targetMY * 0.03 - goldPoints.rotation.x) * 0.025;

        // rings slowly rotate
        rings.forEach((r, i) => {
            r.mesh.rotation.x = r.rx + t * (0.08 + i * 0.03);
            r.mesh.rotation.y = r.ry + t * (0.05 + i * 0.02);
        });

        renderer.render(scene, camera);
    }
    animate();
})();
</script>

<!-- UI SCRIPTS -->
<script>
    // Hamburger
    const hamburger  = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
        document.body.style.overflow = mobileMenu.classList.contains('open') ? 'hidden' : '';
    });
    function closeMobileMenu() {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
        document.body.style.overflow = '';
    }

    // Navbar
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 60);
    });

    // Reveal on scroll
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    reveals.forEach(r => io.observe(r));
</script>

</body>
</html>