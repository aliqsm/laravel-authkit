<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Password;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Actions\Password\ResetPasswordAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Password\ResetPasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Password\ResetPasswordResponse;

class ResetPasswordController extends Controller
{
    // ------------------------------------
    // Show Reset Password Form
    // ------------------------------------
    public function show(Request $request)
    {
        return view('authkit::auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }


    
    // ------------------------------------
    // Reset Password
    // ------------------------------------
    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $action, ResetPasswordResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated(),
        );

        return $response->toResponse($request);
    }
}