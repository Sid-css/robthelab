<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;     // Added for database queries
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;                     // Added for handling DateTimes

class OtpPasswordResetController extends Controller
{
    // 0. Show the initial Forgot Password Form
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // 1. Generate and Send OTP
    public function sendOtp(Request $request)
    {
        // Validate the email exists in the database
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999); // Generate 6-digit OTP
        $expiredAt = Carbon::now()->addMinutes(15);

        // Save OTP in your custom `otp_details` table
        DB::table('otp_details')->updateOrInsert(
            ['Username' => $email], [
                'OTP' => $otp,
                'Created_At' => Carbon::now(),
                'Expired_At' => $expiredAt
            ] // Insert or update these values
        );
        
        // Save the email in the session so we know who is verifying
        session(['reset_email' => $email]);

        // Send Email
        Mail::raw("Your Password Reset OTP is: $otp. It is valid for 15 minutes.", function ($message) use ($email) {
            $message->to($email)->subject('RobtheLabStudios - Password Reset OTP');
        });

        return redirect()->route('password.verify.otp.form')->with('status', 'An OTP has been sent to your email.');
    }

    // 2. Show the OTP Verification Form
    public function showVerifyForm()
    {
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
        
        // Fetch the OTP record from your custom table
        $otpRecord = DB::table('otp_details')->where('Username', $email)->first();
        
        if ($otpRecord && $otpRecord->OTP == $request->otp) {
            
            // Check if the OTP is expired
            if (Carbon::parse($otpRecord->Expired_At)->isPast()) {
                return back()->withErrors(['otp' => 'This OTP has expired. Please request a new one.']);
            }

            // OTP is correct and not expired! Set a session flag
            session(['otp_verified' => true]);
            
            // Delete the OTP record from the database securely after use
            DB::table('otp_details')->where('Username', $email)->delete();
            
            return redirect()->route('password.reset.otp.form');
        }
        
        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }

    // 4. Show the New Password Form
    public function showResetForm()
    {
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
        
        // Clear all reset sessions
        session()->forget(['reset_email', 'otp_verified']);
        
        return redirect()->route('login')->with('status', 'Password has been successfully changed! Please log in.');
    }
}