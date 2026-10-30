<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\TwoFactor\DisableTwoFactorAuthenticationAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\EnableTwoFactorAuthenticationAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\SetupTwoFactorAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\RegenerateRecoveryCodesAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\VerifyTwoFactorChallengeAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\EnableTwoFactorRequest;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\TwoFactorChallengeRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
            return view('authkit::dashboard.2fa.manage');
        }

        $data = $action->execute($request);

        return view('authkit::dashboard.2fa.setup', [
            'qrImage' => QrCode::size(150)->generate($data['qrUrl']),
            'secret' => $data['secret']
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

        $request->session()->flash('recovery_codes', $recoveryCodes);

        return response()->json([
            'message' => 'تأیید دومرحله‌ای با موفقیت فعال شد.',
            'data' => [
                'redirect' => route('two-factor.index'),
            ],
        ]);
    }



    // ------------------------------------
    // Disable Two-Factor Authentication
    // ------------------------------------
    public function disable(Request $request, DisableTwoFactorAuthenticationAction $action)
    {
        $action->execute($request);

        return redirect()->back()->with([
            'type' => 'success',
            'message' => 'تایید دومرحله‌ای با موفقیت غیرفعال شد.'
        ]);
    }



    // ------------------------------------
    // Regenerate Two-Factor Recovery Codes
    // ------------------------------------
    public function regenerate(Request $request, RegenerateRecoveryCodesAction $action)
    {
        $codes = $action->execute($request);

        return redirect()->back()->with([
            'recovery_codes' => $codes
        ]);
    }



    // -------------------------------------
    // Show Two-Factor Verification Page
    // -------------------------------------
    public function show()
    {
        $userId = session('2fa:user_id');
        $expiresAt = session('2fa:expires_at');

        if (!$userId || !$expiresAt || Carbon::parse($expiresAt)->isPast()) {
            session()->forget([
                '2fa:user_id',
                '2fa:remember',
                '2fa:expires_at',
            ]);

            return redirect()->route('login.form');
        }

        return view('authkit::auth.2fa-challenge');
    }



    // -------------------------------------
    // Verify Two-Factor Code
    // -------------------------------------
    public function verify(TwoFactorChallengeRequest $request, VerifyTwoFactorChallengeAction $action)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return response()->json([
            'message' => 'درحال انتقال به صفحه داشبورد',
            'data' => [
                'redirect' => true
            ]
        ]);
    }
}
