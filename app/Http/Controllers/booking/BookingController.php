<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\SourceMaster;
use App\Models\ShootMaster;
use App\Models\ShootDetail;
use App\Models\RequirementMaster; // <--- Added this

class BookingController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }

    /**
     * Handle the Booking Form Steps
     */
    public function create(Request $request)
    {
        // 1. Fetch Data for Dropdowns
        $sources = SourceMaster::all();
        $requirements = RequirementMaster::all(); // <--- Fetch Requirements instead of ShootTypes

        // 2. Initialize View Variables
        $client = null;
        $phone = $request->input('phone_check'); // Get phone from Step 1 input
        $step = 1; // Default to Step 1

        // 3. Logic: If phone is provided, move to Step 2
        if ($phone) {
            $step = 2; 
            // Search for existing client in DB
            $client = Client::where('phone_number', $phone)->first();
        }

        return view('booking.create', compact('sources', 'requirements', 'client', 'phone', 'step'));
    }

    /**
     * Store the Booking Data
     */
    public function store(Request $request)
    {
        // SCENARIO A: EXISTING CLIENT (We found them in Step 2)
        if ($request->filled('existing_client_id')) {
            
            // Validate: Only Address (editable) + Shoot Details
            $request->validate([
                'address'        => 'required|string',
                'shoot_type'     => 'required',
                'shoot_location' => 'required|string',
            ]);

            // Update Existing Client Address
            $client = Client::find($request->existing_client_id);
            
            if ($client) {
                $client->address = $request->address; // Update address
                $client->save();
                $clientId = $client->ID;
            } else {
                return redirect()->back()->with('error', 'Client record not found.');
            }

        // SCENARIO B: NEW CLIENT
        } else {
            
            // Validate: All Fields
            $request->validate([
                'name'           => 'required|string|max:255',
                'ph_no'          => 'required|digits:10',
                'email'          => 'required|email|max:55',
                'address'        => 'required|string',
                'source'         => 'required',
                'shoot_type'     => 'required',
                'shoot_location' => 'required|string',
            ],[
                'ph_no.digits' => 'The phone number must be exactly 10 digits.',
            ]);

            // Create New Client
            $client = Client::create([
                'name'         => $request->name,
                'phone_number' => $request->ph_no,
                'email'        => $request->email,
                'address'      => $request->address,
                'source'       => $request->source,
            ]);

            $clientId = $client->ID;
        }

        // 3. Save Shoot Details (Linked to Client ID)
        ShootDetail::create([
            'client_id'      => $clientId,
            'shoot_type'     => $request->shoot_type,
            'shoot_location' => $request->shoot_location,
        ]);

        // 4. Redirect
        return redirect()->route('booking.create')->with('success', 'Booking submitted successfully!');
    }

    /**
     * AJAX Search for Cities
     */
    public function searchCities(Request $request)
    {
        $query = $request->get('query');
        
        if ($query) {
            // Search the 'cities' table
            $cities = DB::table('cities')
                ->where('city', 'LIKE', "%{$query}%")
                ->limit(10) // Limit results for performance
                ->get();
                
            return response()->json($cities);
        }
        
        return response()->json([]);
    }

    /**
     * AJAX Get Shoot Types based on Requirement ID
     */
    public function getShootTypes($id)
    {
        $shootTypes = ShootMaster::where('requirements_id', $id)->get();
        return response()->json($shootTypes);
    }
}