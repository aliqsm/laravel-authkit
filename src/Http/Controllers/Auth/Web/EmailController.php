<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

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

        return view('authkit::auth.verify-email');
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
            'message' => 'اگر حساب شما هنوز تأیید نشده باشد، لینک تأیید ارسال می‌شود.'
        ], 200);
    }



    // ------------------------------------
    // Verify Email Address
    // ------------------------------------
    public function verifyEmail(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'حساب شما قبلاً تایید شده است.');
        }

        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'حساب شما با موفقیت تایید شد.');
    }
}
