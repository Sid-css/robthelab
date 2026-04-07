<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\SourceMaster;
use App\Models\ShootMaster;
use App\Models\ShootDetail;
use App\Models\RequirementMaster;

class BookingController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }

    public function create(Request $request)
    {
        $sources = SourceMaster::all();
        $requirements = RequirementMaster::all();

        $client = null;
        $phone = $request->input('phone_check');
        $step = 1;

        if ($phone) {
            $step = 2; 
            $client = Client::where('phone_number', $phone)->first();
        }

        return view('booking.create', compact('sources', 'requirements', 'client', 'phone', 'step'));
    }

    public function store(Request $request)
    {
        if ($request->filled('existing_client_id')) {
            $request->validate([
                'address'        => 'required|string',
                'shoot_type'     => 'required',
                'shoot_location' => 'required|string',
            ]);

            $client = Client::find($request->existing_client_id);
            if ($client) {
                $client->address = $request->address;
                $client->save();
                $clientId = $client->ID;
            } else {
                return redirect()->back()->with('error', 'Client record not found.');
            }
        } else {
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

            $client = Client::create([
                'name'         => $request->name,
                'phone_number' => $request->ph_no,
                'email'        => $request->email,
                'address'      => $request->address,
                'source'       => $request->source,
            ]);

            $clientId = $client->ID;
        }

        // 1. Create the Shoot Details first to get the database auto-increment ID
        $shoot = ShootDetail::create([
            'client_id'      => $clientId,
            'shoot_type'     => $request->shoot_type,
            'shoot_location' => $request->shoot_location,
        ]);

        // 2. Generate Booking ID (e.g. ROB + 0001)
        // str_pad adds zeros to the left so it's always at least 4 digits long
        $bookingId = 'ROB' . str_pad($shoot->ID, 4, '0', STR_PAD_LEFT);
        
        // 3. Update the row with the new booking ID
        $shoot->update(['booking_id' => $bookingId]);

        // 4. Pass the booking_id to the session so we can show it to the user
        return redirect()->route('booking.create')->with([
            'success' => 'Booking submitted successfully!',
            'booking_id' => $bookingId
        ]);
    }

    public function searchCities(Request $request)
    {
        $query = $request->get('query');
        if ($query) {
            $cities = DB::table('cities')
                ->where('city', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get();
            return response()->json($cities);
        }
        return response()->json([]);
    }

    public function getShootTypes($id)
    {
        $shootTypes = ShootMaster::where('requirements_id', $id)->get();
        return response()->json($shootTypes);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10'
        ]);

        $client = Client::where('phone_number', $request->phone)->first();

        if (!$client) {
            return response()->json(['success' => false, 'message' => 'No bookings found for this phone number.']);
        }

        // Fetch bookings, making sure we include the 'booking_id' column
        $bookings = ShootDetail::where('client_id', $client->ID)
            ->orderBy('ID', 'desc')
            ->get(['ID', 'booking_id', 'shoot_type', 'shoot_location', 'status']);

        if ($bookings->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No bookings found for this phone number.']);
        }

        return response()->json([
            'success' => true,
            'client_name' => $client->name,
            'bookings' => $bookings
        ]);
    }
}