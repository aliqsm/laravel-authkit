<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

class GoogleLoginResponse
{
    public function toResponse(string $result)
    {
        // -------------------------------------
        // API Response
        // -------------------------------------
        if (config('authkit.app_mode') === 'api') {
            $api_urls = config('authkit.api_urls');

            return match ($result) {
                'success' => redirect($api_urls['oauth_success']),
                'two_factor' => redirect($api_urls['two_factor_challenge']),
                'invalid_google_user' => redirect($api_urls['oauth_failure'] . '?error=invalid_google_user'),
                'oauth_failed' => redirect($api_urls['oauth_failure'] . '?error=oauth_failed'),
                default => redirect($api_urls['oauth_failure'] . '?error=oauth_failed'),
            };
        }


        // -------------------------------------
        // Web Response
        // -------------------------------------
        return match ($result) {
            'success' => redirect()->route('dashboard'),
            'two_factor' => redirect()->route('two-factor.challenge'),
            'invalid_google_user' => redirect()->route('login')->withErrors(['email' => 'اطلاعات حساب گوگل تأیید نشد.']),
            'oauth_failed' => redirect()->route('login')->withErrors(['email' => 'ارتباط با گوگل ناموفق بود. لطفاً دوباره تلاش کنید.']),
            default => redirect()->route('login')->withErrors(['email' => 'ورود با گوگل ناموفق بود. دوباره تلاش کنید.']),
        };
    }
}
