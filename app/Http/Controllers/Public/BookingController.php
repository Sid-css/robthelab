<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;


class BookingController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }
    public function create()
    {
        return view('booking.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ph_no' => 'required|string|max:15',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        Client::create($request->only([
            'name', 'ph_no', 'email', 'address'
        ]));

        return redirect()->back()->with('success', 'Booking submitted successfully!');
    }
}

// class BookingController extends Controller
// {
//     public function landing()
//     {
//         return view('public.landing');
//     }

//     public function create()
//     {
//         return view('public.booking.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'date' => 'required|date',
    //         'time' => 'required|string|max:10',
    //         'service' => 'required|string|max:255',
    //     ]);

        // Logic to store booking in the database would go here

//         return redirect()->route('landing')->with('success', 'Booking created successfully!');
//     }
// }
