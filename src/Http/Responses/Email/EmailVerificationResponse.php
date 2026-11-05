<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Email;

use Illuminate\Http\Request;

class EmailVerificationResponse
{
    // ------------------------------------
    // Show Email Verification Notice
    // ------------------------------------
    public function showVerificationNotice(Request $request)
    {
        $verified = $request->user()->hasVerifiedEmail();

        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => $verified
                    ? 'ایمیل حساب شما قبلاً تأیید شده است.'
                    : 'ایمیل حساب شما هنوز تأیید نشده است.',
                'data' => [
                    'email_verified' => $verified,
                ],
            ]);
        }

        if ($verified) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-email');
    }



    // ------------------------------------
    // Resend Verification Email
    // ------------------------------------
    public function resendVerificationEmail()
    {
        return response()->json([
            'message' => 'اگر حساب شما هنوز تأیید نشده باشد، لینک تأیید ارسال می‌شود.',
        ]);
    }



    // ------------------------------------
    // Verify Email Address
    // ------------------------------------
    public function verifyEmail(Request $request, bool $alreadyVerified)
    {
        if (config('authkit.app_mode') === 'api') {
            $url = rtrim(config('authkit.api_email_verification_redirect_url'), '/');

            return redirect($url . '?status=' . ($alreadyVerified ? 'already' : 'success'));
        }

        return redirect()->route('dashboard');
    }
}
