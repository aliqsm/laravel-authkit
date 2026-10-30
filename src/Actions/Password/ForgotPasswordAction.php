<?php

namespace Aliqsm\LaravelAuthkit\Actions\Password;

use Aliqsm\LaravelAuthkit\PasswordResetLinkException;
use Illuminate\Support\Facades\Password;

class ForgotPasswordAction
{
    public function execute(array $data): void
    {
        $status = Password::sendResetLink(['email' => $data['email']]);

        if (in_array($status, [Password::RESET_LINK_SENT, Password::INVALID_USER, Password::RESET_THROTTLED], true)) {
            return;
        }

        throw new PasswordResetLinkException();
    }
}
