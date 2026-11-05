<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Password;

class ForgotPasswordResponse
{
    public function toResponse(bool $authenticatedUser = false)
    {
        $message = $authenticatedUser
            ? 'لینک بازیابی رمز عبور برای شما ارسال شد. لطفاً صندوق ورودی ایمیل خود را بررسی کنید.'
            : 'اگر حسابی با این ایمیل وجود داشته باشد، لینک بازیابی ارسال خواهد شد.';

        return response()->json([
            'message' => $message,
        ]);
    }
}
