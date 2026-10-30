<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Actions\Password\ResetPasswordAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    // ------------------------------------
    // Reset Password
    // ------------------------------------
    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $action)
    {
        $action->execute(
            request: $request,
            data: $request->validated(),
        );

        return response()->json([
            'message' => 'گذرواژه شما با موفقیت تغییر کرد.',
            'data' => [
                'password_reset' => true,
            ],
        ]);
    }
}