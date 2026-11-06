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
            $api_redirects = config('authkit.api_redirects');
            $frontendUrl = rtrim(config('authkit.frontend_url'), '/');

            return match ($result) {
                'success' => redirect($frontendUrl . $api_redirects['after_oauth_login']),
                'two_factor' => redirect($frontendUrl . $api_redirects['two_factor_challenge']),
                'invalid_google_user' => redirect($frontendUrl . $api_redirects['oauth_error'] . '?error=invalid_google_user'),
                'oauth_failed' => redirect($frontendUrl . $api_redirects['oauth_error'] . '?error=oauth_failed'),
                default => redirect($frontendUrl . $api_redirects['oauth_error'] . '?error=oauth_failed'),
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
