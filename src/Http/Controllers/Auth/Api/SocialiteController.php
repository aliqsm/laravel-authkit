<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Actions\Socialite\GoogleAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // ------------------------------------
    // Redirect User to Google
    // ------------------------------------
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    
    // ------------------------------------
    // Handle Auth Result
    // ------------------------------------
    public function handleGoogleCallback(Request $request, GoogleAction $action)
    {
        $result = $action->execute($request);

        return match ($result) {
            'success' => response()->json([
                'message' => 'ورود با موفقیت انجام شد.',
                'next_step' => 'dashboard',
            ]),

            'two_factor' => response()->json([
                'message' => 'تأیید دومرحله‌ای لازم است.',
                'next_step' => 'two_factor_challenge',
            ]),

            'email_exists' => response()->json([
                'message' => 'این ایمیل قبلاً ثبت شده است. وارد حساب خود شوید.',
            ], 409),

            'invalid_google_user' => response()->json([
                'message' => 'اطلاعات حساب گوگل تأیید نشد.',
            ], 422),

            'oauth_failed' => response()->json([
                'message' => 'ارتباط با گوگل ناموفق بود. لطفاً دوباره تلاش کنید.',
            ], 502),

            default => response()->json([
                'message' => 'ورود با گوگل ناموفق بود. لطفاً دوباره تلاش کنید.',
            ], 500),
        };
    }
}