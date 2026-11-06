<?php

namespace Aliqsm\LaravelAuthkit\Actions\TwoFactor;

use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Aliqsm\LaravelAuthkit\Exceptions\TwoFactor\TwoFactorAuthenticationNotEnabledException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DisableTwoFactorAuthenticationAction
{
    public function execute(Request $request): void
    {
        $user = $request->user();
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $now = now();


        // ------------------------------------
        // Check Two-Factor Status
        // ------------------------------------
        if (!$user->hasEnabledTwoFactorAuthentication()) {
            throw new TwoFactorAuthenticationNotEnabledException();
        }


        DB::transaction(function () use ($user, $request) {

            $userModel = config('auth.providers.users.model');
            $user = $userModel::lockForUpdate()->findOrFail($user->id);
            if (!$user->hasEnabledTwoFactorAuthentication()) {  // =>   بعد قفل دوباره وضعیت  رو بررسی میکنیم
                throw new TwoFactorAuthenticationNotEnabledException();
            }


            $user->update([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
            ]);


            // ------------------------------------
            // Invalidate Other Database Sessions
            // ------------------------------------
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->whereNot('id', $request->session()->getId())
                    ->delete();
            }


            $user->setRememberToken(Str::random(72));
            $user->save();
        });


        $request->session()->regenerate();


        // ------------------------------------
        // Send Security Notification
        // ------------------------------------
        if (config('authkit.features.security_activities', true)) {
            $user->notify(new SecurityEventNotification(data: [
                'event' => 'two_factor_disabled',
                'ip' => $ip,
                'user_agent' => $userAgent,
                'time' => $now,
            ]));
        }
    }
}
