<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Password;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Actions\Password\ForgotPasswordAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Password\ForgotPasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Password\ForgotPasswordResponse;

class ForgotPasswordController extends Controller
{
    // ------------------------------------
    // Show Forgot Password Form
    // ------------------------------------
    public function show()
    {
        return view('authkit::auth.forget-password');
    }


    // ------------------------------------
    // Forgot Password
    // ------------------------------------
    public function forgotPassword(ForgotPasswordRequest $request, ForgotPasswordAction $action, ForgotPasswordResponse $response)
    {
        $action->execute(
            data: $request->validated()
        );

        return $response->toResponse();
    }


    // ------------------------------------
    // Send Password Reset Link for Authenticated User
    // ------------------------------------
    // برای وقتی که کاربر با گوگل ثبت نام کرده و رمز عبورش رو نمیدونه
    public function sendResetLinkForAuthenticatedUser(Request $request, ForgotPasswordAction $action, ForgotPasswordResponse $response)
    {
        $action->execute(data: [
            'email' => $request->user()->email,
        ]);

        return $response->toResponse();
    }
}