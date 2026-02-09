<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Shoot | RobtheLabStudios</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>

<div class="booking-container">
    <div class="booking-background"></div>
    
    <div class="shooting-stars-container">
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
    </div>
    
    <div class="booking-wrapper">
        <div class="booking-card">
            <div class="booking-header">
                <h1>Book Your <span class="highlight">Shoot</span></h1>
                <div class="booking-divider"></div>
                <p class="booking-subtitle">Reserve your session with our expert team</p>
            </div>

            <form method="POST" action="{{ route('booking.store') }}" class="booking-form">
                @csrf

                <div class="form-info">
                    ✨ All fields are required to process your booking request.
                </div>

                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="ph_no">Phone Number <span class="required">*</span></label>
                    <input 
                        type="tel" 
                        id="ph_no"
                        name="ph_no" 
                        placeholder="(123) 456-7890"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        placeholder="your.email@example.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="address">Location / Address <span class="required">*</span></label>
                    <textarea 
                        id="address"
                        name="address" 
                        placeholder="Where would you like the shoot to take place? (Venue address or location details)"
                        required
                    ></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Book Now</button>
                    <a href="{{ url('/') }}" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
