<?php

namespace Aliqsm\LaravelAuthkit\Actions\TwoFactor;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PragmaRX\Google2FA\Google2FA;

class SetupTwoFactorAction
{
    public function __construct(
        private Google2FA $google2fa
    ) {}


    public function execute(Request $request): array
    {
        $user = $request->user();
        $session = $request->session();
        $appName = config('app.name');
        $setupExpireMinutes = config('authkit.two_factor.setup_expire_minutes');

        $expiresAt = $session->get('2fa_secret_expires_at');
        $secret = $session->get('2fa_secret_temp');
        $qrUrl = $session->get('2fa_qr_url');


        // ------------------------------------
        // Check Existing Setup Data
        // ------------------------------------
        if (!$secret || !$expiresAt || !$qrUrl || Carbon::parse($expiresAt)->isPast()) {

            // ------------------------------------
            // Generate New Secret And QR Code URL And Save In Session
            // ------------------------------------
            $secret = $this->google2fa->generateSecretKey(32);
            $qrUrl = $this->google2fa->getQRCodeUrl($appName, $user->email, $secret);

            $session->put([
                '2fa_secret_temp' => $secret,
                '2fa_secret_expires_at' => now()->addMinutes($setupExpireMinutes),
                '2fa_qr_url' => $qrUrl,
            ]);
        }


        return [
            'secret' => $secret,
            'qrUrl' => $qrUrl,
        ];
    }
}
