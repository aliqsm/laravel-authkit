<?php

namespace Aliqsm\LaravelAuthkit\Actions\TwoFactor;

use Aliqsm\LaravelAuthkit\TwoFactor\TwoFactorAuthenticationNotEnabledException;
use App\Models\User;
use App\Notifications\SecurityEventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegenerateRecoveryCodesAction
{
    public function execute(Request $request): array
    {
        $user = $request->user();
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $now = now();
        $recoveryCodesCount = config('authkit.two_factor.recovery_codes_count');
        $recoveryCodeLength = config('authkit.two_factor.recovery_code_length');


        // ------------------------------------
        // Check Two-Factor Status
        // ------------------------------------
        if (!$user->hasEnabledTwoFactorAuthentication()) {
            throw new TwoFactorAuthenticationNotEnabledException();
        }


        // ------------------------------------
        // Generate Recovery Codes
        // ------------------------------------
        $recoveryCodes = collect(range(1, $recoveryCodesCount))->map(function () use ($recoveryCodeLength) {
            return Str::random($recoveryCodeLength);
        });

        $hashedRecoveryCodes = $recoveryCodes->map(function ($code) {
            return Hash::make($code);
        })->toArray();


        DB::transaction(function () use ($user, $request, $hashedRecoveryCodes, $ip, $userAgent, $now) {

            $userModel = config('auth.providers.users.model');
            $user = $userModel::lockForUpdate()->findOrFail($user->id);
            if (!$user->hasEnabledTwoFactorAuthentication()) {  // =>   بعد لاک دوباره باید بررسی بشه
                throw new TwoFactorAuthenticationNotEnabledException();
            }

            // ------------------------------------
            // Update Recovery Codes And Remember Token
            // ------------------------------------
            $user->forceFill([
                'two_factor_recovery_codes' => $hashedRecoveryCodes,
                'remember_token' => Str::random(72),
            ])->save();
        });


        // ------------------------------------
        // Send Security Notification
        // ------------------------------------
        if (config('authkit.features.security_activities', true)) {
            $user->notify(new SecurityEventNotification(data: [
                'event' => '2fa_recovery_codes_regenerated',
                'ip' => $ip,
                'user_agent' => $userAgent,
                'time' => $now,
            ]));
        }

        return $recoveryCodes->toArray();
    }
}
