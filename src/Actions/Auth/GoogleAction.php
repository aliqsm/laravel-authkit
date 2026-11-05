<?php

namespace Aliqsm\LaravelAuthkit\Actions\Auth;

use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAction
{
    public function execute(Request $request): string
    {
        $now = now();
        $ip = $request->ip();
        $userAgent = $request->userAgent();


        // -------------------------------------
        // Get Google User Result
        // -------------------------------------
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            report($e);
            return 'oauth_failed';
        }


        // ------------------------------------
        // Validate Google User Data
        // ------------------------------------
        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();
        $name = $googleUser->getName() ?: $email;

        $validator = Validator::make([
            'google_id' => $googleId,
            'email' => $email,
            'email_verified' => $googleUser->user['email_verified'] ?? null,
        ], [
            'google_id' => 'required|string',
            'email' => 'required|email',
            'email_verified' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return 'invalid_google_user';
        }


        // ------------------------------------
        // Link Existing Account Or Create User
        // ------------------------------------
        try {
            $userModel = config('auth.providers.users.model');
            $user = $userModel::where('google_id', $googleId)->first();

            if (!$user) {
                $user = $userModel::where('email', $email)->first();

                if ($user) {
                    // ------------------------------------
                    // Link Google Account
                    // ------------------------------------
                    if ($user->google_id === null) {
                        $user->update(['google_id' => $googleId]);
                    }
                } else {
                    // ------------------------------------
                    // Create New User
                    // ------------------------------------
                    $user = $userModel::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make(Str::password(32)),
                        'google_id' => $googleId,
                        'email_verified_at' => $now,
                    ]);
                }
            }
        } catch (QueryException $e) {
            report($e);
            return 'oauth_failed';
        }


        // -------------------------------------
        // Check If 2FA Is Enabled
        // -------------------------------------
        if ($user->hasEnabledTwoFactorAuthentication()) {
            $request->session()->regenerate();

            // -------------------------------------
            // Store Temporary 2FA Data
            // -------------------------------------
            $request->session()->put([
                '2fa:user_id' => $user->getAuthIdentifier(),
                '2fa:remember' => $request->boolean('remember'),
                '2fa:expires_at' => $now->copy()->addMinutes(
                    (int) config('authkit.two_factor.challenge_expire_minutes')
                ),
            ]);

            return 'two_factor';
        }


        // ------------------------------------
        // Login User
        // ------------------------------------
        Auth::login($user);
        $request->session()->regenerate();


        // -------------------------------------
        // Record Successful Login
        // -------------------------------------
        if (config('authkit.features.security_activities', true)) {
            $user->notify(new SecurityEventNotification(data: [
                'event' => 'login_alert',
                'ip' => $ip,
                'user_agent' => $userAgent,
                'time' => $now,
            ]));
        }

        return 'success';
    }
}
