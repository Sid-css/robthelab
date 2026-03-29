<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class OtpPasswordResetController extends Controller
{
    // 1. Generate and Send OTP
    public function sendOtp(Request $request)
    {
        // Validate the email exists in the database
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999); // Generate 6-digit OTP

        // Save OTP in cache for 15 minutes
        Cache::put('otp_' . $email, $otp, now()->addMinutes(15));
        
        // Save the email in the session so we know who is verifying
        session(['reset_email' => $email]);

        // Send Email (Using simple raw text mail for now)
        Mail::raw("Your Password Reset OTP is: $otp. It is valid for 15 minutes.", function ($message) use ($email) {
            $message->to($email)->subject('RobtheLabStudios - Password Reset OTP');
        });

        return redirect()->route('password.verify.otp.form')->with('status', 'An OTP has been sent to your email.');
    }

    // 2. Show the OTP Verification Form
    public function showVerifyForm()
    {
        // Protect the route: Only users who requested an OTP can see this page
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    // 3. Verify the OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $email = session('reset_email');
        
        $cachedOtp = Cache::get('otp_' . $email);
        
        if ($cachedOtp && $cachedOtp == $request->otp) {
            // OTP is correct! Set a session flag to allow password change
            session(['otp_verified' => true]);
            Cache::forget('otp_' . $email); // Delete OTP securely after use
            
            return redirect()->route('password.reset.otp.form');
        }
        
        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    // 4. Show the New Password Form
    public function showResetForm()
    {
        // Protect the route: Only users who verified the OTP can see this page
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-otp');
    }

    // 5. Save the New Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        
        $email = session('reset_email');
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        
        // Clear all reset sessions to maintain security
        session()->forget(['reset_email', 'otp_verified']);
        
        return redirect()->route('login')->with('status', 'Password has been successfully changed! Please log in.');
    }
    // 0. Show the initial Forgot Password Form
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }
}