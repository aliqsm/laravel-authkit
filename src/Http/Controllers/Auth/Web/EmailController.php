<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\Email\ResendVerificationEmailAction;
use Aliqsm\LaravelAuthkit\Actions\Email\VerifyEmailAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


class EmailController extends Controller
{
    // ------------------------------------
    // Show Email Verification Notice
    // ------------------------------------
    public function showVerificationNotice(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }



    // ------------------------------------
    // Send Email Verification Notification
    // ------------------------------------
    public function resendVerificationEmail(Request $request, ResendVerificationEmailAction $action)
    {
        $action->execute($request);

        return response()->json([
            'message' => 'اگر حساب شما هنوز تأیید نشده باشد، لینک تأیید ارسال می‌شود.',
        ]);
    }



    // ------------------------------------
    // Verify Email Address
    // ------------------------------------
    public function verifyEmail(EmailVerificationRequest $request, VerifyEmailAction $action)
    {
        $action->execute($request);

        return redirect()->route('dashboard');
    }
}
