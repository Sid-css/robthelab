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
            position: relative; 
        }

        @media (max-width: 600px) {
            .form-row { flex-direction: column; gap: 0; }
            .form-row .form-group { margin-bottom: 15px; }
        }

        /* STANDARD INPUT STYLING */
        .booking-form input, 
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
            transition: border-color 0.3s;
        }
        .booking-form input:focus, .booking-form textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        .booking-form textarea { height: auto; min-height: 80px; resize: vertical; }

        /* =========================================
           MODERN CUSTOM DROPDOWN STYLES
           ========================================= */
        .custom-select-wrapper {
            position: relative;
            user-select: none;
            width: 100%;
        }
        .custom-select {
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .custom-select__trigger {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 12px;
            font-size: 14px;
            font-weight: 400;
            color: #fff;
            height: 45px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .custom-select__trigger:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .custom-select.open .custom-select__trigger {
            border-color: #007bff;
        }
        .arrow {
            border: solid #ccc;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 3px;
            transform: rotate(45deg);
            transition: transform 0.3s ease;
            margin-bottom: 3px;
        }
        .custom-select.open .arrow {
            transform: rotate(-135deg);
            margin-bottom: -3px;
            border-color: #007bff;
        }
        .custom-options {
            position: absolute;
            display: block;
            top: 100%;
            left: 0;
            right: 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.8);
            background: #1a1a24; /* Solid dark background for readability */
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            z-index: 999;
            margin-top: 5px;
            max-height: 200px;
            overflow-y: auto;
        }
        .custom-select.open .custom-options {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
            transform: translateY(0);
        }
        .custom-option {
            position: relative;
            display: block;
            padding: 12px 15px;
            font-size: 14px;
            color: #ccc;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .custom-option:last-child {
            border-bottom: none;
        }
        .custom-option:hover, .custom-option.selected {
            background: #007bff;
            color: #fff;
        }

        /* AUTOCOMPLETE STYLES */
        .autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1a1a24;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            margin-top: 5px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.8);
        }
        .autocomplete-results div {
            padding: 10px 12px;
            cursor: pointer;
            color: #ccc;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background 0.2s;
        }
        .autocomplete-results div:hover,
        .autocomplete-active {
            background: #007bff !important; 
            color: #ffffff !important;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <div class="booking-background"></div>
    
    <div class="shooting-stars-container">
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
                            type="tel" id="phone_check" name="phone_check" 
                            placeholder="Enter your number" required maxlength="10" pattern="\d{10}"
                            title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
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
                        <input type="hidden" name="existing_client_id" value="{{ $client->ID }}">
                        <div class="form-info" style="background: rgba(0, 255, 0, 0.15); border-left: 4px solid #00ff00;">
                            👋 Welcome back, <strong>{{ $client->name }}</strong>!
                        </div>
                    @else
                        <div class="form-info">
                            ✨ Looks like you are new here! Please fill in your details.
                        </div>
                    @endif

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ $client ? $client->name : old('name') }}" placeholder="Full Name" required {{ $client ? 'readonly' : '' }} style="{{ $client ? 'background: rgba(255,255,255,0.1); cursor: not-allowed; color: #aaa;' : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="ph_no">Phone <span class="required">*</span></label>
                            <input type="tel" id="ph_no" name="ph_no" value="{{ $phone }}" readonly style="background: rgba(255,255,255,0.1); cursor: not-allowed; color: #aaa;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ $client ? $client->email : old('email') }}" placeholder="your.email@example.com" required {{ $client ? 'readonly' : '' }} style="{{ $client ? 'background: rgba(255,255,255,0.1); cursor: not-allowed; color: #aaa;' : '' }}">
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="address">Client Address <span class="required">*</span></label>
                        <textarea id="address" name="address" placeholder="Your residential or billing address" required rows="2">{{ $client ? $client->address : old('address') }}</textarea>
                    </div>

                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1);">
                        <h3 style="color: #fff; margin-bottom: 10px; font-size: 1rem;">Shoot Requirements</h3>
                        
                        <div class="form-row">
                            <!-- Dependent Dropdown 1: Requirement -->
                            <div class="form-group">
                                <label for="requirement_id">Requirement <span class="required">*</span></label>
                                <!-- The original select is hidden by our JS and replaced with a custom UI -->
                                <select id="requirement_id" name="requirement_id" required>
                                    <option value="" disabled selected>Select Requirement...</option>
                                    @foreach($requirements as $req)
                                        <option value="{{ $req->ID }}">{{ $req->types_of_requirements }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dependent Dropdown 2: Shoot Type -->
                            <div class="form-group">
                                <label for="shoot_type">Shoot Type <span class="required">*</span></label>
                                <select id="shoot_type" name="shoot_type" required>
                                    <option value="" disabled selected>Select Requirement First...</option>
                                </select>
                            </div>
                        </div>

                        <!-- Shoot Location -->
                        <div class="form-group" style="margin-bottom: 15px; position: relative;">
                            <label for="shoot_location">Shoot Location (City) <span class="required">*</span></label>
                            <input type="text" id="shoot_location" name="shoot_location" placeholder="Type to search city..." required autocomplete="off">
                            <div id="city-results" class="autocomplete-results"></div>
                        </div>
                    </div>

                    @if(!$client)
                        <div class="form-group" style="margin-bottom: 15px;">
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
    document.addEventListener('DOMContentLoaded', function() {

        // ==========================================
        // 1. CUSTOM MODERN DROPDOWN GENERATOR
        // ==========================================
        function setupCustomDropdown(selectId) {
            const select = document.getElementById(selectId);
            if (!select) return;

            // Remove existing custom UI if we are rebuilding it (like after AJAX)
            let existingWrapper = select.nextElementSibling;
            if (existingWrapper && existingWrapper.classList.contains('custom-select-wrapper')) {
                existingWrapper.remove();
            }

            // Hide the native select
            select.style.display = 'none';

            // Create custom wrapper
            const wrapper = document.createElement('div');
            wrapper.className = 'custom-select-wrapper';

            const customSelect = document.createElement('div');
            customSelect.className = 'custom-select';

            // Create Trigger (The visible box)
            const trigger = document.createElement('div');
            trigger.className = 'custom-select__trigger';
            
            const triggerText = document.createElement('span');
            // Show selected option text, or the first option
            triggerText.textContent = select.options[select.selectedIndex]?.text || 'Select...';
            
            const arrow = document.createElement('div');
            arrow.className = 'arrow';

            trigger.appendChild(triggerText);
            trigger.appendChild(arrow);
            customSelect.appendChild(trigger);

            // Create Options Container
            const optionsContainer = document.createElement('div');
            optionsContainer.className = 'custom-options';

            // Loop through native options and create custom divs
            Array.from(select.options).forEach((option) => {
                if (option.disabled && option.value === "") return; // Skip the placeholder if disabled

                const customOption = document.createElement('span');
                customOption.className = 'custom-option';
                if(select.value === option.value) customOption.classList.add('selected');
                
                customOption.textContent = option.textContent;
                customOption.dataset.value = option.value;

                // Handle Option Click
                customOption.addEventListener('click', function(e) {
                    e.stopPropagation(); // prevent document click

                    // Update native select
                    select.value = this.dataset.value;
                    
                    // Trigger 'change' event on native select so our AJAX logic below catches it!
                    select.dispatchEvent(new Event('change'));
                    
                    // Update visual text
                    triggerText.textContent = this.textContent;
                    
                    // Update selected class
                    optionsContainer.querySelectorAll('.custom-option').forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    // Close dropdown
                    customSelect.classList.remove('open');
                });

                optionsContainer.appendChild(customOption);
            });

            customSelect.appendChild(optionsContainer);
            wrapper.appendChild(customSelect);
            
            // Insert into DOM right after the hidden select
            select.parentNode.insertBefore(wrapper, select.nextSibling);

            // Handle Trigger Click (Open/Close)
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                // Close all other dropdowns first
                document.querySelectorAll('.custom-select').forEach(drop => {
                    if(drop !== customSelect) drop.classList.remove('open');
                });
                customSelect.classList.toggle('open');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.custom-select').forEach(drop => {
                drop.classList.remove('open');
            });
        });

        // Initialize custom dropdowns on page load
        setupCustomDropdown('requirement_id');
        setupCustomDropdown('shoot_type');
        setupCustomDropdown('source');


        // ==========================================
        // 2. DEPENDENT DROPDOWN LOGIC (AJAX)
        // ==========================================
        const reqDropdown = document.getElementById('requirement_id');
        const typeDropdown = document.getElementById('shoot_type');

        if (reqDropdown && typeDropdown) {
            reqDropdown.addEventListener('change', function() {
                const reqId = this.value;
                
                // Show loading state and rebuild custom UI
                typeDropdown.innerHTML = '<option value="" disabled selected>Loading...</option>';
                setupCustomDropdown('shoot_type');

                if (reqId) {
                    fetch(`/api/shoot-types/${reqId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Reset options
                            typeDropdown.innerHTML = '<option value="" disabled selected>Select Shoot Type...</option>';
                            
                            // Populate new options
                            data.forEach(shoot => {
                                let option = document.createElement('option');
                                option.value = shoot.type_of_shoot; 
                                option.textContent = shoot.type_of_shoot;
                                typeDropdown.appendChild(option);
                            });

                            // Re-initialize the custom dropdown UI so it shows the new options
                            setupCustomDropdown('shoot_type');
                        })
                        .catch(error => {
                            console.error('Error fetching shoot types:', error);
                            typeDropdown.innerHTML = '<option value="" disabled selected>Error loading types</option>';
                            setupCustomDropdown('shoot_type');
                        });
                }
            });
        }


        // ==========================================
        // 3. CITY AUTOCOMPLETE LOGIC
        // ==========================================
        const input = document.getElementById('shoot_location');
        const resultsDiv = document.getElementById('city-results');
        let timeout = null;
        let currentFocus = -1;

        if(input) {
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

            input.addEventListener("keydown", function(e) {
                let x = resultsDiv.getElementsByTagName("div");
                if (!x.length) return;
                if (e.keyCode == 40) { currentFocus++; addActive(x); } 
                else if (e.keyCode == 38) { currentFocus--; addActive(x); } 
                else if (e.keyCode == 13) {
                    e.preventDefault();
                    if (currentFocus > -1) { if (x[currentFocus]) x[currentFocus].click(); }
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
                for (let i = 0; i < x.length; i++) x[i].classList.remove("autocomplete-active");
            }

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