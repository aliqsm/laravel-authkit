<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\TwoFactor;

class TwoFactorChallengeResponse
{
    // -------------------------------------
    // Expired Challenge
    // -------------------------------------
    public function expired()
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'مهلت تأیید دومرحله‌ای به پایان رسیده است. لطفاً دوباره وارد حساب خود شوید.',
            ], 401);
        }

        return redirect()->route('login.form');
    }


    // -------------------------------------
    // Show Challenge
    // -------------------------------------
    public function show()
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'data' => [
                    'two_factor_challenge' => true,
                ],
            ]);
        }

        return view('authkit::auth.2fa-challenge');
    }


    // -------------------------------------
    // Verify Challenge
    // -------------------------------------
    public function verify()
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'ورود دومرحله‌ای با موفقیت انجام شد.',
                'data' => [
                    'authenticated' => true,
                ],
            ]);
        }

        return response()->json([
            'message' => 'ورود با موفقیت انجام شد.',
            'data' => [
                'redirect' => route('dashboard'),
            ],
        ]);
    }
}