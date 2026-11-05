<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\TwoFactor;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\TwoFactor\VerifyTwoFactorChallengeAction;
use Aliqsm\LaravelAuthkit\Http\Requests\TwoFactor\TwoFactorChallengeRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\TwoFactor\TwoFactorChallengeResponse;

class TwoFactorChallengeController extends Controller
{
    // -------------------------------------
    // Show Two-Factor Challenge Page
    // -------------------------------------
    public function show(Request $request, TwoFactorChallengeResponse $response)
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

            return $response->expired();
        }

        return $response->show();
    }


    
    // -------------------------------------
    // Verify Two-Factor Code
    // -------------------------------------
    public function verify(TwoFactorChallengeRequest $request, VerifyTwoFactorChallengeAction $action, TwoFactorChallengeResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return $response->verify();
    }
}