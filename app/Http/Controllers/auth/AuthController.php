<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position' => $request->position,
            'department' => $request->department,
            'profile_picture' => $profilePicturePath,
        ]);

        return redirect()->route('auth.login')->with('success', 'Account created successfully! Please login.');
    }

    // Show login form
    public function showLogin()
    {
        \Log::info("ShowLogin called - Session data: " . json_encode(session()->all()));
        \Log::info("login_otp session value: " . session('login_otp'));
        
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Find the user first
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid credentials',
            ])->withInput($request->except('password'));
        }

        // Generate OTP using time-based approach (numbers only)
        $timestamp = now()->timestamp;
        $otpSeed = $user->email . $user->id . $timestamp;
        $otp = substr(md5($otpSeed), 0, 6);
        // Convert to numbers only
        $otp = preg_replace('/[^0-9]/', '', $otp);
        // Ensure we have 6 digits, pad if needed
        $otp = str_pad(substr($otp, 0, 6), 6, '0', STR_PAD_RIGHT);
        
        // Store user info and timestamp for verification
        Session::put('login_otp', true); // Flag to show OTP form
        Session::put('login_otp_email', $request->email);
        Session::put('login_user_id', $user->id);
        Session::put('login_otp_timestamp', $timestamp);
        Session::put('login_otp_expires', now()->addMinutes(30));
        
        // Force session to save
        Session::save();
        
        \Log::info("Session data set - login_otp: " . Session::get('login_otp') . ", email: " . Session::get('login_otp_email'));

        \Log::info("Login attempt - Email: {$request->email}, User ID: {$user->id}, OTP: {$otp}");

        // Send OTP email
        try {
            Mail::raw("Your login OTP code is: {$otp}\n\nThis code will expire in 30 minutes.", function($message) use ($request) {
                $message->to($request->email)
                        ->subject('Your Login OTP Code');
            });
            
            \Log::info("OTP email sent successfully to: {$request->email}");
            return redirect()->route('auth.login')->with('success', 'OTP sent to your email!');
        } catch (\Exception $e) {
            // For development: Show OTP in logs if email fails
            \Log::error("Email failed: " . $e->getMessage());
            \Log::info("DEV MODE - OTP Code: {$otp} for email: {$request->email}");
            
            // Still allow login to continue even if email fails (for development)
            return redirect()->route('auth.login')
                ->with('success', "OTP sent! (DEV: Check logs for OTP: {$otp})")
                ->with('dev_otp', $otp); // Store OTP in session for development
        }
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        // Debug session state
        \Log::info("OTP Verification - Session ID: " . session()->getId());
        \Log::info("Session data: " . json_encode(session()->all()));

        $otpExpires = Session::get('login_otp_expires');
        $loginEmail = Session::get('login_otp_email');
        $userId = Session::get('login_user_id');
        $timestamp = Session::get('login_otp_timestamp');

        // Debug logging
        \Log::info("OTP Verification - Input: " . $request->otp . ", Timestamp: " . $timestamp);
        \Log::info("Current time: " . now() . ", Expires time: " . $otpExpires);
        \Log::info("Session data - Email: " . $loginEmail . ", User ID: " . $userId);

        if (!$otpExpires || !$userId || !$timestamp) {
            \Log::error("Login session missing - expires: " . ($otpExpires ? 'yes' : 'no') . ", user_id: " . ($userId ? 'yes' : 'no') . ", timestamp: " . ($timestamp ? 'yes' : 'no'));
            Session::forget(['login_otp', 'login_otp_email', 'login_user_id', 'login_otp_timestamp', 'login_otp_expires']);
            return redirect()->route('auth.login')->withErrors(['otp' => 'Login session expired. Please login again.']);
        }

        // Check expiry
        if (now()->greaterThan($otpExpires)) {
            \Log::error("Login session expired - Current: " . now() . ", Expires: " . $otpExpires);
            Session::forget(['login_otp', 'login_otp_email', 'login_user_id', 'login_otp_timestamp', 'login_otp_expires']);
            return redirect()->route('auth.login')->withErrors(['otp' => 'Login session expired. Please login again.']);
        }

        // Regenerate OTP using stored timestamp for verification
        $user = \App\Models\User::find($userId);
        if (!$user) {
            \Log::error("User not found for ID: " . $userId);
            Session::forget(['login_otp', 'login_otp_email', 'login_user_id', 'login_otp_timestamp', 'login_otp_expires']);
            return redirect()->route('auth.login')->withErrors(['otp' => 'Invalid session. Please login again.']);
        }

        $otpSeed = $user->email . $user->id . $timestamp;
        $expectedOtp = substr(md5($otpSeed), 0, 6);
        // Convert to numbers only (same as generation)
        $expectedOtp = preg_replace('/[^0-9]/', '', $expectedOtp);
        // Ensure we have 6 digits, pad if needed
        $expectedOtp = str_pad(substr($expectedOtp, 0, 6), 6, '0', STR_PAD_RIGHT);

        \Log::info("Expected OTP: " . $expectedOtp . ", Input OTP: " . $request->otp);

        // Verify OTP
        if ($request->otp === $expectedOtp) {
            \Log::info("OTP verified successfully for email: " . $loginEmail);
            
            // Login the user
            Auth::login($user);
            \Log::info("User logged in: " . $user->email);
            
            // Clear session and redirect to dashboard
            Session::forget(['login_otp', 'login_otp_email', 'login_user_id', 'login_otp_timestamp', 'login_otp_expires']);
            return redirect()->route('dashboard');
        }

        \Log::error("OTP mismatch - Expected: '" . $expectedOtp . "', Input: '" . $request->otp . "'");
        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $email = Session::get('login_otp_email');
        $userId = Session::get('login_user_id');
        
        if (!$email || !$userId) {
            return redirect()->route('auth.login')->withErrors(['email' => 'Please login first.']);
        }
        $user = \App\Models\User::find($userId);
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Generate new OTP
        $timestamp = now()->timestamp;
        $otp = substr(md5($email . $timestamp . $user->id), 0, 6);
        $otp = preg_replace('/[^0-9]/', '', substr($otp, 0, 6));
        
        // Update session
        Session::put('login_otp_timestamp', $timestamp);
        Session::put('login_otp_expires', now()->addMinutes(30));
        Session::save();

        \Log::info("Resend OTP - Email: {$email}, User ID: {$user->id}, New OTP: {$otp}");

        // Send new OTP email
        try {
            Mail::raw("Your new login OTP code is: {$otp}\n\nThis code will expire in 30 minutes.", function($message) use ($email) {
                $message->to($email)
                        ->subject('Your New Login OTP Code');
            });
            
            \Log::info("Resend OTP email sent successfully to: {$email}");
            return back()->with('success', 'New OTP sent to your email!');
        } catch (\Exception $e) {
            // For development: Show OTP in logs if email fails
            \Log::error("Resend email failed: " . $e->getMessage());
            \Log::info("DEV MODE - Resend OTP Code: {$otp} for email: {$email}");
            
            // Still allow login to continue even if email fails (for development)
            return back()
                ->with('success', "New OTP sent! (DEV: Check logs for OTP: {$otp})")
                ->with('dev_otp', $otp); // Store OTP in session for development
        }
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        Session::forget(['login_otp', 'login_otp_email', 'login_user_id', 'login_otp_timestamp', 'login_otp_expires']);
        return redirect()->route('auth.login');
    }
}
