<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

class GoogleLoginResponse
{
    public function toResponse(string $result)
    {
        if (config('authkit.app_mode') === 'api') {
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