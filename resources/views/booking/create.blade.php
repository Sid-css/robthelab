<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Shoot | RobtheLabStudios</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">

    <style>
        .booking-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .booking-card {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* GRID LAYOUT for side-by-side fields */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
            position: relative; /* Needed for dropdown positioning */
        }

        /* RESPONSIVE: Stack on mobile */
        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            .form-row .form-group {
                margin-bottom: 15px;
            }
        }

        /* UNIFIED STYLING FOR ALL INPUTS & SELECTS */
        .booking-form input, 
        .booking-form select, 
        .booking-form textarea {
            width: 100%;
            padding: 10px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            box-sizing: border-box;
            font-size: 14px;
            height: 45px; 
            line-height: normal;
        }

        .booking-form textarea {
            height: auto; 
            min-height: 80px;
            resize: vertical;
        }

        .booking-form select option {
            background: #000;
            color: #fff;
        }

        /* AUTOCOMPLETE STYLES */
        .autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1a1a1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .autocomplete-results div {
            padding: 10px 12px;
            cursor: pointer;
            color: #ccc;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .autocomplete-results div:hover,
        .autocomplete-active {
            background: #007bff !important; /* Blue highlight */
            color: #ffffff !important;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <div class="booking-background"></div>
    
    <div class="shooting-stars-container">
        <!-- Animation Divs -->
        <div class="shooting-star"></div><div class="shooting-star"></div><div class="shooting-star"></div>
        <div class="shooting-star"></div><div class="shooting-star"></div><div class="shooting-star"></div>
        <div class="shooting-star"></div><div class="shooting-star"></div><div class="shooting-star"></div>
    </div>
    
    <div class="booking-wrapper">
        <div class="booking-card">
            <div class="booking-header">
                <h1>Book Your <span class="highlight">Shoot</span></h1>
                <div class="booking-divider"></div>
                <p class="booking-subtitle">Reserve your session with our expert team</p>
            </div>

            {{-- Notifications --}}
            @if(session('success'))
                <div style="background: rgba(0, 255, 0, 0.1); border: 1px solid #00ff00; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: rgba(255, 0, 0, 0.1); border: 1px solid #ff0000; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background: rgba(255, 0, 0, 0.1); border: 1px solid #ff0000; color: #fff; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- STEP 1: PHONE CHECK --}}
            @if($step == 1)
                <form method="GET" action="{{ route('booking.create') }}" class="booking-form">
                    <div class="form-info">
                        📞 Please enter your phone number to start.
                    </div>
                    <div class="form-group">
                        <label for="phone_check">Phone Number <span class="required">*</span></label>
                        <input 
                            type="tel" 
                            id="phone_check" 
                            name="phone_check" 
                            placeholder="Enter your number" 
                            required 
                            maxlength="10" 
                            pattern="\d{10}"
                            title="Please enter exactly 10 digits"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                        >
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Next</button>
                        <a href="{{ url('/') }}" class="cancel-btn">Cancel</a>
                    </div>
                </form>

            {{-- STEP 2: MAIN FORM --}}
            @elseif($step == 2)
                
                <form method="POST" action="{{ route('booking.store') }}" class="booking-form" autocomplete="off">
                    @csrf

                    @if($client)
                        {{-- EXISTING CLIENT MODE --}}
                        <input type="hidden" name="existing_client_id" value="{{ $client->ID }}">
                        <div class="form-info" style="background: rgba(0, 255, 0, 0.15); border-left: 4px solid #00ff00;">
                            👋 Welcome back, <strong>{{ $client->name }}</strong>!
                        </div>
                    @else
                        {{-- NEW CLIENT MODE --}}
                        <div class="form-info">
                            ✨ Looks like you are new here! Please fill in your details.
                        </div>
                    @endif

                    {{-- ROW 1: NAME AND PHONE --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ $client ? $client->name : old('name') }}" 
                                placeholder="Full Name" 
                                required 
                                {{ $client ? 'readonly' : '' }} 
                                style="{{ $client ? 'background: rgba(255,255,255,0.1); cursor: not-allowed; color: #aaa;' : '' }}"
                            >
                        </div>
                        <div class="form-group">
                            <label for="ph_no">Phone <span class="required">*</span></label>
                            <input 
                                type="tel" 
                                id="ph_no" 
                                name="ph_no" 
                                value="{{ $phone }}" 
                                readonly 
                                style="background: rgba(255,255,255,0.1); cursor: not-allowed; color: #aaa;"
                                maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                            >
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ $client ? $client->email : old('email') }}" 
                            placeholder="your.email@example.com" 
                            required 
                            {{ $client ? 'readonly' : '' }} 
                            style="{{ $client ? 'background: rgba(255,255,255,0.1); cursor: not-allowed; color: #aaa;' : '' }}"
                        >
                    </div>

                    {{-- ADDRESS --}}
                    <div class="form-group">
                        <label for="address">Client Address <span class="required">*</span></label>
                        <textarea 
                            id="address" 
                            name="address" 
                            placeholder="Your residential or billing address" 
                            required 
                            rows="2"
                        >{{ $client ? $client->address : old('address') }}</textarea>
                    </div>

                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1);">
                        <h3 style="color: #fff; margin-bottom: 10px; font-size: 1rem;">Shoot Requirements</h3>
                        
                        {{-- ROW 2: SHOOT TYPE AND LOCATION SEARCH --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="shoot_type">Shoot Type <span class="required">*</span></label>
                                <select id="shoot_type" name="shoot_type" required>
                                    <option value="" disabled selected>Select...</option>
                                    @foreach($shootTypes as $type)
                                        <option value="{{ $type->type_of_shoot }}">{{ $type->type_of_shoot }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Shoot Location with Autocomplete -->
                            <div class="form-group">
                                <label for="shoot_location">Shoot Location (City) <span class="required">*</span></label>
                                <input 
                                    type="text" 
                                    id="shoot_location" 
                                    name="shoot_location" 
                                    placeholder="Type to search city..." 
                                    required
                                    autocomplete="off"
                                >
                                <div id="city-results" class="autocomplete-results"></div>
                            </div>
                        </div>
                    </div>

                    @if(!$client)
                        <div class="form-group">
                            <label for="source">Source <span class="required">*</span></label>
                            <select id="source" name="source" required>
                                <option value="" disabled selected>How did you hear about us?</option>
                                @foreach($sources as $source)
                                    <option value="{{ $source->type_of_source }}">{{ $source->type_of_source }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Book Now</button>
                        <a href="{{ route('booking.create') }}" class="cancel-btn">Back</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    // AUTOCOMPLETE SCRIPT WITH ARROW KEYS
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('shoot_location');
        const resultsDiv = document.getElementById('city-results');
        let timeout = null;
        let currentFocus = -1;

        if(input) {
            // 1. Handle Typing
            input.addEventListener('input', function() {
                const query = this.value;
                currentFocus = -1;

                if (query.length < 2) {
                    resultsDiv.innerHTML = '';
                    resultsDiv.style.display = 'none';
                    return;
                }

                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    fetch(`{{ route('cities.search') }}?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsDiv.innerHTML = '';
                            
                            if (data.length > 0) {
                                resultsDiv.style.display = 'block';
                                data.forEach(cityObj => {
                                    const div = document.createElement('div');
                                    div.innerHTML = cityObj.city; 
                                    div.innerHTML += "<input type='hidden' value='" + cityObj.city + "'>";
                                    
                                    // Handle Click Selection
                                    div.addEventListener('click', function() {
                                        input.value = this.getElementsByTagName("input")[0].value;
                                        resultsDiv.innerHTML = '';
                                        resultsDiv.style.display = 'none';
                                    });
                                    
                                    resultsDiv.appendChild(div);
                                });
                            } else {
                                resultsDiv.style.display = 'none';
                            }
                        });
                }, 300);
            });

            // 2. Handle Arrow Keys & Enter
            input.addEventListener("keydown", function(e) {
                let x = resultsDiv.getElementsByTagName("div");
                if (!x.length) return;

                if (e.keyCode == 40) { // Arrow DOWN
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) { // Arrow UP
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) { // ENTER
                    e.preventDefault();
                    if (currentFocus > -1) {
                        if (x[currentFocus]) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                if (!x) return false;
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
                x[currentFocus].scrollIntoView({ block: 'nearest' });
            }

            function removeActive(x) {
                for (let i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            // 3. Close when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target !== input && e.target !== resultsDiv) {
                    resultsDiv.style.display = 'none';
                }
            });
        }
    });
</script>

</body>
</html>