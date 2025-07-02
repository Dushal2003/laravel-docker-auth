<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\LoginOtp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class OtpController extends Controller
{
    /* ───── 1. Send / Resend OTP ───── */
    public function requestOtp(RequestOtpRequest $request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();

        if (Cache::has("otp-cooldown-{$user->id}")) {
            return back()->withErrors(['email' => 'Please wait a minute before requesting a new OTP.']);
        }

        $plain = (string) random_int(100000, 999999);

        OtpCode::create([
            'user_id'    => $user->id,
            'code_hash'  => Hash::make($plain),
            'type'       => 'login',
            'expires_at' => now()->addMinutes(10),
        ]);

        $user->notify(new LoginOtp($plain));
        Cache::put("otp-cooldown-{$user->id}", true, 60);

        return back()->with('status', 'OTP sent! Check your email or phone.');
    }

    /* ───── 2. Verify OTP & log in ───── */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();

        $otp = OtpCode::where('user_id', $user->id)
            ->where('type', 'login')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp || !Hash::check($request->otp, $otp->code_hash)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $otp->delete();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }
}
