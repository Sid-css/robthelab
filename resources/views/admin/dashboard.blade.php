<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RobtheLab Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* CSS Variables for Theming */
        :root {
            --bg-main: #0f0f14;
            --bg-sidebar: #151521;
            --bg-card: #1c1c2b;
            --bg-table-header: #23233a;
            --bg-sub-nav: #2a2a40;
            --text-primary: #ffffff;
            --text-secondary: #ccc;
            --accent-primary: #ffb703;
            --accent-primary-text: #000;
            --border-color: #2a2a40;
            --shadow-color: rgba(0,0,0,0.4);
        }
        body.light-mode {
            --bg-main: #f0f2f5;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --bg-table-header: #e9ecef;
            --bg-sub-nav: #e9ecef;
            --text-primary: #1c1c2b;
            --text-secondary: #555;
            --border-color: #dee2e6;
            --shadow-color: rgba(0,0,0,0.1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: var(--bg-main); color: var(--text-primary); transition: background-color 0.3s, color 0.3s; }
        .dashboard { display: flex; min-height: 100vh; }
        
        .sidebar { width: 260px; background: var(--bg-sidebar); padding: 30px 20px; flex-shrink: 0; transition: background-color 0.3s; border-right: 1px solid var(--border-color); }
        .sidebar h2 { text-align: center; font-size: 22px; margin-bottom: 40px; letter-spacing: 1px; color: var(--accent-primary); }
        .sidebar a { display: block; padding: 12px 15px; margin-bottom: 10px; color: var(--text-secondary); text-decoration: none; border-radius: 8px; transition: 0.3s; cursor: pointer; }
        .sidebar a:hover, .sidebar a.active { background: var(--accent-primary); color: var(--accent-primary-text); }

        .main { flex: 1; padding: 40px; overflow-x: auto;}
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .logout { background: #ff4d4d; border: none; padding: 10px 20px; color: #fff; border-radius: 6px; cursor: pointer; font-size: 14px; }
        .alert-success { background: #2ecc71; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background: #ff4d4d; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-warning { background: #ffb703; color: #000; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-info { background: #3498db; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-close { float: right; cursor: pointer; font-size: 18px; font-weight: bold; }

        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; }
        .card { background: var(--bg-card); padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px var(--shadow-color); transition: background-color 0.3s; }
        .card h3 { font-size: 16px; margin-bottom: 10px; color: var(--text-secondary); }
        .cards .card p { font-size: 32px; font-weight: 600; color: var(--accent-primary); }
        
        .charts-wrapper { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; margin-top: 50px; }
        .charts-wrapper .section { margin-top: 0; }

        .section { margin-top: 50px; }
        .section h2 { font-size: 22px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: var(--bg-card); border-radius: 10px; overflow: hidden; transition: background-color 0.3s; box-shadow: 0 5px 15px var(--shadow-color); }
        table th, table td { padding: 14px 16px; text-align: left; font-size: 14px; }
        table th { background: var(--bg-table-header); color: var(--accent-primary); transition: background-color 0.3s; }
        table tr { border-bottom: 1px solid var(--border-color); transition: border-color 0.3s; }
        .status { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; display: inline-block; text-transform: capitalize; }
        .pending { background: #ffb703; color: #000; }
        .approved { background: #2ecc71; color: #000; }
        .rejected { background: #ff4d4d; color: #fff; }
        .action-btn { border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 14px; }

        .tab-content { display: none; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 20px; flex-wrap: wrap; }
        .sub-nav { display: flex; gap: 10px; }
        .sub-nav a { padding: 8px 16px; background: var(--bg-sub-nav); color: var(--text-secondary); text-decoration: none; border-radius: 6px; font-size: 14px; cursor: pointer; transition: background-color 0.3s, color 0.3s;}
        .sub-nav a.active, .sub-nav a:hover { background: var(--accent-primary); color: var(--accent-primary-text); }
        .search-bar { flex-grow: 1; min-width: 250px; }
        .search-bar input { width: 100%; padding: 8px 12px; background: var(--bg-sub-nav); border: 1px solid var(--border-color); color: var(--text-primary); border-radius: 6px; font-size: 14px; transition: background-color 0.3s, border-color 0.3s; }
        .theme-toggle { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 6px; padding: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        .theme-toggle svg { width: 20px; height: 20px; color: var(--text-secondary); transition: color 0.3s; }
        .light-mode .moon-icon { display: none; }
        .dark-mode .sun-icon { display: none; }

        /* Pagination Styles */
        .pagination-container { display: flex; justify-content: flex-end; gap: 5px; margin-top: 15px; }
        .page-btn { background: var(--bg-sub-nav); color: var(--text-secondary); border: 1px solid var(--border-color); padding: 5px 12px; border-radius: 4px; cursor: pointer; transition: 0.3s; font-size: 14px; }
        .page-btn:hover, .page-btn.active { background: var(--accent-primary); color: var(--accent-primary-text); border-color: var(--accent-primary); }
    </style>
</head>
<body class="dark-mode">

<div class="dashboard">
    <div class="sidebar">
        <h2>RobtheLab</h2>
        <a id="nav-dashboard" class="tab-link" onclick="switchTab('dashboard-tab', this)">Dashboard</a>
        <a id="nav-bookings" class="tab-link" onclick="switchTab('bookings-tab', this)">Bookings</a>
        <a id="nav-clients" class="tab-link" onclick="switchTab('clients-tab', this)">Clients</a>
        <a href="#">Availability</a>
        <a id="nav-settings" class="tab-link" onclick="switchTab('settings-tab', this)">Settings</a>
    </div>

    <div class="main">
        <div class="topbar">
            <h1>Welcome, {{ Auth::user()->name ?? 'Admin' }} 👋</h1>
            <div style="display: flex; align-items: center; gap: 20px;">
                <button id="theme-toggle" class="theme-toggle" title="Toggle Theme">
                    <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 18a6 6 0 1 1 0-12 6 6 0 0 1 0 12ZM11 1h2v3h-2V1Zm0 19h2v3h-2v-3ZM3.55 4.95l1.414-1.414L7.05 5.636 5.636 7.05 3.55 4.95ZM16.95 18.364l1.414-1.414L20.45 19.05l-1.414 1.414-2.086-2.086ZM1 11v2h3v-2H1Zm19 0v2h3v-2h-3ZM5.636 16.95l1.414 1.414L4.95 20.45l-1.414-1.414 2.086-2.086ZM19.05 7.05l1.414-1.414L18.364 3.55 16.95 4.95l2.1 2.1Z"/></svg>
                    <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10 7a7 7 0 0 0 12 4.9v.1c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2h.1A6.979 6.979 0 0 0 10 7Z"/></svg>
                </button>
                <form method="POST" action="{{ route('logout') }}"><button class="logout">Logout</button>@csrf</form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success" id="success-alert">
                <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error" id="error-alert">
                <span class="alert-close" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- =================== DASHBOARD TAB =================== -->
        <div id="dashboard-tab" class="tab-content">
            <div class="cards">
                <div class="card"><h3>Total Clients</h3><p>{{ $totalClients }}</p></div>
                <div class="card"><h3>Total Bookings</h3><p>{{ $totalBookings }}</p></div>
                <div class="card"><h3>Pending Requests</h3><p>{{ $pendingRequests }}</p></div>
                <div class="card"><h3>Approved</h3><p>{{ $approvedRequests }}</p></div>
            </div>

            <div class="charts-wrapper">
                <div class="section">
                    <h2>Bookings by Service</h2>
                    <div class="card" style="height: 350px;">
                        <canvas id="shootTypeChart"></canvas>
                    </div>
                </div>
                
                <div class="section">
                    <h2>Client Sources</h2>
                    <div class="card" style="height: 350px; display: flex; justify-content: center; align-items: center;">
                        <canvas id="clientSourceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>Recent Booking Requests</h2>
                <table id="table-recent">
                    <thead><tr><th>S.No.</th><th>ID</th><th>Client</th><th>Service</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        @forelse($recentBookings as $shoot)
                            <tr>
                                <td>{{ $loop->remaining + 1 }}</td>
                                <td>{{ $shoot->booking_id ?? '#' . $shoot->ID }}</td>
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
                            <tr class="empty-row"><td colspan="6" style="text-align:center; padding: 20px;">No recent bookings found.</td></tr>
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
                    <a id="sub-nav-all" onclick="switchBookingTab('all', this)">All</a>
                    <a id="sub-nav-pending" onclick="switchBookingTab('pending', this)">Pending</a>
                    <a id="sub-nav-approved" onclick="switchBookingTab('approved', this)">Approved</a>
                    <a id="sub-nav-rejected" onclick="switchBookingTab('rejected', this)">Rejected</a>
                </div>
                <div class="search-bar">
                    <input type="text" id="bookings-search" onkeyup="filterBookings()" placeholder="Search by Client or Service...">
                </div>
            </div>

            <div class="section" style="margin-top: 0;">
                <div id="all-bookings" class="booking-sub-tab">
                    <table id="table-all-bookings">
                        <thead><tr><th>S.No.</th><th>ID</th><th>Client</th><th>Service</th><th>Location</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($allBookings as $shoot)
                                <tr>
                                    <td>{{ $loop->remaining + 1 }}</td>
                                    <td>{{ $shoot->booking_id ?? '#' . $shoot->ID }}</td>
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
                                        @else<span style="color: #777;">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="empty-row"><td colspan="7" style="text-align:center; padding: 20px;">No bookings found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="pending-bookings" class="booking-sub-tab">
                    <table id="table-pending">
                        <thead><tr><th>S.No.</th><th>ID</th><th>Client</th><th>Service</th><th>Location</th><th>Action</th></tr></thead>
                        <tbody>
                            @forelse($allBookings->where('status', 'pending') as $shoot)
                                <tr>
                                    <td>{{ $loop->remaining + 1 }}</td>
                                    <td>{{ $shoot->booking_id ?? '#' . $shoot->ID }}</td>
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
                                <tr class="empty-row"><td colspan="6" style="text-align:center; padding: 20px;">No pending bookings.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="approved-bookings" class="booking-sub-tab">
                    <table id="table-approved">
                        <thead><tr><th>S.No.</th><th>ID</th><th>Client</th><th>Service</th><th>Location</th></tr></thead>
                        <tbody>
                            @forelse($allBookings->where('status', 'approved') as $shoot)
                                <tr>
                                    <td>{{ $loop->remaining + 1 }}</td>
                                    <td>{{ $shoot->booking_id ?? '#' . $shoot->ID }}</td>
                                    <td>{{ $shoot->client->name ?? 'N/A' }}</td>
                                    <td>{{ $shoot->shoot_type }}</td>
                                    <td>{{ $shoot->shoot_location }}</td>
                                </tr>
                            @empty
                                <tr class="empty-row"><td colspan="5" style="text-align:center; padding: 20px;">No approved bookings.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div id="rejected-bookings" class="booking-sub-tab">
                    <table id="table-rejected">
                        <thead><tr><th>S.No.</th><th>ID</th><th>Client</th><th>Service</th><th>Location</th></tr></thead>
                        <tbody>
                             @forelse($allBookings->where('status', 'rejected') as $shoot)
                                <tr>
                                    <td>{{ $loop->remaining + 1 }}</td>
                                    <td>{{ $shoot->booking_id ?? '#' . $shoot->ID }}</td>
                                    <td>{{ $shoot->client->name ?? 'N/A' }}</td>
                                    <td>{{ $shoot->shoot_type }}</td>
                                    <td>{{ $shoot->shoot_location }}</td>
                                </tr>
                            @empty
                                <tr class="empty-row"><td colspan="5" style="text-align:center; padding: 20px;">No rejected bookings.</td></tr>
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
                    <thead><tr><th>S.No.</th><th>Name</th><th>Phone Number</th><th>Email</th><th>Address</th><th>Source</th></tr></thead>
                    <tbody>
                        @forelse($allClients as $client)
                            <tr>
                                <td>{{ $loop->remaining + 1 }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->phone_number }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ $client->source }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row"><td colspan="6" style="text-align:center; padding: 20px;">No clients found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- =================== SETTINGS TAB =================== -->
        <div id="settings-tab" class="tab-content">
            <h2>Account Settings</h2>

            <div style="display:flex; gap:25px; flex-wrap:wrap; margin-top:20px;">

                <div class="card" style="max-width:350px; flex:1;">
                    <h3 style="margin-bottom:15px;">Profile Information</h3>
                    <p style="margin-bottom:10px;"><strong>Name:</strong><br>{{ Auth::user()->name }}</p>
                    <p style="margin-bottom:10px;"><strong>Email:</strong><br>{{ Auth::user()->email }}</p>
                    <p style="color:var(--text-secondary); font-size:13px;">Your login credentials are linked to this account.</p>
                </div>

                <div class="card" style="max-width:450px; flex:1;">
                    <h3 style="margin-bottom:20px;">Change Password</h3>
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf
                        <div style="margin-bottom:15px;">
                            <label style="display:block; margin-bottom:6px;">Old Password</label>
                            <input type="password" name="old_password" required style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color); background:var(--bg-sub-nav); color:var(--text-primary);">
                        </div>
                        <div style="margin-bottom:15px;">
                            <label style="display:block; margin-bottom:6px;">New Password</label>
                            <input type="password" name="new_password" required style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color); background:var(--bg-sub-nav); color:var(--text-primary);">
                        </div>
                        <div style="margin-bottom:20px;">
                            <label style="display:block; margin-bottom:6px;">Confirm Password</label>
                            <input type="password" name="new_password_confirmation" required style="width:100%; padding:10px; border-radius:6px; border:1px solid var(--border-color); background:var(--bg-sub-nav); color:var(--text-primary);">
                        </div>
                        <button type="submit" class="action-btn" style="background:#2ecc71; color:white; padding:10px 20px;">Update Password</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // --- JS Pagination Class ---
    class TableManager {
        constructor(tableId, rowsPerPage) {
            this.table = document.getElementById(tableId);
            if (!this.table) return;
            
            this.tbody = this.table.querySelector('tbody');
            this.allRows = Array.from(this.tbody.querySelectorAll('tr'));
            
            // Ignore if table is empty
            if (this.allRows.length === 1 && this.allRows[0].classList.contains('empty-row')) return;
            
            this.filteredRows = [...this.allRows];
            this.rowsPerPage = rowsPerPage;
            this.currentPage = 1;
            
            this.paginationContainer = document.createElement('div');
            this.paginationContainer.className = 'pagination-container';
            this.table.parentNode.insertBefore(this.paginationContainer, this.table.nextSibling);
            
            this.render();
        }
        
        search(query) {
            query = query.toLowerCase();
            this.filteredRows = this.allRows.filter(row => {
                return row.textContent.toLowerCase().includes(query);
            });
            this.currentPage = 1;
            this.render();
        }
        
        render() {
            this.allRows.forEach(row => row.style.display = 'none');
            
            let noResults = this.tbody.querySelector('.no-results-row');
            if (this.filteredRows.length === 0) {
                if (!noResults) {
                    noResults = document.createElement('tr');
                    noResults.className = 'no-results-row';
                    const colCount = this.table.querySelector('thead tr').children.length;
                    noResults.innerHTML = `<td colspan="${colCount}" style="text-align:center; padding: 20px; color: #888;">No matching records found.</td>`;
                    this.tbody.appendChild(noResults);
                }
                noResults.style.display = '';
                this.paginationContainer.innerHTML = '';
                return;
            } else {
                if (noResults) noResults.style.display = 'none';
            }
            
            const totalPages = Math.ceil(this.filteredRows.length / this.rowsPerPage);
            const start = (this.currentPage - 1) * this.rowsPerPage;
            const end = start + this.rowsPerPage;
            
            this.filteredRows.slice(start, end).forEach(row => row.style.display = '');
            
            this.paginationContainer.innerHTML = '';
            if (totalPages > 1) {
                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.className = i === this.currentPage ? 'page-btn active' : 'page-btn';
                    btn.onclick = (e) => {
                        e.preventDefault();
                        this.currentPage = i;
                        this.render();
                    };
                    this.paginationContainer.appendChild(btn);
                }
            }
        }
    }

    // --- Global Variables ---
    let tableManagers = {};
    const themeToggle = document.getElementById('theme-toggle');
    let barChartInstance = null;
    let doughnutChartInstance = null;

    // --- Theme Logic ---
    function applyTheme(theme) {
        if (theme === 'light') { document.body.classList.add('light-mode'); document.body.classList.remove('dark-mode'); } 
        else { document.body.classList.remove('light-mode'); document.body.classList.add('dark-mode'); }
        
        if(barChartInstance && doughnutChartInstance) {
            const isLight = theme === 'light';
            const gridColor = isLight ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.1)';
            const labelColor = isLight ? '#333' : '#ccc';

            barChartInstance.options.scales.x.ticks.color = labelColor;
            barChartInstance.options.scales.y.ticks.color = labelColor;
            barChartInstance.options.scales.y.grid.color = gridColor;
            barChartInstance.update();

            doughnutChartInstance.options.plugins.legend.labels.color = labelColor;
            doughnutChartInstance.update();
        }
    }

    themeToggle.addEventListener('click', () => {
        const newTheme = document.body.classList.contains('light-mode') ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    });

    // --- Tab Logic ---
    function switchTab(tabId, element, save = true) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
        document.querySelectorAll('.tab-link').forEach(link => link.classList.remove('active'));
        document.getElementById(tabId).style.display = 'block';
        element.classList.add('active');
        if (save) localStorage.setItem('activeAdminTab', tabId);
    }

    function switchBookingTab(status, element) {
        document.querySelectorAll('.booking-sub-tab').forEach(tab => tab.style.display = 'none');
        document.querySelectorAll('.sub-nav a').forEach(link => link.classList.remove('active'));
        document.getElementById(status + '-bookings').style.display = 'block';
        element.classList.add('active');
        localStorage.setItem('activeBookingSubTab', status);
    }

    // --- Search Logic (Now connected to Pagination) ---
    function filterBookings() {
        let filter = document.getElementById('bookings-search').value;
        if(tableManagers['all']) tableManagers['all'].search(filter);
        if(tableManagers['pending']) tableManagers['pending'].search(filter);
        if(tableManagers['approved']) tableManagers['approved'].search(filter);
        if(tableManagers['rejected']) tableManagers['rejected'].search(filter);
    }

    function filterClients() {
        let filter = document.getElementById('clients-search').value;
        if(tableManagers['clients']) tableManagers['clients'].search(filter);
    }

    // --- On Page Load ---
    document.addEventListener("DOMContentLoaded", function() {
        // Init Pagination for 10 rows per page
        tableManagers['all'] = new TableManager('table-all-bookings', 10);
        tableManagers['pending'] = new TableManager('table-pending', 10);
        tableManagers['approved'] = new TableManager('table-approved', 10);
        tableManagers['rejected'] = new TableManager('table-rejected', 10);
        tableManagers['clients'] = new TableManager('clients-table', 10);

        // Restore theme
        applyTheme(localStorage.getItem('theme') || 'dark');

        // Restore main tab
        let activeTab = localStorage.getItem('activeAdminTab') || 'dashboard-tab';
        switchTab(activeTab, document.getElementById('nav-' + activeTab.replace('-tab', '')), false);

        // Restore booking sub-tab
        let activeBookingSubTab = localStorage.getItem('activeBookingSubTab') || 'all';
        switchBookingTab(activeBookingSubTab, document.getElementById('sub-nav-' + activeBookingSubTab));

        // Fade out success message
        @if(session('success'))
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease"; alert.style.opacity = "0";
                    setTimeout(() => alert.style.display = "none", 500);
                }
            }, 3000);
        @endif

        // Fade out error message
        @if($errors->any())
            setTimeout(() => {
                const alert = document.getElementById('error-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease"; alert.style.opacity = "0";
                    setTimeout(() => alert.style.display = "none", 500);
                }
            }, 5000);
        @endif

        // --- Render Charts ---
        const isLight = document.body.classList.contains('light-mode');
        const gridColor = isLight ? 'rgba(0, 0, 0, 0.1)' : 'rgba(255, 255, 255, 0.1)';
        const labelColor = isLight ? '#333' : '#ccc';

        const shootTypeCtx = document.getElementById('shootTypeChart');
        if (shootTypeCtx) {
            barChartInstance = new Chart(shootTypeCtx, {
                type: 'bar', data: { labels: @json($shootTypeLabels), datasets:[{ label: '# of Bookings', data: @json($shootTypeCounts), backgroundColor: 'rgba(255, 183, 3, 0.5)', borderColor: 'rgba(255, 183, 3, 1)', borderWidth: 1, borderRadius: 4 }] },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { color: labelColor, stepSize: 1 }, grid: { color: gridColor } }, x: { ticks: { color: labelColor }, grid: { display: false } } }, plugins: { legend: { display: false } } }
            });
        }

        const clientSourceCtx = document.getElementById('clientSourceChart');
        if (clientSourceCtx) {
            doughnutChartInstance = new Chart(clientSourceCtx, {
                type: 'doughnut', data: { labels: @json($clientSourceLabels), datasets:[{ data: @json($clientSourceCounts), backgroundColor:['#ffb703','#2ecc71','#3498db','#e74c3c','#9b59b6','#f1c40f'], borderWidth: 0, hoverOffset: 4 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { color: labelColor, padding: 20 } } }, cutout: '65%' }
            });
        }
    });
</script>

</body>
</html>