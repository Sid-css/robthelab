<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RobtheLab Studio</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #0f0f14;
            color: #ffffff;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #151521;
            padding: 30px 20px;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 40px;
            letter-spacing: 1px;
            color: #ffb703;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            margin-bottom: 10px;
            color: #ccc;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #ffb703;
            color: #000;
        }

        /* Main Content */
        .main {
            flex: 1;
            padding: 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .topbar h1 {
            font-size: 26px;
            font-weight: 500;
        }

        .logout {
            background: #ff4d4d;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        /* Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .card {
            background: #1c1c2b;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #bbb;
        }

        .card p {
            font-size: 32px;
            font-weight: 600;
            color: #ffb703;
        }

        /* Table */
        .section {
            margin-top: 50px;
        }

        .section h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #1c1c2b;
            border-radius: 10px;
            overflow: hidden;
        }

        table th, table td {
            padding: 14px 16px;
            text-align: left;
            font-size: 14px;
        }

        table th {
            background: #23233a;
            color: #ffb703;
        }

        table tr {
            border-bottom: 1px solid #2a2a40;
        }

        table tr:last-child {
            border-bottom: none;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .pending {
            background: #ffb703;
            color: #000;
        }

        .approved {
            background: #2ecc71;
            color: #000;
        }

        .rejected {
            background: #ff4d4d;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>RobtheLab</h2>
        <a href="#" class="active">Dashboard</a>
        <a href="#">Bookings</a>
        <a href="#">Clients</a>
        <a href="#">Availability</a>
        <a href="#">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main">

        <!-- Topbar -->
        <div class="topbar">
            <h1>Welcome, Admin 👋</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout">Logout</button>
            </form>
        </div>

        <!-- Stats -->
        <div class="cards">
            <div class="card">
                <h3>Total Clients</h3>
                <p>128</p>
            </div>
            <div class="card">
                <h3>Total Bookings</h3>
                <p>86</p>
            </div>
            <div class="card">
                <h3>Pending Requests</h3>
                <p>12</p>
            </div>
            <div class="card">
                <h3>Approved</h3>
                <p>64</p>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="section">
            <h2>Recent Booking Requests</h2>
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>Wedding Shoot</td>
                        <td>12 Feb 2026</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>Studio X</td>
                        <td>Promo Video</td>
                        <td>15 Feb 2026</td>
                        <td><span class="status approved">Approved</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
