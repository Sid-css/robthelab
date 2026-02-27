<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ShootDetail;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Get Totals
        $totalClients  = Client::count();
        $totalBookings = ShootDetail::count();

        // 2. Count Status directly from the table
        $pendingRequests = ShootDetail::where('status', 'pending')->count();
        $approvedRequests = ShootDetail::where('status', 'approved')->count();

        // 3. Fetch Recent Bookings (For the main Dashboard screen)
        $recentBookings = ShootDetail::with('client')
            ->orderBy('ID', 'desc')
            ->take(5)
            ->get();

        // 4. Fetch ALL Bookings (For the new Bookings Tab)
        $allBookings = ShootDetail::with('client')
            ->orderBy('ID', 'desc')
            ->get();

              // 5. Fetch All Clients (NEW)
        $allClients = Client::orderBy('ID', 'desc')->get();

        return view('admin.dashboard', compact(
            'totalClients',
            'totalBookings',
            'pendingRequests',
            'approvedRequests',
            'recentBookings',
            'allBookings',// <--- Added this
            'allClients'
        ));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'shoot_details_id' => 'required|integer|exists:shoot_details,ID',
            'status'           => 'required|in:approved,rejected',
        ]);

        $shoot = ShootDetail::findOrFail($request->shoot_details_id);
        $shoot->status = $request->status;
        $shoot->save();

        return back()->with('success', 'Booking status updated successfully!');
    }
}