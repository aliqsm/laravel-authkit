<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // ------------------------------------
    // Email Verification Status
    // ------------------------------------
    public function showVerificationNotice(Request $request)
    {
        $user = $request->user();
        $userVerifiedEmail = $user->hasVerifiedEmail();

        return response()->json([
            'message' => $userVerifiedEmail
                ? 'ایمیل حساب شما قبلاً تأیید شده است.'
                : 'ایمیل حساب شما هنوز تأیید نشده است.',
            'data' => [
                'email_verified' => $userVerifiedEmail,
            ],
        ]);
    }

    // ------------------------------------
    // Send Email Verification Notification
    // ------------------------------------
    public function resendVerificationEmail(Request $request)
    {
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return response()->json([
            'message' => 'اگر حساب شما هنوز تأیید نشده باشد، لینک تأیید ارسال می‌شود.',
        ]);
    }


    
    // ------------------------------------
    // Verify Email Address
    // ------------------------------------
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $frontendUrl = config('authkit.frontend_url');

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($frontendUrl . '/email/verified?status=already');
        }

        $request->fulfill();

        return redirect($frontendUrl . '/email/verified?status=success');
    }
}