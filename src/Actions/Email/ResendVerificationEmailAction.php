<?php

namespace Aliqsm\LaravelAuthkit\Actions\Email;

use Illuminate\Http\Request;

class ResendVerificationEmailAction
{
    public function execute(Request $request): void
    {
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }
    }
}
