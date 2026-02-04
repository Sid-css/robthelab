<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalClients'   => Client::count(),
            'totalBookings'  => Booking::count(),
            'pendingBookings'=> Booking::where('status', 'pending')->count(),
            'approvedBookings'=> Booking::where('status', 'approved')->count(),
            'recentBookings' => Booking::latest()->take(5)->get()
        ]);
    }
}
