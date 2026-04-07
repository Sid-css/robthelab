<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the custom login view
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login attempt
    public function login(Request $request)
    {
        // 1. Validate the form data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to dashboard (or wherever they tried to go)
            return redirect()->intended('/dashboard');
        }

        // 3. If login fails, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to homepage
        return redirect('/');
    }
}