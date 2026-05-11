<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RobtheLabStudios | Visuals That Speak</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
{{-- stylesheets --}}
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --white:      #ffffff;
            --off-white:  #f7f5f2;
            --cream:      #ede9e3;
            --ink:        #0f0f0f;
            --charcoal:   #2a2a2a;
            --mid:        #7a7a7a;
            --gold:       #b89c6e;
            --gold-light: #d4ba8a;
            --line:       rgba(15,15,15,0.10);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
        }

        /* ── NOISE OVERLAY ── */
        body::before {
            content:''; position:fixed; inset:0; z-index:0; pointer-events:none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            opacity:.6;
        }

        /* ── CONTAINER ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 48px; position: relative; z-index: 1; }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 24px 0;
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
            transition: padding .3s;
        }
        .navbar.scrolled { padding: 14px 0; }
        .nav-container {
            max-width: 1200px; margin: 0 auto; padding: 0 48px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; color: var(--ink);
        }
        .nav-logo img {
            width: 40px; height: 40px; border-radius: 50%;
            object-fit: cover; border: 1.5px solid var(--gold);
        }
        .nav-logo span {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem; font-weight: 600; letter-spacing: .04em;
            color: var(--ink);
        }
        .nav-links { display: flex; gap: 40px; }
        .nav-links a {
            font-size: .8rem; font-weight: 500; letter-spacing: .12em;
            text-transform: uppercase; color: var(--charcoal);
            text-decoration: none; position: relative; padding-bottom: 3px;
        }
        .nav-links a::after {
            content:''; position:absolute; bottom:0; left:0;
            width:0; height:1px; background: var(--gold);
            transition: width .3s ease;
        }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: var(--ink); }

        /* ── HERO ── */
        .hero {
            position: relative; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; background: var(--ink);
        }
        .hero-background {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; opacity: .42;
        }
        .hero::after {
            content:''; position:absolute; inset:0;
            background: linear-gradient(135deg, rgba(10,10,10,.7) 0%, rgba(10,10,10,.2) 60%, rgba(10,10,10,.6) 100%);
        }
        .hero-content {
            position: relative; z-index: 2;
            text-align: center; padding: 100px 24px 0;
            animation: heroIn .9s cubic-bezier(.22,.68,0,1.2) both;
        }
        @keyframes heroIn { from { opacity:0; transform: translateY(40px);} to { opacity:1; transform: translateY(0);} }

        .hero-logo img {
            width: 90px; height: 90px; border-radius: 50%;
            border: 2px solid var(--gold);
            object-fit: cover; margin-bottom: 32px;
            box-shadow: 0 0 0 8px rgba(184,156,110,.15);
        }
        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.8rem, 6vw, 5.5rem);
            line-height: .93; color: var(--white);
            letter-spacing: .02em;
            display: flex; flex-direction: column; align-items: center;
        }
        .hero-title .highlight { color: var(--gold); }
        .hero-subtitle {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: clamp(1.1rem, 2.5vw, 1.55rem);
            color: rgba(255,255,255,.72); margin: 18px 0 40px;
            letter-spacing: .03em;
        }
        .hero-actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .cta-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 34px; font-size: .82rem; font-weight: 500;
            letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; border-radius: 2px;
            transition: all .28s ease; cursor: none;
        }
        .cta-btn.primary {
            background: var(--gold); color: var(--ink);
            border: 1.5px solid var(--gold);
        }
        .cta-btn.primary:hover {
            background: transparent; color: var(--gold-light);
        }
        .cta-btn.secondary {
            background: transparent; color: var(--white);
            border: 1.5px solid rgba(255,255,255,.45);
        }
        .cta-btn.secondary:hover {
            border-color: var(--gold); color: var(--gold);
        }
        .cta-btn.large { padding: 17px 44px; font-size: .85rem; }
        .cta-btn { cursor: pointer; }

        /* scroll indicator */
        .scroll-indicator {
            position: absolute; bottom: 36px; left: 50%; transform: translateX(-50%);
            z-index: 3;
        }
        .scroll-arrow {
            width: 1px; height: 60px;
            background: linear-gradient(to bottom, transparent, var(--gold));
            margin: 0 auto; animation: scrollPulse 2s ease infinite;
        }
        @keyframes scrollPulse { 0%,100%{opacity:.3;transform:scaleY(.6);transform-origin:top}50%{opacity:1;transform:scaleY(1);transform-origin:top} }

        /* ── SECTION COMMONS ── */
        section { position: relative; z-index: 1; }
        .section-header { text-align: center; margin-bottom: 72px; }
        .section-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.4rem, 5vw, 4rem);
            font-weight: 300; letter-spacing: -.01em; color: var(--ink);
        }
        .section-header p {
            margin-top: 16px; color: var(--mid);
            font-size: .95rem; letter-spacing: .04em;
        }
        .section-divider {
            width: 40px; height: 1px; background: var(--gold);
            margin: 18px auto 0;
        }

        /* ── ABOUT ── */
        .about { background: var(--white); padding: 120px 0; }
        .about-content {
            display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start;
        }
        .about-text .lead {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.25rem, 2.2vw, 1.6rem);
            font-weight: 300; line-height: 1.6; color: var(--ink);
            margin-bottom: 24px;
        }
        .about-text p {
            color: var(--mid); font-size: .95rem; line-height: 1.85;
        }
        .about-stats {
            display: flex; flex-direction: column; gap: 40px;
            border-left: 1px solid var(--line); padding-left: 60px;
        }
        .stat { }
        .stat h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.8rem, 5vw, 4.2rem);
            font-weight: 300; color: var(--gold); line-height: 1;
        }
        .stat p {
            font-size: .78rem; letter-spacing: .14em;
            text-transform: uppercase; color: var(--mid); margin-top: 6px;
        }

        /* ── SERVICES ── */
        .services { background: var(--off-white); padding: 120px 0; }
        .services-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px;
        }
        .service-card {
            background: var(--white); padding: 52px 36px;
            border: 1px solid var(--line);
            transition: all .3s ease;
            position: relative; overflow: hidden;
        }
        .service-card::before {
            content:''; position:absolute; bottom:0; left:0;
            width:100%; height:2px; background: var(--gold);
            transform: scaleX(0); transform-origin: left;
            transition: transform .35s ease;
        }
        .service-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(0,0,0,.06); }
        .service-card:hover::before { transform: scaleX(1); }
        .service-icon {
            width: 52px; height: 52px; border-radius: 50%;
            border: 1px solid var(--gold); display: flex; align-items: center; justify-content: center;
            margin-bottom: 28px; color: var(--gold); font-size: 1.1rem;
            transition: background .3s, color .3s;
        }
        .service-card:hover .service-icon {
            background: var(--gold); color: var(--white);
        }
        .service-card h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.45rem; font-weight: 600; color: var(--ink);
            margin-bottom: 16px; letter-spacing: .01em;
        }
        .service-card p { font-size: .88rem; color: var(--mid); line-height: 1.8; }

        /* ── PORTFOLIO ── */
        .portfolio { background: var(--white); padding: 120px 0; }
        .portfolio-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .portfolio-item {
            position: relative; overflow: hidden;
            background: var(--cream); border-radius: 4px;
        }
        .portfolio-image {
            width: 100%; height: auto; display: block;
            transition: transform .6s cubic-bezier(.22,.68,0,1.2), filter .4s;
            filter: grayscale(10%);
        }
        .portfolio-item:hover .portfolio-image {
            transform: scale(1.04); filter: grayscale(0%);
        }
        .portfolio-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,.82) 0%, rgba(10,10,10,0) 55%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 28px;
            opacity: 0; transition: opacity .35s ease;
        }
        .portfolio-item:hover .portfolio-overlay { opacity: 1; }
        .portfolio-overlay h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem; font-weight: 600; color: var(--white);
            margin-bottom: 4px;
        }
        .portfolio-overlay p { font-size: .8rem; color: rgba(255,255,255,.65); margin-bottom: 18px; }
        .portfolio-link {
            width: 44px; height: 44px; border-radius: 50%;
            border: 1.5px solid var(--gold); color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; transition: background .25s, color .25s;
        }
        .portfolio-link:hover { background: var(--gold); color: var(--ink); }
        .portfolio-footer {
            display: flex; justify-content: center; margin-top: 56px;
        }
        .see-more-btn {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 34px; font-size: .82rem; font-weight: 500;
            letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; border-radius: 2px; border: none;
            background: var(--gold); color: var(--ink);
            border: 1.5px solid var(--gold);
            transition: all .28s ease; cursor: pointer;
        }
        .see-more-btn:hover {
            background: transparent; color: var(--gold);
        }

        /* ── ARTISTS ── */
        .artists { background: var(--off-white); padding: 120px 0; }
        .artists-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .artist-card {
            position: relative; overflow: hidden;
            background: var(--cream); border-radius: 4px;
        }
        .artist-image {
            width: 100%; height: auto; display: block;
            transition: transform .6s cubic-bezier(.22,.68,0,1.2), filter .4s;
            filter: grayscale(10%);
        }
        .artist-card:hover .artist-image {
            transform: scale(1.04); filter: grayscale(0%);
        }
        .artist-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,10,10,.82) 0%, rgba(10,10,10,0) 55%);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 28px;
            opacity: 0; transition: opacity .35s ease;
        }
        .artist-card:hover .artist-overlay { opacity: 1; }
        .artist-overlay h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem; font-weight: 600; color: var(--white);
            margin-bottom: 4px;
        }
        .artist-overlay p { font-size: .8rem; color: rgba(255,255,255,.65); }

        /* ── CTA SECTION ── */
        .cta-section {
            background: var(--ink); padding: 100px 0;
            position: relative; overflow: hidden;
        }
        .cta-section::before {
            content:''; position:absolute; top:-1px; left:0; right:0;
            height: 80px;
            background: linear-gradient(to bottom, var(--white), transparent);
            pointer-events: none;
        }
        .cta-content { text-align: center; }
        .cta-content h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 4.5vw, 3.8rem);
            font-weight: 300; color: var(--white); letter-spacing: -.01em;
            margin-bottom: 20px;
        }
        .cta-content p {
            color: rgba(222, 222, 222, 0.55); font-size: .98rem;
            margin-bottom: 44px; letter-spacing: .03em;
        }
        .cta-section .cta-btn.primary {
            background: var(--gold); color: var(--ink); border-color: var(--gold);
        }
        .cta-section .cta-btn.primary:hover {
            background: transparent; color: var(--gold);
        }

        /* ── FOOTER ── */
        footer {
            background: var(--off-white);
            border-top: 1px solid var(--line);
            padding: 80px 0 36px;
        }
        .footer-content {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px;
            padding-bottom: 60px; border-bottom: 1px solid var(--line);
        }
        .footer-logo {
            display: flex; align-items: center; gap: 14px; margin-bottom: 18px;
        }
        .footer-logo img {
            width: 44px; height: 44px; border-radius: 50%;
            border: 1.5px solid var(--gold); object-fit: cover;
        }
        .footer-logo h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem; font-weight: 600;
        }
        .footer-section > p {
            font-size: .88rem; color: var(--mid); line-height: 1.75;
        }
        .footer-section h4 {
            font-size: .72rem; letter-spacing: .18em;
            text-transform: uppercase; color: var(--ink);
            margin-bottom: 22px; font-weight: 500;
        }
        .footer-section ul { list-style: none; }
        .footer-section ul li {
            font-size: .87rem; color: var(--mid);
            margin-bottom: 10px; display: flex; align-items: center; gap: 10px;
        }
        .footer-section ul li i { color: var(--gold); font-size: .85rem; flex-shrink: 0; }
        .footer-section ul a {
            color: var(--mid); text-decoration: none;
            transition: color .2s;
        }
        .footer-section ul a:hover { color: var(--gold); }
        .social-links { display: flex; gap: 14px; flex-wrap: wrap; }
        .social-links a {
            width: 40px; height: 40px; border-radius: 50%;
            border: 1px solid var(--line);
            display: flex; align-items: center; justify-content: center;
            color: var(--mid); text-decoration: none;
            transition: border-color .25s, color .25s, background .25s;
            font-size: .9rem;
        }
        .social-links a:hover {
            border-color: var(--gold); color: var(--gold);
        }
        .footer-bottom {
            padding-top: 32px; text-align: center;
        }
        .footer-bottom p {
            font-size: .78rem; color: var(--mid); letter-spacing: .08em;
        }

        /* ── REVEAL ANIMATIONS ── */
        .reveal {
            opacity: 0; transform: translateY(32px);
            transition: opacity .7s ease, transform .7s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }

        /* ── HAMBURGER ── */
        .nav-hamburger {
            display: none; flex-direction: column; gap: 5px;
            background: none; border: none; cursor: pointer; padding: 4px; z-index: 200;
        }
        .nav-hamburger span {
            display: block; width: 24px; height: 1.5px;
            background: var(--ink); transition: all .3s ease;
        }
        .nav-hamburger.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
        .nav-hamburger.open span:nth-child(2) { opacity: 0; }
        .nav-hamburger.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

        /* mobile drawer */
        .mobile-menu {
            display: none; position: fixed; inset: 0; z-index: 150;
            background: rgba(255,255,255,.97); backdrop-filter: blur(16px);
            flex-direction: column; align-items: center; justify-content: center;
            gap: 36px;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem; font-weight: 300; color: var(--ink);
            text-decoration: none; letter-spacing: .04em;
            transition: color .2s;
        }
        .mobile-menu a:hover { color: var(--gold); }

        /* ── TABLET 1024px ── */
        @media (max-width: 1024px) {
            .container { padding: 0 36px; }
            .nav-container { padding: 0 36px; }
            .services-grid { grid-template-columns: repeat(2, 1fr); }
            .portfolio-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .footer-content { grid-template-columns: 1fr 1fr; gap: 40px; }
            .about-content { gap: 52px; }
        }

        /* ── MOBILE 768px ── */
        @media (max-width: 768px) {
            .container { padding: 0 20px; }
            .nav-container { padding: 0 20px; }
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }

            .hero { min-height: 100svh; }
            .hero-content { padding: 80px 20px 0; }
            .hero-subtitle { font-size: 1rem; margin: 14px 0 28px; }
            .hero-actions { flex-direction: column; align-items: center; gap: 12px; }
            .cta-btn { width: 100%; max-width: 300px; justify-content: center; }

            .about { padding: 72px 0; }
            .about-content { grid-template-columns: 1fr; gap: 40px; }
            .about-stats {
                border-left: none; padding-left: 0;
                flex-direction: row; gap: 0;
                justify-content: space-between;
                border-top: 1px solid var(--line);
                padding-top: 36px;
            }
            .stat { text-align: center; flex: 1;
                border-right: 1px solid var(--line); padding: 0 16px; }
            .stat:last-child { border-right: none; }
            .stat h3 { font-size: 2.2rem; }
            .stat p { font-size: .7rem; }

            .services { padding: 72px 0; }
            .services-grid { grid-template-columns: 1fr; gap: 0; }
            .service-card { padding: 32px 24px; border-bottom: 1px solid var(--line); border-right: none; }
            .service-card::before { display: none; }

            .portfolio { padding: 72px 0; }
            .portfolio-grid { grid-template-columns: 1fr; gap: 14px; }
            .portfolio-overlay {
                opacity: 1;
                background: linear-gradient(to top, rgba(10,10,10,.78) 0%, transparent 52%);
            }

            .artists { padding: 72px 0; }
            .artists-grid { grid-template-columns: 1fr; gap: 14px; }
            .artist-overlay {
                opacity: 1;
                background: linear-gradient(to top, rgba(10,10,10,.78) 0%, transparent 52%);
            }

            .cta-section { padding: 72px 0; }
            .cta-btn.large { width: 100%; max-width: 300px; justify-content: center; }

            footer { padding: 56px 0 28px; }
            .footer-content { grid-template-columns: 1fr; gap: 36px; padding-bottom: 40px; }

            .section-header { margin-bottom: 44px; }
            .section-header h2 { font-size: 2.2rem; }
        }

        /* ── SMALL MOBILE 480px ── */
        @media (max-width: 480px) {
            .nav-logo span { font-size: .9rem; }
            .nav-logo img { width: 32px; height: 32px; }
            .hero-title { font-size: clamp(2.6rem, 13vw, 3.8rem); letter-spacing: 0; }
            .hero-subtitle { font-size: .92rem; }
            .about-stats { flex-direction: column; gap: 0; border-top: none; padding-top: 0; }
            .stat {
                border-right: none; padding: 18px 0;
                border-bottom: 1px solid var(--line);
                text-align: left; display: flex;
                align-items: center; justify-content: space-between;
            }
            .stat:last-child { border-bottom: none; }
            .stat h3 { font-size: 2.6rem; }
            .stat p { font-size: .72rem; letter-spacing: .1em; }
            .service-card { padding: 28px 20px; }
            .section-header h2 { font-size: 2rem; }
            .cta-content h2 { font-size: 1.7rem; }
            .footer-content { gap: 30px; }
        }
    </style>
