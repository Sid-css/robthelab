<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RobtheLab Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #0f0f14; color: #ffffff; }
        .dashboard { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #151521; padding: 30px 20px; flex-shrink: 0; }
        .sidebar h2 { text-align: center; font-size: 22px; margin-bottom: 40px; letter-spacing: 1px; color: #ffb703; }
        .sidebar a { display: block; padding: 12px 15px; margin-bottom: 10px; color: #ccc; text-decoration: none; border-radius: 8px; transition: 0.3s; cursor: pointer; }
        .sidebar a:hover, .sidebar a.active { background: #ffb703; color: #000; }

        /* Main Content */
        .main { flex: 1; padding: 40px; overflow-x: auto;}
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .topbar h1 { font-size: 26px; font-weight: 500; }
        .logout { background: #ff4d4d; border: none; padding: 10px 20px; color: #fff; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .alert-success { background: #2ecc71; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }

        /* Cards & Sections */
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; }
        .card { background: #1c1c2b; padding: 25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.4); }
        .card h3 { font-size: 16px; margin-bottom: 10px; color: #bbb; }
        .card p { font-size: 32px; font-weight: 600; color: #ffb703; }
        .section { margin-top: 50px; }
        .section h2 { font-size: 22px; margin-bottom: 20px; }
        
        /* Tables */
        table { width: 100%; border-collapse: collapse; background: #1c1c2b; border-radius: 10px; overflow: hidden; }
        table th, table td { padding: 14px 16px; text-align: left; font-size: 14px; }
        table th { background: #23233a; color: #ffb703; }
        table tr { border-bottom: 1px solid #2a2a40; }
        .status { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; text-transform: capitalize; }
        .pending { background: #ffb703; color: #000; }
        .approved { background: #2ecc71; color: #000; }
        .rejected { background: #ff4d4d; color: #fff; }
        .action-btn { border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 14px; }

        /* Tabs & Search */
        .tab-content { display: none; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 20px; }
        .sub-nav { display: flex; gap: 10px; }
        .sub-nav a { padding: 8px 16px; background: #2a2a40; color: #ccc; text-decoration: none; border-radius: 6px; font-size: 14px; cursor: pointer; }
        .sub-nav a.active, .sub-nav a:hover { background: #ffb703; color: #000; }
        .search-bar { flex-grow: 1; max-width: 400px; }
        .search-bar input { width: 100%; padding: 8px 12px; background: #2a2a40; border: 1px solid #444; color: white; border-radius: 6px; font-size: 14px; }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>RobtheLab</h2>
        <a id="nav-dashboard" class="tab-link" onclick="switchTab('dashboard-tab', this)">Dashboard</a>
        <a id="nav-bookings" class="tab-link" onclick="switchTab('bookings-tab', this)">Bookings</a>
        <a id="nav-clients" class="tab-link" onclick="switchTab('clients-tab', this)">Clients</a>
        <a href="#">Availability</a>
        <a href="#">Settings</a>
    </div>

    <div class="main">
        <div class="topbar">
            <h1>Welcome, {{ Auth::user()->name ?? 'Admin' }} 👋</h1>
            <form method="POST" action="{{ route('logout') }}"><button class="logout">Logout</button>@csrf</form>
        </div>

        @if(session('success'))<div class="alert-success" id="success-alert">{{ session('success') }}</div>@endif

        <!-- =================== DASHBOARD TAB =================== -->
        <div id="dashboard-tab" class="tab-content">
            <div class="cards">
                <div class="card"><h3>Total Clients</h3><p>{{ $totalClients }}</p></div>
                <div class="card"><h3>Total Bookings</h3><p>{{ $totalBookings }}</p></div>
                <div class="card"><h3>Pending Requests</h3><p>{{ $pendingRequests }}</p></div>
                <div class="card"><h3>Approved</h3><p>{{ $approvedRequests }}</p></div>
            </div>
            <div class="section">
                <h2>Recent Booking Requests</h2>
                <table>
                    <thead><tr><th>ID</th><th>Client</th><th>Service</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        @forelse($recentBookings as $shoot)
                            <tr>
                                <td>#{{ $shoot->ID }}</td>
                                <td>{{ $shoot->client->name ?? 'N/A' }}</td>
                                <td>{{ $shoot->shoot_type }}</td>
                                <td><span class="status {{ $shoot->status }}">{{ $shoot->status }}</span></td>
                                <td>
                                    @if($shoot->status == 'pending')
                                        <div style="display: flex; gap: 8px;">
                                            <form action="{{ route('booking.status') }}" method="POST"><input type="hidden" name="shoot_details_id" value="{{ $shoot->ID }}"><input type="hidden" name="status" value="approved">@csrf<button type="submit" class="action-btn" style="background:#2ecc71; color:white;">✔</button></form>
                                            <form action="{{ route('booking.status') }}" method="POST"><input type="hidden" name="shoot_details_id" value="{{ $shoot->ID }}"><input type="hidden" name="status" value="rejected">@csrf<button type="submit" class="action-btn" style="background:#ff4d4d; color:white;">✖</button></form>
                                        </div>
                                    @else<span style="color: #777;">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding: 20px;">No recent bookings found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- =================== BOOKINGS TAB =================== -->
        <div id="bookings-tab" class="tab-content">
            <h2>All Bookings</h2>
            <div class="toolbar" style="margin-top: 20px;">
                <div class="sub-nav">
                    <!-- Added the "All" tab -->
                    <a id="sub-nav-all" onclick="switchBookingTab('all', this)" class="active">All</a>
                    <a id="sub-nav-pending" onclick="switchBookingTab('pending', this)">Pending</a>
                    <a id="sub-nav-approved" onclick="switchBookingTab('approved', this)">Approved</a>
                    <a id="sub-nav-rejected" onclick="switchBookingTab('rejected', this)">Rejected</a>
                </div>
                <div class="search-bar">
                    <input type="text" id="bookings-search" onkeyup="filterBookings()" placeholder="Search by Client or Service...">
                </div>
            </div>

            <div class="section" style="margin-top: 0;">
                <!-- NEW "ALL" SUB-TAB -->
                <div id="all-bookings" class="booking-sub-tab">
                    <table>
                        <thead><tr><th>ID</th><th>Client</th><th>Service</th><th>Location</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($allBookings as $shoot)
                                <tr>
                                    <td>#{{ $shoot->ID }}</td>
                                    <td>{{ $shoot->client->name ?? 'N/A' }}</td>
                                    <td>{{ $shoot->shoot_type }}</td>
                                    <td>{{ $shoot->shoot_location }}</td>
                                    <td><span class="status {{ $shoot->status }}">{{ $shoot->status }}</span></td>
                                    <td>
                                        @if($shoot->status == 'pending')
                                            <div style="display: flex; gap: 8px;">
                                                <form action="{{ route('booking.status') }}" method="POST"><input type="hidden" name="shoot_details_id" value="{{ $shoot->ID }}"><input type="hidden" name="status" value="approved">@csrf<button type="submit" class="action-btn" style="background:#2ecc71; color:white;">Approve</button></form>
                                                <form action="{{ route('booking.status') }}" method="POST"><input type="hidden" name="shoot_details_id" value="{{ $shoot->ID }}"><input type="hidden" name="status" value="rejected">@csrf<button type="submit" class="action-btn" style="background:#ff4d4d; color:white;">Reject</button></form>
                                            </div>
                                        @else
                                            <span style="color: #777;">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" style="text-align:center; padding: 20px;">No bookings found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div id="pending-bookings" class="booking-sub-tab">
                    <table>
                        <thead><tr><th>ID</th><th>Client</th><th>Service</th><th>Location</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($allBookings->where('status', 'pending') as $shoot)
                                <tr>
                                    <td>#{{ $shoot->ID }}</td>
                                    <td>{{ $shoot->client->name ?? 'N/A' }}</td>
                                    <td>{{ $shoot->shoot_type }}</td>
                                    <td>{{ $shoot->shoot_location }}</td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <form action="{{ route('booking.status') }}" method="POST"><input type="hidden" name="shoot_details_id" value="{{ $shoot->ID }}"><input type="hidden" name="status" value="approved">@csrf<button type="submit" class="action-btn" style="background:#2ecc71; color:white;">Approve</button></form>
                                            <form action="{{ route('booking.status') }}" method="POST"><input type="hidden" name="shoot_details_id" value="{{ $shoot->ID }}"><input type="hidden" name="status" value="rejected">@csrf<button type="submit" class="action-btn" style="background:#ff4d4d; color:white;">Reject</button></form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" style="text-align:center; padding: 20px;">No pending bookings.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div id="approved-bookings" class="booking-sub-tab">
                    <table>
                        <thead><tr><th>ID</th><th>Client</th><th>Service</th><th>Location</th></tr></thead>
                        <tbody>
                            @forelse($allBookings->where('status', 'approved') as $shoot)
                                <tr><td>#{{ $shoot->ID }}</td><td>{{ $shoot->client->name ?? 'N/A' }}</td><td>{{ $shoot->shoot_type }}</td><td>{{ $shoot->shoot_location }}</td></tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; padding: 20px;">No approved bookings.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div id="rejected-bookings" class="booking-sub-tab">
                    <table>
                        <thead><tr><th>ID</th><th>Client</th><th>Service</th><th>Location</th></tr></thead>
                        <tbody>
                             @forelse($allBookings->where('status', 'rejected') as $shoot)
                                <tr><td>#{{ $shoot->ID }}</td><td>{{ $shoot->client->name ?? 'N/A' }}</td><td>{{ $shoot->shoot_type }}</td><td>{{ $shoot->shoot_location }}</td></tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; padding: 20px;">No rejected bookings.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- =================== CLIENTS TAB =================== -->
        <div id="clients-tab" class="tab-content">
            <h2>All Clients</h2>
            <div class="toolbar" style="margin-top: 20px;">
                <div class="search-bar" style="max-width: 100%;">
                    <input type="text" id="clients-search" onkeyup="filterClients()" placeholder="Search by Name, Email, or Phone...">
                </div>
            </div>
            <div class="section" style="margin-top: 0;">
                <table id="clients-table">
                    <thead><tr><th>Name</th><th>Phone Number</th><th>Email</th><th>Address</th><th>Source</th></tr></thead>
                    <tbody>
                        @forelse($allClients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->phone_number }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->source }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; padding: 20px;">No clients found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- All JavaScript Logic -->
<script>
    // --- Main Tab Switching ---
    function switchTab(tabId, element, save = true) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
        document.querySelectorAll('.tab-link').forEach(link => link.classList.remove('active'));
        document.getElementById(tabId).style.display = 'block';
        element.classList.add('active');
        if (save) localStorage.setItem('activeAdminTab', tabId);
    }

    // --- Bookings Sub-Tab Switching ---
    function switchBookingTab(status, element) {
        document.querySelectorAll('.booking-sub-tab').forEach(tab => tab.style.display = 'none');
        document.querySelectorAll('.sub-nav a').forEach(link => link.classList.remove('active'));
        document.getElementById(status + '-bookings').style.display = 'block';
        element.classList.add('active');
        localStorage.setItem('activeBookingSubTab', status);
    }

    // --- Search for Bookings ---
    function filterBookings() {
        let input = document.getElementById('bookings-search');
        let filter = input.value.toLowerCase();
        // Updated selector to find all booking tables
        let tables = document.querySelectorAll('#all-bookings table, #pending-bookings table, #approved-bookings table, #rejected-bookings table');

        tables.forEach(table => {
            let tr = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            for (let i = 0; i < tr.length; i++) {
                if (tr[i].getElementsByTagName('td').length <= 1) continue;
                let clientTd = tr[i].getElementsByTagName('td')[1];
                let serviceTd = tr[i].getElementsByTagName('td')[2];
                if (clientTd || serviceTd) {
                    if (clientTd.textContent.toLowerCase().indexOf(filter) > -1 || serviceTd.textContent.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    }

    // --- Search for Clients ---
    function filterClients() {
        let input = document.getElementById('clients-search');
        let filter = input.value.toLowerCase();
        let table = document.getElementById('clients-table');
        let tr = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) {
            if (tr[i].getElementsByTagName('td').length <= 1) continue;
            if (tr[i].textContent.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    // --- On Page Load ---
    document.addEventListener("DOMContentLoaded", function() {
        // Restore main tab
        let activeTab = localStorage.getItem('activeAdminTab') || 'dashboard-tab';
        let activeLinkId = 'nav-' + activeTab.replace('-tab', '');
        switchTab(activeTab, document.getElementById(activeLinkId), false);

        // Restore booking sub-tab
        let activeBookingSubTab = localStorage.getItem('activeBookingSubTab') || 'all';
        let activeSubLinkId = 'sub-nav-' + activeBookingSubTab;
        switchBookingTab(activeBookingSubTab, document.getElementById(activeSubLinkId));

        // Fade out success message
        @if(session('success'))
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.style.display = "none", 500);
                }
            }, 3000);
        @endif
    });
</script>

</body>
</html>