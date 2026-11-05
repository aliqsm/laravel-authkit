<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\TwoFactor;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\SetupTwoFactorAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\EnableTwoFactorAuthenticationAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\DisableTwoFactorAuthenticationAction;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\RegenerateRecoveryCodesAction;
use Aliqsm\LaravelAuthkit\Http\Requests\TwoFactor\EnableTwoFactorRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\TwoFactor\TwoFactorManagementResponse;

class TwoFactorController extends Controller
{
    // -------------------------------------
    // Show Two-Factor Management Page
    // -------------------------------------
    public function index(Request $request, SetupTwoFactorAction $action, TwoFactorManagementResponse $response)
    {
        $data = null;

        if (!$request->user()->hasEnabledTwoFactorAuthentication()) {
            $data = $action->execute($request);
        }

        return $response->index($request, $data);
    }


    // -------------------------------------
    // Enable Two-Factor Authentication
    // -------------------------------------
    public function enable(EnableTwoFactorRequest $request, EnableTwoFactorAuthenticationAction $action, TwoFactorManagementResponse $response)
    {
        $recoveryCodes = $action->execute(
            request: $request,
            data: $request->validated()
        );

        return $response->enable($request, $recoveryCodes);
    }

    
    // -------------------------------------
    // Disable Two-Factor Authentication
    // -------------------------------------
    public function disable(Request $request, DisableTwoFactorAuthenticationAction $action, TwoFactorManagementResponse $response)
    {
        $action->execute($request);

        return $response->disable();
    }

    
    // -------------------------------------
    // Regenerate Recovery Codes
    // -------------------------------------
    public function regenerate(Request $request, RegenerateRecoveryCodesAction $action, TwoFactorManagementResponse $response)
    {
        $codes = $action->execute($request);

        return $response->regenerate($codes);
    }
}