<?php

namespace Aliqsm\LaravelAuthkit\Actions\Email;


use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailAction
{
    public function execute(EmailVerificationRequest $request): bool
    {
        if ($request->user()->hasVerifiedEmail()) {
            return false;
        }

        $request->fulfill();

        return true;
    }
}
