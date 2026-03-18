<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Mail\LoginOtp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $type = $request->input('t');
        return view('auth.user_login', [
            'type' => $type,
            'joinLink' => '/join',
        ]);
    }

    public function login(Request $request)
    {
        $columns = ['id', 'name', 'email', 'password', 'email_2fa_enabled_at'];
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        $email = $credentials['email'];
        $user = User::select($columns)->where('email', $email)->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (!empty($user->email_2fa_enabled_at)) {
                $userId = $user->id;
                $otp = rand(100000, 999999);
                $expiry = now()->addMinutes(15);
                $sessionId = session()->getId();
                $key = "login_otp_email_{$userId}_{$sessionId}";
                cache()->put($key, Hash::make($otp), $expiry);
                session(['2fa:user:id' => $userId, 'remember' => $remember]);
                Mail::send(new LoginOtp($user, $otp));
                return redirect()->route('login-otp-email');
            }
            if (Auth::attempt($credentials, $remember)) {
                return redirect()->intended('/');
            }
        }
        return back()->withErrors([ 'email' => 'Invalid login credentials.', ]);
    }

    public function otpEmail(Request $request)
    {
        return view('auth.login-otp-email');
    }

    public function otpEmailVerify(Request $request)
    {
        $input = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);
        try {
            $userId = session('2fa:user:id');
            $remember = session('remember', false);

            if (!$userId) {
                $message = 'Session expired. Please login again.';
                return response()->json(['message' => $message], 422);
            }

            $sessionId = session()->getId();
            $key = "login_otp_email_{$userId}_{$sessionId}";
            $hashedOtp = cache()->get($key);
            if (!$hashedOtp) {
                $message = 'OTP expired. Please request a new one.';
                return response()->json(['message' => $message], 422);
            }

            $attemptKey = "login_otp_email_attempts_{$userId}_{$sessionId}";
            $attempts = cache()->increment($attemptKey);

            if ($attempts === 1) {
                cache()->put($attemptKey, 1, now()->addMinutes(5));
            }

            if ($attempts > 5) {
                $message = 'Too many attempts. Try again later.';
                return response()->json(['message' => $message], 422);
            }

            if (!Hash::check($input['otp'], $hashedOtp)) {
                return response()->json(['message' => 'Invalid OTP.'], 422);
            }

            $user = User::find($userId);
            Auth::login($user, $remember);
            // cleanup
            foreach ([$key, $attemptKey] as $k) {
                cache()->forget($k);
            }
            session()->forget(['2fa:user:id', 'remember']);
            $message = 'Redirecting...';
            return response()->json(['redirect' => '/', 'message' => $message]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function otpEmailResend(Request $request)
    {
        try {
            $userId = session('2fa:user:id');
            if (!$userId) {
                $message = 'Session expired. Please login again.';
                return response()->json(['message' => $message], 422);
            }

            $sessionId = session()->getId();
            $rateKey = "login_otp_email_resend_{$userId}_{$sessionId}";

            // check limit (1 attempts per 5 min)
            if (RateLimiter::tooManyAttempts($rateKey, 1)) {
                $seconds = RateLimiter::availableIn($rateKey);
                $message = "Too many requests, try again in {$seconds} seconds";
                return response()->json(['message' => $message], 429);
            }

            // hit limiter (5 min decay)
            RateLimiter::hit($rateKey, 300);

            $user = User::select('id', 'email')->find($userId);
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 422);
            }

            // generate new OTP
            $otp = rand(100000, 999999);
            $expiry = now()->addMinutes(15);
            $otpKey = "login_otp_email_{$userId}_{$sessionId}";

            cache()->put($otpKey, Hash::make($otp), $expiry);
            Mail::send(new LoginOtp($user, $otp));
            return response()->json(['message' => 'OTP resent successfully.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