</head>
<body>
    <!-- MOBILE MENU DRAWER -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#about"     onclick="closeMobileMenu()">About</a>
        <a href="#services"  onclick="closeMobileMenu()">Services</a>
        <a href="#portfolio" onclick="closeMobileMenu()">Portfolio</a>
        <a href="#contact"   onclick="closeMobileMenu()">Contact</a>
    </div>

    <!-- NAVIGATION -->
    <nav class="navbar" id="navbar">
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
            <button class="nav-hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <video class="hero-background" autoplay muted loop playsinline>
            <source src="{{ asset('videos/robvideo.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content">
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
            <div class="section-header reveal">
                <h2>About Us</h2>
                <div class="section-divider"></div>
            </div>
            <div class="about-content">
                <div class="about-text reveal">
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
                <div class="about-stats reveal reveal-delay-1">
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
            <div class="section-header reveal">
                <h2>Our Services</h2>
                <div class="section-divider"></div>
                <p>We specialize in creating visual content that tells your story</p>
            </div>
            <div class="services-grid">
                <div class="service-card reveal">
                    <div class="service-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3>Audio Production</h3>
                    <p>Professional audio composition, lyrics, music production, arrangement, and mixing & mastering services for your projects.</p>
                </div>
                <div class="service-card reveal reveal-delay-1">
                    <div class="service-icon">
                        <i class="fas fa-camera-retro"></i>
                    </div>
                    <h3>Film Production</h3>
                    <p>Professional videography and production services including TVC/DVC, music videos, web films, and promotional ads. High-quality visuals that showcase your products and brand effectively.</p>
                </div>
                <div class="service-card reveal reveal-delay-2">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Line Production</h3>
                    <p>End-to-end production services for creating compelling visual content that aligns with your brand and messaging.</p>
                </div>
                <div class="service-card reveal reveal-delay-3">
                    <div class="service-icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <h3>Film Equipment Rental Services</h3>
                    <p>Access to high-end film equipment for your production needs, ensuring professional quality and reliability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PORTFOLIO SECTION -->
    <section class="portfolio" id="portfolio">
        <div class="container">
            <div class="section-header reveal">
                <h2>Our Work</h2>
                <div class="section-divider"></div>
                <p>A showcase of our recent projects</p>
            </div>
            <div class="portfolio-grid">
                <div class="portfolio-item reveal">
                    <img src="{{ asset('images/aai.jpg') }}" alt="Wedding Film" class="portfolio-image">
                    <div class="portfolio-overlay">
                        <h4>AAI O AAI</h4>
                        <p> by Joi Barua  X Lakhya.</p>
                        <a href="https://youtu.be/T1ZSL0wkZW4?si=OQQC2L-Vomxk_5dC" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="portfolio-item reveal reveal-delay-1">
                    <img src="{{ asset('images/bupai.jpg') }}" alt="Product Launch" class="portfolio-image">
                    <div class="portfolio-overlay">
                        <h4>BUPAI (বোপাই)</h4>
                        <p> | LAKHYA | BIDYUT ROBIN | OFFICIAL MUSIC VIDEO</p>
                        <a href="https://youtu.be/VM0dM8n4UYs?si=eeslMgxNJ9HjSwlF" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                    </div>
                </div>
                <div class="portfolio-item reveal reveal-delay-2">
                    <img src="{{ asset('images/nongola.jpg') }}" alt="Corporate Video" class="portfolio-image">
                    <div class="portfolio-overlay">
                        <h4>Nongola Sur (নঙলা চোৰ)</h4>
                        <p> Lakhya | Triv | Bidyut Robin |Official Music Video</p>
                        <a href="https://youtu.be/0ZXj8x2nZ3A?si=NUpDcfkXVUdKMbY7" target="_blank" rel="noopener noreferrer" class="portfolio-link"><i class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
            <div class="portfolio-footer reveal">
                <a href="https://www.youtube.com/@robthelabstudios" target="_blank" rel="noopener noreferrer" class="see-more-btn">
                    <i class="fab fa-youtube"></i>
                    See More
                </a>
            </div>
        </div>
    </section>

    <!-- ARTISTS SECTION -->
    <section class="artists" id="artists">
        <div class="container">
            <div class="section-header reveal">
                <h2>Our Artists</h2>
                <div class="section-divider"></div>
                <p>Talented creatives who bring vision to life</p>
            </div>
            <div class="artists-grid">
                <div class="artist-card reveal">
                    <img src="{{ asset('images/rtlzoom.jpg') }}" alt="Artist 1" class="artist-image">
                    <div class="artist-overlay">
                        <h4>Artist Name</h4>
                        <p>Cinematographer & Director</p>
                    </div>
                </div>
                <div class="artist-card reveal reveal-delay-1">
                    <img src="{{ asset('images/rtlzoom.jpg') }}" alt="Artist 2" class="artist-image">
                    <div class="artist-overlay">
                        <h4>Artist Name</h4>
                        <p>Producer & Editor</p>
                    </div>
                </div>
                <div class="artist-card reveal reveal-delay-2">
                    <img src="{{ asset('images/rtlzoom.jpg') }}" alt="Artist 3" class="artist-image">
                    <div class="artist-overlay">
                        <h4>Artist Name</h4>
                        <p>Audio Engineer & Composer</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content reveal">
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
                        <li><a href="#">Audio Production</a></li>
                        <li><a href="#">Film Production</a></li>
                        <li><a href="#">Line Production</a></li>
                        <li><a href="#">Film Equipment Rental Services</a></li>
                        <li><a href="#">Artist Pool</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:robthelabofficial@gmail.com">robthelabofficial@gmail.com</a></li>
                        <li><i class="fas fa-phone"></i> 7638841414/ 6003613656</li>
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
                <p style="margin-top: 12px; font-size: .7rem;">Developed by <a href="https://www.linkedin.com/in/kabyashreeb/" target="_blank" rel="noopener noreferrer" style="color: var(--gold); text-decoration: none; transition: color .2s;">Kabyashree</a> and <a href="https://www.linkedin.com/in/sidhartha-gourav-sarmah-9a6322224/" target="_blank" rel="noopener noreferrer" style="color: var(--gold); text-decoration: none; transition: color .2s;">Sidhartha.</a></p>
            </div>
        </div>
    </footer>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="{{ asset('js/landing.js') }}"></script>
    <script>
        // Hamburger menu
        const hamburger   = document.getElementById('hamburger');
        const mobileMenu  = document.getElementById('mobileMenu');
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

        // Navbar shrink on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        });

        // Reveal on scroll
        const reveals = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.12 });
        reveals.forEach(r => io.observe(r));
    </script>
</body>
</html>