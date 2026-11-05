<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

class RegisterResponse
{
    public function toResponse()
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'حساب کاربری شما با موفقیت ایجاد شد',
                'data' => [
                    'next_step' => 'email_verification',
                ],
            ]);
        }

        return response()->json([
            'message' => 'حساب کاربری شما با موفقیت ایجاد شد',
            'data' => [
                'redirect' => route('verification.notice'),
            ],
        ]);
    }
}
