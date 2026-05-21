<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Shoot | RobtheLabStudios</title>
    <!-- Add CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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

        .form-row { display: flex; gap: 20px; margin-bottom: 15px; }
        .form-row .form-group { flex: 1; margin-bottom: 0; position: relative; }

        @media (max-width: 600px) {
            .form-row { flex-direction: column; gap: 0; }
            .form-row .form-group { margin-bottom: 15px; }
        }

        .booking-form input, .booking-form textarea {
            width: 100%; padding: 10px 12px; background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px;
            color: #fff; box-sizing: border-box; font-size: 14px; height: 45px; transition: border-color 0.3s;
        }
        .booking-form input:focus, .booking-form textarea:focus { outline: none; border-color: #007bff; }
        .booking-form textarea { height: auto; min-height: 80px; resize: vertical; }

        /* Custom Select Styles */
        .custom-select-wrapper { position: relative; user-select: none; width: 100%; }
        .custom-select { position: relative; display: flex; flex-direction: column; }
        .custom-select__trigger {
            position: relative; display: flex; align-items: center; justify-content: space-between;
            padding: 0 12px; font-size: 14px; color: #fff; height: 45px;
            background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px; cursor: pointer; transition: all 0.3s ease;
        }
        .custom-select__trigger:hover { background: rgba(255, 255, 255, 0.1); }
        .custom-select.open .custom-select__trigger { border-color: #007bff; }
        .arrow {
            border: solid #ccc; border-width: 0 2px 2px 0; display: inline-block;
            padding: 3px; transform: rotate(45deg); transition: transform 0.3s ease; margin-bottom: 3px;
        }
        .custom-select.open .arrow { transform: rotate(-135deg); margin-bottom: -3px; border-color: #007bff; }
        .custom-options {
            position: absolute; display: block; top: 100%; left: 0; right: 0;
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.8); background: #1a1a24;
            transition: all 0.3s ease; opacity: 0; visibility: hidden; pointer-events: none;
            z-index: 999; margin-top: 5px; max-height: 200px; overflow-y: auto;
        }
        .custom-select.open .custom-options { opacity: 1; visibility: visible; pointer-events: all; transform: translateY(0); }
        .custom-option {
            position: relative; display: block; padding: 12px 15px; font-size: 14px;
            color: #ccc; cursor: pointer; transition: all 0.2s ease; border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .custom-option:last-child { border-bottom: none; }
        .custom-option:hover, .custom-option.selected { background: #007bff; color: #fff; }

        .autocomplete-results {
            position: absolute; top: 100%; left: 0; right: 0; background: #1a1a24;
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px;
            max-height: 200px; overflow-y: auto; z-index: 1000; display: none; margin-top: 5px; box-shadow: 0 10px 25px rgba(0,0,0,0.8);
        }
        .autocomplete-results div { padding: 10px 12px; cursor: pointer; color: #ccc; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .autocomplete-results div:hover, .autocomplete-active { background: #007bff !important; color: #ffffff !important; }

        /* CHECK STATUS MODAL STYLES */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(5px);
            display: none; justify-content: center; align-items: center; z-index: 9999;
        }
        .modal-content {
            background: #1a1a24; padding: 30px; border-radius: 15px; width: 100%; max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.1); position: relative; color: #fff; box-shadow: 0 15px 40px rgba(0,0,0,0.6);
        }
        .close-modal {
            position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #ccc; transition: 0.3s;
        }
        .close-modal:hover { color: #fff; }
        
        .status-card {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            padding: 15px; border-radius: 8px; margin-top: 15px;
        }
        .status-badge {
            display: inline-block; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: 600; text-transform: uppercase; float: right;
        }
        .badge-pending { background: #ffb703; color: #000; }
        .badge-approved { background: #2ecc71; color: #000; }
        .badge-rejected { background: #ff4d4d; color: #fff; }
        #status-loader { display: none; text-align: center; margin-top: 15px; color: #aaa; }

        .divider-container { position: relative; text-align: center; margin: 35px 0 25px 0; }
        .divider-line { position: absolute; top: 50%; left: 0; right: 0; border-top: 1px solid rgba(255, 255, 255, 0.2); z-index: 1; }
        .divider-text { position: relative; z-index: 2; background: #222; padding: 5px 15px; color: #aaa; font-size: 12px; font-weight: 600; text-transform: uppercase; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.2); }
        
        .check-status-btn {
            width: 100%; padding: 14px 20px; background: rgba(255, 183, 3, 0.1); border: 1px solid #ffb703; border-radius: 8px; color: #ffb703; font-size: 16px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; display: flex; justify-content: center; align-items: center; gap: 10px;
        }
        .check-status-btn:hover { background: #ffb703; color: #000; box-shadow: 0 5px 15px rgba(255, 183, 3, 0.3); transform: translateY(-2px); }

        /* SUCCESS SCREEN STYLES */
        .success-screen {
            text-align: center;
            padding: 20px 10px;
        }
        .success-icon-wrapper {
            width: 90px; height: 90px; background: rgba(46, 204, 113, 0.15); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;
        }
        .success-icon { color: #2ecc71; font-size: 45px; }
        .home-btn {
            display: inline-block; padding: 14px 35px; background: #007bff; color: white; text-decoration: none;
            border-radius: 8px; font-size: 16px; font-weight: 500; transition: 0.3s; margin-top: 10px;
        }
        .home-btn:hover { background: #0056b3; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4); }
    </style>
</head>
<body>

<div class="booking-container">
    <div class="booking-background"></div>
    <div class="shooting-stars-container">
        <div class="shooting-star"></div><div class="shooting-star"></div><div class="shooting-star"></div>
        <div class="shooting-star"></div><div class="shooting-star"></div><div class="shooting-star"></div>
    </div>
    
    <div class="booking-wrapper">
        <div class="booking-card">
            
         {{-- SUCCESS SCREEN (Only shows after a successful booking) --}}
            @if(session('success'))
                <div class="success-screen">
                    <div class="success-icon-wrapper">
                        <div class="success-icon">✔</div>
                    </div>
                    <h2 style="color: #fff; margin-bottom: 15px; font-size: 28px;">Booking Received!</h2>
                    
                    @if(session('booking_id'))
                    <div style="background: rgba(255, 183, 3, 0.1); border: 1px dashed #ffb703; padding: 20px; border-radius: 8px; margin-bottom: 25px; display: inline-block;">
                        <span style="color: #ccc; font-size: 14px;">Your Booking ID:</span><br>
                        <strong style="color: #ffb703; font-size: 28px; letter-spacing: 2px;">{{ session('booking_id') }}</strong>
                    </div>
                    @endif

                    <p style="color: #ccc; margin-bottom: 30px; font-size: 16px; line-height: 1.5;">
                        {{ session('success') }} <br>
                        Our team will review your request and contact you shortly.
                    </p>
                    
                    <a href="{{ route('landing') }}" class="home-btn">Return to Home</a>
                </div>

            {{-- THE FORM (Hides automatically if session('success') exists) --}}
            @else
                <div class="booking-header">
                    <h1>Book Your <span class="highlight">Shoot</span></h1>
                    <div class="booking-divider"></div>
                    <p class="booking-subtitle">Reserve your session with our expert team</p>
                </div>

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
                        <!-- <div class="form-info">Please enter your phone number to start.</div> -->
                        <div class="form-group">
                            <label for="phone_check">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone_check" name="phone_check" placeholder="Enter your number" required maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">Next</button>
                            <a href="{{ url('/') }}" class="cancel-btn">Cancel</a>
                        </div>
                    </form>

                    <!-- PROMINENT CHECK STATUS SECTION -->
                    <div class="divider-container">
                        <div class="divider-line"></div>
                        <span class="divider-text">OR</span>
                    </div>

                    <button type="button" class="check-status-btn" onclick="openStatusModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <circle cx="11.5" cy="14.5" r="2.5"></circle>
                            <line x1="13.27" y1="16.27" x2="16" y2="19"></line>
                        </svg>
                        Check Existing Booking Status
                    </button>

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
                            <div class="form-info">✨ Looks like you are new here! Please fill in your details.</div>
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
                                <div class="form-group">
                                    <label for="requirement_id">Requirement <span class="required">*</span></label>
                                    <select id="requirement_id" name="requirement_id" required>
                                        <option value="" disabled selected>Select Requirement...</option>
                                        @foreach($requirements as $req)
                                            <option value="{{ $req->ID }}">{{ $req->types_of_requirements }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="shoot_type">Shoot Type <span class="required">*</span></label>
                                    <select id="shoot_type" name="shoot_type" required>
                                        <option value="" disabled selected>Select Requirement First...</option>
                                    </select>
                                </div>
                            </div>

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

            {{-- Close the @if(session('success')) check --}}
            @endif
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- CHECK STATUS MODAL -->
<!-- ============================================== -->
<div id="statusModal" class="modal-overlay">
    <div class="modal-content booking-form">
        <span class="close-modal" onclick="closeStatusModal()">&times;</span>
        <h2 style="margin-bottom: 15px; font-size: 22px;">Check Booking Status</h2>
        <p style="font-size: 14px; color: #aaa; margin-bottom: 20px;">Enter the phone number you used to book your shoot.</p>
        
        <div class="form-group">
            <input type="tel" id="check_status_phone" placeholder="10-digit Phone Number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
        </div>
        
        <button class="submit-btn" style="width: 100%; margin-top: 15px;" onclick="fetchStatus()">Check Status</button>

        <div id="status-loader">Searching...</div>
        <div id="status-results" style="margin-top: 20px; max-height: 250px; overflow-y: auto;"></div>
    </div>
</div>

<script>
    // ==========================================
    // CHECK STATUS MODAL LOGIC
    // ==========================================
    function openStatusModal() { document.getElementById('statusModal').style.display = 'flex'; }
    function closeStatusModal() { 
        document.getElementById('statusModal').style.display = 'none'; 
        document.getElementById('status-results').innerHTML = '';
        document.getElementById('check_status_phone').value = '';
    }

    function fetchStatus() {
        const phone = document.getElementById('check_status_phone').value;
        const resultsDiv = document.getElementById('status-results');
        const loader = document.getElementById('status-loader');
        
        if (phone.length !== 10) {
            resultsDiv.innerHTML = '<p style="color: #ff4d4d; font-size: 14px;">Please enter a valid 10-digit phone number.</p>';
            return;
        }

        resultsDiv.innerHTML = '';
        loader.style.display = 'block';

        // Fetch data using AJAX
        fetch('{{ route("api.check-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ phone: phone })
        })
        .then(response => response.json())
        .then(data => {
            loader.style.display = 'none';
            if (data.success) {
                let html = `<h3 style="font-size: 16px; margin-bottom: 10px;">Hi ${data.client_name}, here are your bookings:</h3>`;
                
              data.bookings.forEach(booking => {
                    let badgeClass = booking.status === 'approved' ? 'badge-approved' : (booking.status === 'rejected' ? 'badge-rejected' : 'badge-pending');
                    
                    // Display 'ROB001' if booking_id exists, otherwise fallback to database ID '#1'
                    let displayId = booking.booking_id ? booking.booking_id : '#' + booking.ID;

                    html += `
                        <div class="status-card">
                            <span class="status-badge ${badgeClass}">${booking.status}</span>
                            <div style="font-weight: 600; margin-bottom: 5px;">${booking.shoot_type}</div>
                            <div style="font-size: 12px; color: #aaa;">Location: ${booking.shoot_location}</div>
                            <div style="font-size: 14px; color: #ffb703; margin-top: 5px; font-weight: 500;">Booking ID: ${displayId}</div>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;
            } else {
                resultsDiv.innerHTML = `<p style="color: #ffb703; font-size: 14px;">${data.message}</p>`;
            }
        })
        .catch(error => {
            loader.style.display = 'none';
            resultsDiv.innerHTML = '<p style="color: #ff4d4d; font-size: 14px;">An error occurred. Please try again later.</p>';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // ==========================================
        // CUSTOM MODERN DROPDOWN GENERATOR
        // ==========================================
        function setupCustomDropdown(selectId) {
            const select = document.getElementById(selectId);
            if (!select) return;

            let existingWrapper = select.nextElementSibling;
            if (existingWrapper && existingWrapper.classList.contains('custom-select-wrapper')) {
                existingWrapper.remove();
            }
            select.style.display = 'none';

            const wrapper = document.createElement('div');
            wrapper.className = 'custom-select-wrapper';
            const customSelect = document.createElement('div');
            customSelect.className = 'custom-select';

            const trigger = document.createElement('div');
            trigger.className = 'custom-select__trigger';
            const triggerText = document.createElement('span');
            triggerText.textContent = select.options[select.selectedIndex]?.text || 'Select...';
            const arrow = document.createElement('div');
            arrow.className = 'arrow';

            trigger.appendChild(triggerText);
            trigger.appendChild(arrow);
            customSelect.appendChild(trigger);

            const optionsContainer = document.createElement('div');
            optionsContainer.className = 'custom-options';

            Array.from(select.options).forEach((option) => {
                if (option.disabled && option.value === "") return;

                const customOption = document.createElement('span');
                customOption.className = 'custom-option';
                if(select.value === option.value) customOption.classList.add('selected');
                
                customOption.textContent = option.textContent;
                customOption.dataset.value = option.value;

                customOption.addEventListener('click', function(e) {
                    e.stopPropagation();
                    select.value = this.dataset.value;
                    select.dispatchEvent(new Event('change'));
                    triggerText.textContent = this.textContent;
                    
                    optionsContainer.querySelectorAll('.custom-option').forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    customSelect.classList.remove('open');
                });
                optionsContainer.appendChild(customOption);
            });

            customSelect.appendChild(optionsContainer);
            wrapper.appendChild(customSelect);
            select.parentNode.insertBefore(wrapper, select.nextSibling);

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                document.querySelectorAll('.custom-select').forEach(drop => {
                    if(drop !== customSelect) drop.classList.remove('open');
                });
                customSelect.classList.toggle('open');
            });
        }

        document.addEventListener('click', function(e) {
            document.querySelectorAll('.custom-select').forEach(drop => { drop.classList.remove('open'); });
            
            // Close status modal if clicked outside content
            let modal = document.getElementById('statusModal');
            if (e.target === modal) closeStatusModal();
        });

        setupCustomDropdown('requirement_id');
        setupCustomDropdown('shoot_type');
        setupCustomDropdown('source');


        // ==========================================
        // DEPENDENT DROPDOWN LOGIC (AJAX)
        // ==========================================
        const reqDropdown = document.getElementById('requirement_id');
        const typeDropdown = document.getElementById('shoot_type');

        if (reqDropdown && typeDropdown) {
            reqDropdown.addEventListener('change', function() {
                const reqId = this.value;
                typeDropdown.innerHTML = '<option value="" disabled selected>Loading...</option>';
                setupCustomDropdown('shoot_type');

                if (reqId) {
                    fetch(`/api/shoot-types/${reqId}`)
                        .then(response => response.json())
                        .then(data => {
                            typeDropdown.innerHTML = '<option value="" disabled selected>Select Shoot Type...</option>';
                            data.forEach(shoot => {
                                let option = document.createElement('option');
                                option.value = shoot.type_of_shoot; 
                                option.textContent = shoot.type_of_shoot;
                                typeDropdown.appendChild(option);
                            });
                            setupCustomDropdown('shoot_type');
                        })
                        .catch(error => {
                            typeDropdown.innerHTML = '<option value="" disabled selected>Error loading types</option>';
                            setupCustomDropdown('shoot_type');
                        });
                }
            });
        }


        // ==========================================
        // CITY AUTOCOMPLETE LOGIC
        // ==========================================
        const input = document.getElementById('shoot_location');
        const resultsDiv = document.getElementById('city-results');
        let timeout = null; let currentFocus = -1;

        if(input) {
            input.addEventListener('input', function() {
                const query = this.value; currentFocus = -1;
                if (query.length < 2) { resultsDiv.innerHTML = ''; resultsDiv.style.display = 'none'; return; }

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
                                    div.innerHTML = cityObj.city + "<input type='hidden' value='" + cityObj.city + "'>";
                                    div.addEventListener('click', function() {
                                        input.value = this.getElementsByTagName("input")[0].value;
                                        resultsDiv.innerHTML = ''; resultsDiv.style.display = 'none';
                                    });
                                    resultsDiv.appendChild(div);
                                });
                            } else { resultsDiv.style.display = 'none'; }
                        });
                }, 300);
            });

            input.addEventListener("keydown", function(e) {
                let x = resultsDiv.getElementsByTagName("div");
                if (!x.length) return;
                if (e.keyCode == 40) { currentFocus++; addActive(x); } 
                else if (e.keyCode == 38) { currentFocus--; addActive(x); } 
                else if (e.keyCode == 13) { e.preventDefault(); if (currentFocus > -1) { if (x[currentFocus]) x[currentFocus].click(); } }
            });

            function addActive(x) {
                if (!x) return false; removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autocomplete-active");
                x[currentFocus].scrollIntoView({ block: 'nearest' });
            }
            function removeActive(x) { for (let i = 0; i < x.length; i++) x[i].classList.remove("autocomplete-active"); }
        }
    });
</script>

</body>
</html>