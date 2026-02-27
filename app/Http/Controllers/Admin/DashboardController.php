<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ShootDetail;
use Illuminate\Support\Facades\DB;

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

        // 3. Fetch Recent Bookings (For Dashboard screen)
        $recentBookings = ShootDetail::with('client')->orderBy('ID', 'desc')->take(5)->get();

        // 4. Fetch ALL Bookings (For Bookings Tab)
        $allBookings = ShootDetail::with('client')->orderBy('ID', 'desc')->get();

        // 5. Fetch ALL Clients (For Clients Tab)
        $allClients = Client::orderBy('ID', 'desc')->get();

        // 6. Data for Shoot Type Chart (Bar Chart)
        $shootTypeData = ShootDetail::query()
            ->select('shoot_type', DB::raw('count(*) as total'))
            ->groupBy('shoot_type')
            ->orderBy('total', 'desc')
            ->get();
        $shootTypeLabels = $shootTypeData->pluck('shoot_type');
        $shootTypeCounts = $shootTypeData->pluck('total');

        // 7. Data for Client Source Chart (Doughnut Chart)
        $clientSourceData = Client::query()
            ->select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->orderBy('total', 'desc')
            ->get();
        $clientSourceLabels = $clientSourceData->pluck('source');
        $clientSourceCounts = $clientSourceData->pluck('total');

        return view('admin.dashboard', compact(
            'totalClients',
            'totalBookings',
            'pendingRequests',
            'approvedRequests',
            'recentBookings',
            'allBookings',
            'allClients',
            'shootTypeLabels', 
            'shootTypeCounts',
            'clientSourceLabels', // Passed to view
            'clientSourceCounts'  // Passed to view
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