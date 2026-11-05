<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Email;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\Email\ResendVerificationEmailAction;
use Aliqsm\LaravelAuthkit\Actions\Email\VerifyEmailAction;
use Aliqsm\LaravelAuthkit\Http\Responses\Email\EmailVerificationResponse;

class EmailController extends Controller
{
    // ------------------------------------
    // Show Email Verification Notice
    // ------------------------------------
    public function showVerificationNotice(Request $request, EmailVerificationResponse $response)
    {
        return $response->showVerificationNotice($request);
    }



    // ------------------------------------
    // Send Email Verification Notification
    // ------------------------------------
    public function resendVerificationEmail(Request $request, ResendVerificationEmailAction $action, EmailVerificationResponse $response)
    {
        $action->execute($request);

        return $response->resendVerificationEmail();
    }



    // ------------------------------------
    // Verify Email Address
    // ------------------------------------
    public function verifyEmail(EmailVerificationRequest $request, VerifyEmailAction $action, EmailVerificationResponse $response)
    {
        $alreadyVerified = $request->user()->hasVerifiedEmail();

        if (!$alreadyVerified) {
            $action->execute($request);
        }

        return $response->verifyEmail($alreadyVerified);
    }
}
