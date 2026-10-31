<?php

namespace Aliqsm\LaravelAuthkit\Actions\Password;

use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ChangePasswordAction
{
    public function execute(Request $request, array $data): void
    {
        $user = $request->user();
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $now = now();


        // ------------------------------------
        // Ensure New Password Is Different
        // ------------------------------------
        if (Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'رمز عبور جدید باید با رمز فعلی متفاوت باشد.',
            ]);
        }


        DB::transaction(function () use ($request, $user, $data) {
            // ------------------------------------
            // Update Password and Remember Token
            // ------------------------------------
            $user->forceFill([
                'password' => $data['password'],
                'remember_token' => Str::random(72),
            ])->save();


            // ------------------------------------
            // Delete Other Database Sessions
            // ------------------------------------
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', $user->getKey())
                    ->where('id', '!=', $request->session()->getId())
                    ->delete();
            }
        });



        // ------------------------------------
        // Send Security Notification
        // ------------------------------------
        if (config('authkit.features.security_activities', true)) {
            $user->notify(new SecurityEventNotification(data: [
                'event' => 'password_changed',
                'ip' => $ip,
                'user_agent' => $userAgent,
                'time' => $now,
            ]));
        }
    }
}
