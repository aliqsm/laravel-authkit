<?php

namespace Aliqsm\LaravelAuthkit\Actions\Login;

use Aliqsm\LaravelAuthkit\Requests\LoginRequest;
use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Aliqsm\LaravelAuthkit\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Timebox;

class LoginAction
{
    public function execute(LoginRequest $request, array $data): string
    {
        // -------------------------------------
        // Validate Credentials + 200ms delay
        // -------------------------------------
        if (!(new Timebox())->call(fn() => Auth::validate([     // => برای بررسی اطلاعات بدون لاگین کردن کاربر validate متد
            'email' => $data['email'],
            'password' => $data['password'],
        ]), 200000)) {
            throw new InvalidCredentialsException();
        }


        $ip = $request->ip();
        $email = $data['email'];
        $userAgent = $request->userAgent();
        $now = now();
        $userModel = config('auth.providers.users.model');
        $user = $userModel::firstWhere('email', $email);


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
                '2fa:expires_at' => $now->addMinutes((int) config('authkit.two_factor.challenge_expire_minutes')),
            ]);

            return 'two_factor';
        }


        // -------------------------------------
        // Login User
        // -------------------------------------
        Auth::login($user, $request->boolean('remember'));
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
