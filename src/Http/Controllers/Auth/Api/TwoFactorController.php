<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Actions\TwoFactor\DisableTwoFactorAuthenticationAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\EnableTwoFactorAuthenticationAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\SetupTwoFactorAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\RegenerateRecoveryCodesAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\VerifyTwoFactorChallengeAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\EnableTwoFactorRequest;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\TwoFactorChallengeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TwoFactorController extends Controller
{
    // ------------------------------------
    // Show Two-Factor Authentication Page
    // ------------------------------------
    public function index(Request $request, SetupTwoFactorAction $action)
    {
        if ($request->user()->hasEnabledTwoFactorAuthentication()) {
            return response()->json([
                'message' => 'تأیید دومرحله‌ای قبلاً فعال شده است.',
                'data' => [
                    'enabled' => true,
                ],
            ]);
        }

        $data = $action->execute($request);

        return response()->json([
            'message' => 'اطلاعات راه‌اندازی تأیید دومرحله‌ای آماده است.',
            'data' => [
                'enabled' => false,
                'secret' => $data['secret'],
                'qr_url' => $data['qrUrl'],
            ],
        ]);
    }



    // ------------------------------------
    // Enable Two-Factor Authentication
    // ------------------------------------
    public function enable(EnableTwoFactorRequest $request, EnableTwoFactorAuthenticationAction $action)
    {
        $recoveryCodes = $action->execute(
            request: $request,
            data: $request->validated()
        );

        return response()->json([
            'message' => 'تأیید دومرحله‌ای با موفقیت فعال شد.',
            'data' => [
                'enabled' => true,
                'recovery_codes' => $recoveryCodes,
            ],
        ]);
    }



    // ------------------------------------
    // Disable Two-Factor Authentication
    // ------------------------------------
    public function disable(Request $request, DisableTwoFactorAuthenticationAction $action)
    {
        $action->execute($request);

        return response()->json([
            'message' => 'تأیید دومرحله‌ای با موفقیت غیرفعال شد.',
            'data' => [
                'enabled' => false,
            ],
        ]);
    }



    // ------------------------------------
    // Regenerate Two-Factor Recovery Codes
    // ------------------------------------
    public function regenerate(Request $request, RegenerateRecoveryCodesAction $action)
    {
        $codes = $action->execute($request);

        return response()->json([
            'message' => 'کدهای بازیابی با موفقیت تولید شدند.',
            'data' => [
                'recovery_codes' => $codes,
            ],
        ]);
    }



    // -------------------------------------
    // Show Two-Factor Verification Page
    // -------------------------------------
    public function show(Request $request)
    {
        $session = $request->session();
        $userId = $session->get('2fa:user_id');
        $expiresAt = $session->get('2fa:expires_at');

        if (!$userId || !$expiresAt || Carbon::parse($expiresAt)->isPast()) {
            $session->forget([
                '2fa:user_id',
                '2fa:remember',
                '2fa:expires_at',
            ]);

            return response()->json([
                'message' => 'مهلت تأیید دومرحله‌ای به پایان رسیده است. لطفاً دوباره وارد حساب خود شوید.',
            ], 401);
        }

        return response()->json([
            'data' => [
                'two_factor_challenge' => true,
            ],
        ]);
    }



    // -------------------------------------
    // Verify Two-Factor Code
    // -------------------------------------
    public function verify(TwoFactorChallengeRequest $request,VerifyTwoFactorChallengeAction $action) {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return response()->json([
            'message' => 'ورود دومرحله‌ای با موفقیت انجام شد.',
            'data' => [
                'authenticated' => true,
            ],
        ]);
    }
}
