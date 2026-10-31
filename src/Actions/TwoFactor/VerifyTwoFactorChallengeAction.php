<?php

namespace Aliqsm\LaravelAuthkit\Actions\TwoFactor;

use Aliqsm\LaravelAuthkit\TwoFactor\InvalidTwoFactorCodeException;
use Aliqsm\LaravelAuthkit\TwoFactor\TwoFactorAuthenticationNotEnabledException;
use Aliqsm\LaravelAuthkit\TwoFactor\TwoFactorChallengeInvalidException;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\TwoFactorChallengeRequest;
use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class VerifyTwoFactorChallengeAction
{
    public function __construct(
        private Google2FA $google2fa
    ) {}


    public function execute(TwoFactorChallengeRequest $request, array $data): void
    {
        $session = $request->session();
        $userId = $session->get('2fa:user_id');
        $expiresAt = $session->get('2fa:expires_at');
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $now = now();


        // -------------------------------------
        // Check Two-Factor Session
        // -------------------------------------
        if (!$userId || !$expiresAt || Carbon::parse($expiresAt)->isPast()) {
            $request->session()->forget([
                '2fa:user_id',
                '2fa:remember',
                '2fa:expires_at',
            ]);

            throw new TwoFactorChallengeInvalidException();
        }


        $userModel = config('auth.providers.users.model');
        $user = $userModel::findOrFail($userId);
        $code = $data['code'];
        $remember = (bool) $session->get('2fa:remember', false);


        // -------------------------------------
        // Check If 2FA Is Enabled
        // -------------------------------------
        if (!$user->hasEnabledTwoFactorAuthentication()) {
            throw new TwoFactorAuthenticationNotEnabledException();
        }


        // -------------------------------------
        // Verify Authenticator Or Recovery Code
        // -------------------------------------
        $authenticated = false;
        $isLastRecoveryCode = false;

        if (preg_match('/^\d{6}$/', $code)) {
            $authenticated = $this->google2fa->verifyKey($user->two_factor_secret, $code);
        } else {
            $authenticated = DB::transaction(function () use ($user, $code, &$isLastRecoveryCode) {

                // -------------------------------------
                // Lock User Record
                // -------------------------------------
                $userModel = config('auth.providers.users.model');
                $user = $userModel::lockForUpdate()->findOrFail($user->getKey());
                $recoveryCodes = $user->two_factor_recovery_codes ?? [];


                // -------------------------------------
                // Find Matching Recovery Code
                // -------------------------------------
                foreach ($recoveryCodes as $index => $recoveryCode) {
                    if (!Hash::check($code, $recoveryCode)) {
                        continue;
                    }

                    // -------------------------------------
                    // Check If Last Recovery Code
                    // -------------------------------------
                    $isLastRecoveryCode = count($recoveryCodes) === 1;

                    // -------------------------------------
                    // Remove Used Recovery Code
                    // -------------------------------------
                    unset($recoveryCodes[$index]);
                    $user->update(['two_factor_recovery_codes' => array_values($recoveryCodes)]);
                    return true;
                }

                return false;
            });
        }


        if (!$authenticated) {
            throw new InvalidTwoFactorCodeException();
        }

        if ($isLastRecoveryCode) { // ارسال ایمل وقتی کاربر اخرین ریکوری کد رو هم مصرف کرد
            $user->notify(new SecurityEventNotification(data: [
                'type' => '2fa_recovery_codes_empty',
                'ip' => $ip,
                'time' => $now,
            ]));
        }


        // -------------------------------------
        // Complete User Authentication
        // -------------------------------------
        Auth::login($user, $remember);
        $request->session()->regenerate();


        // -------------------------------------
        // Clear Temporary Two-Factor Session
        // -------------------------------------
        $request->session()->forget([
            '2fa:user_id',
            '2fa:remember',
            '2fa:expires_at',
        ]);


        // -------------------------------------
        // Send Security Notification
        // -------------------------------------
        if (config('authkit.features.security_activities', true)) {
            $user->notify(new SecurityEventNotification(data: [
                'event' => 'login_alert',
                'ip' => $ip,
                'user_agent' => $userAgent,
                'time' => $now,
            ]));
        }
    }
}
