<?php

namespace Aliqsm\LaravelAuthkit\Actions\TwoFactor;

use Aliqsm\LaravelAuthkit\TwoFactor\TwoFactorAlreadyEnabledException;
use Aliqsm\LaravelAuthkit\TwoFactor\TwoFactorSetupSessionExpiredException;
use Aliqsm\LaravelAuthkit\TwoFactor\InvalidTwoFactorCodeException;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\EnableTwoFactorRequest;
use App\Models\User;
use App\Notifications\SecurityEventNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class EnableTwoFactorAuthenticationAction
{
    public function __construct(
        private Google2FA $google2fa
    ) {}


    public function execute(EnableTwoFactorRequest $request, array $data): array
    {
        $user = $request->user();
        $code = $data['code'];
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $now = now();


        // ------------------------------------
        // Check Existing Two-Factor Status
        // ------------------------------------
        if ($user->hasEnabledTwoFactorAuthentication()) {
            throw new TwoFactorAlreadyEnabledException();
        }


        $session = $request->session();
        $tempSecret = $session->get('2fa_secret_temp');
        $expiresAt = $session->get('2fa_secret_expires_at');
        $recoveryCodesCount = config('authkit.two_factor.recovery_codes_count');
        $recoveryCodeLength = config('authkit.two_factor.recovery_code_length');


        // ------------------------------------
        // Check Temporary Secret Expiration
        // ------------------------------------
        if (!$tempSecret || !$expiresAt || !Carbon::parse($expiresAt)->isFuture()) {
            $session->forget([
                '2fa_secret_temp',
                '2fa_secret_expires_at',
                '2fa_qr_url',
            ]);

            throw new TwoFactorSetupSessionExpiredException();
        }


        // ------------------------------------
        // Verify Two-Factor Code
        // ------------------------------------
        if (! $this->google2fa->verifyKey($tempSecret, $code)) {
            throw new InvalidTwoFactorCodeException();
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


        DB::transaction(function () use ($session, $user, $tempSecret, $hashedRecoveryCodes, $ip, $userAgent, $now) {

            $userModel = config('auth.providers.users.model');
            $user = $userModel::lockForUpdate()->findOrFail($user->id);
            if ($user->hasEnabledTwoFactorAuthentication()) { // => چون لاک کردم دوباره برای اطمینان باید چک کنم
                throw new TwoFactorAlreadyEnabledException();
            }

            $user->update([
                'two_factor_secret' => $tempSecret,
                'two_factor_recovery_codes' => $hashedRecoveryCodes,
            ]);


            // ------------------------------------
            // Invalidate Other Database Sessions
            // ------------------------------------
            if (config('session.driver') === 'database') {
                DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->whereNot('id', $session->getId())
                    ->delete();
            }

            $user->setRememberToken(Str::random(72));
            $user->save();
        });


        // ------------------------------------
        // Clear Temporary Setup Data
        // ------------------------------------
        $session->forget([
            '2fa_secret_temp',
            '2fa_secret_expires_at',
            '2fa_qr_url',
        ]);


        $session->regenerate();


        // ------------------------------------
        // Send Security Notification
        // ------------------------------------
        if (config('authkit.features.security_activities', true)) {
            $user->notify(new SecurityEventNotification(data: [
                'event' => 'two_factor_enabled',
                'ip' => $ip,
                'user_agent' => $userAgent,
                'time' => $now,
            ]));
        }


        return $recoveryCodes->toArray();
    }
}
