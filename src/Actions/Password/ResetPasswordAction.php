<?php

namespace Aliqsm\LaravelAuthkit\Actions\Password;

use Aliqsm\LaravelAuthkit\Exceptions\InvalidPasswordResetException;
use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Aliqsm\LaravelAuthkit\Exceptions\PasswordResetException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction
{
    public function execute(Request $request, array $data): void
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $now = now();


        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'token' => $data['token'],
            ],

            function ($user, string $password) use ($ip, $userAgent, $now) {
                // ------------------------------------
                // Update Password and Remember Token
                // ------------------------------------
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60)
                ])->save();


                // ------------------------------------
                // Dispatch Password Reset Event
                // ------------------------------------
                event(new PasswordReset($user));


                // -------------------------------------
                // Send Security Notification
                // -------------------------------------
                if (config('authkit.features.security_activities', true)) {
                    $user->notify(new SecurityEventNotification(data: [
                        'event' => 'password_updated',
                        'ip' => $ip,
                        'user_agent' => $userAgent,
                        'time' => $now,
                    ]));
                }
            }
        );


        // ------------------------------------
        // Handle Password Reset Status
        // ------------------------------------
        if ($status === Password::INVALID_TOKEN || $status === Password::INVALID_USER) {
            throw new InvalidPasswordResetException();
        }

        if ($status !== Password::PASSWORD_RESET) {
            throw new PasswordResetException();
        }
    }
}
