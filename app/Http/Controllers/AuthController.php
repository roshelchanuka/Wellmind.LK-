<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact support.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            
            // Update last login
            $user->update([
                'last_login' => Carbon::now()
            ]);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'age' => 'required|integer|min:16|max:25',
            'dob' => 'required|date',
            'gender' => 'required|string',
        ]);

        // 1. Gmail Restriction
        if (!str_ends_with($request->email, '@gmail.com')) {
            return response()->json(['error' => 'Only Gmail addresses are allowed for registration.'], 422);
        }

        // 2. Domain DNS Check (Validation requested by user)
        if (!checkdnsrr('gmail.com', 'MX')) {
            return response()->json(['error' => 'Gmail service is unreachable. Please try again later.'], 422);
        }

        // 3. Generate OTP
        $otp = rand(100000, 999999);
        
        // 4. Save to Session (Encrypted)
        Session::put('temp_user', [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'otp' => $otp,
            'otp_expires' => Carbon::now()->addMinutes(15),
        ]);

        // 5. Send Email
        Mail::to($request->email)->send(new VerificationCodeMail($otp));

        return response()->json(['success' => 'Step 1 complete. OTP sent to your email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        
        $temp_user = Session::get('temp_user');

        if (!$temp_user) {
            return response()->json(['error' => 'Session expired. Please start registration again.'], 422);
        }

        if ($temp_user['otp'] != $request->otp) {
            return response()->json(['error' => 'Invalid verification code.'], 422);
        }

        if (Carbon::now()->isAfter($temp_user['otp_expires'])) {
            return response()->json(['error' => 'Verification code expired.'], 422);
        }

        // Create User
        $user = User::create([
            'full_name' => $temp_user['full_name'],
            'email' => $temp_user['email'],
            'password' => $temp_user['password'],
            'age' => $temp_user['age'],
            'dob' => $temp_user['dob'],
            'gender' => $temp_user['gender'],
            'is_verified' => 1,
            'last_login' => Carbon::now(),
        ]);

        Session::forget('temp_user');
        Auth::login($user);

        return response()->json(['success' => 'Account created and verified! Redirecting...', 'redirect' => route('home')]);
    }
}
