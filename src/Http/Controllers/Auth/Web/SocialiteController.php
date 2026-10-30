<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

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
            'success' => redirect()->route('dashboard'),
            'two_factor' => redirect()->route('two-factor.challenge'),
            'email_exists' => redirect()->route('login')->withErrors([
                'email' => 'این ایمیل قبلاً ثبت شده است. وارد حساب خود شوید.',
            ]),
            'invalid_google_user' => redirect()->route('login')->withErrors([
                'email' => 'اطلاعات حساب گوگل تأیید نشد.',
            ]),
            'oauth_failed' => redirect()->route('login')->withErrors([
                'email' => 'ارتباط با گوگل ناموفق بود. لطفاً دوباره تلاش کنید.',
            ]),
            default => redirect()->route('login')->withErrors([
                'email' => 'ورود با گوگل ناموفق بود. دوباره تلاش کنید.',
            ]),
        };
    }
}