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
        $appMode = config('authkit.app_mode');
        $url = null;

        if ($appMode === 'api') {
            $url = rtrim(config('authkit.email_verification_redirect_url'), '/');
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $appMode === 'api'
                ? redirect($url . '?status=already')
                : response()->json(['message' => 'ایمیل حساب شما قبلاً تأیید شده است.']);
        }

        $request->fulfill();

        return $appMode === 'api'
            ? redirect($url . '?status=success')
            : response()->json(['message' => 'ایمیل شما با موفقیت تأیید شد.']);
    }
}
