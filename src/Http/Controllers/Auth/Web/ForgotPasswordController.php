<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\Password\ForgotPasswordAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // ------------------------------------
    // Show Forgot Password Form
    // ------------------------------------
    public function show()
    {
        return view('auth.forget-password');
    }



    // ------------------------------------
    // Forgot Password
    // ------------------------------------
    public function forgotPassword(ForgotPasswordRequest $request, ForgotPasswordAction $action)
    {
        $action->execute(
            data: $request->validated()
        );

        return response()->json([
            'message' => 'اگر حسابی با این ایمیل وجود داشته باشد، لینک بازیابی ارسال خواهد شد.'
        ]);
    }



    // ------------------------------------
    // Send Password Reset Link for Authenticated User
    // ------------------------------------
    // برای وقتی که کاربر با گوگل ثبت نام کرده و رمز عبورش رو نمیدونه
    public function sendResetLinkForAuthenticatedUser(Request $request, ForgotPasswordAction $action)
    {
        $action->execute(data: [
            'email' => $request->user()->email
        ]);

        return response()->json([
            'message' => 'لینک بازیابی رمز عبور برای شما ارسال شد. لطفاً صندوق ورودی ایمیل خود را بررسی کنید.'
        ]);
    }
}
