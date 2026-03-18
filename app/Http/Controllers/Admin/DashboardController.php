<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ShootDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
 
        $totalClients  = Client::count();
        $totalBookings = ShootDetail::count();
 
        $pendingRequests = ShootDetail::where('status', 'pending')->count();
        $approvedRequests = ShootDetail::where('status', 'approved')->count();

        $recentBookings = ShootDetail::with('client')
            ->orderBy('ID', 'desc')
            ->take(5)
            ->get();
 
        $allBookings = ShootDetail::with('client')
            ->orderBy('ID', 'desc')
            ->get();
 
        $allClients = Client::orderBy('ID', 'desc')->get();
 
        $shootTypeData = ShootDetail::query()
            ->select('shoot_type', DB::raw('count(*) as total'))
            ->groupBy('shoot_type')
            ->orderBy('total', 'desc')
            ->get();

        $shootTypeLabels = $shootTypeData->pluck('shoot_type');
        $shootTypeCounts = $shootTypeData->pluck('total');
 
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
            'clientSourceLabels',
            'clientSourceCounts'
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

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' =>['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'old_password.current_password' => 'The provided old password does not match your current password.'
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Your password has been changed successfully!');
    }
}