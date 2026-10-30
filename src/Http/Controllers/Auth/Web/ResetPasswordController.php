<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\Password\ResetPasswordAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\Request;

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
    public function resetPassword(ResetPasswordRequest $request, ResetPasswordAction $action)
    {
        $action->execute(
            request: $request,
            data: $request->validated(),
        );

        return response()->json([
            'message' => 'گذرواژه شما با موفقیت تغییر کرد.',
            'data' => [
                'redirect' => route('login'),
            ],
        ], 200);
    }
}