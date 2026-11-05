<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Password;

use Illuminate\Http\Request;

class ResetPasswordResponse
{
    public function toResponse(Request $request)
    {
        $message = 'گذرواژه شما با موفقیت تغییر کرد.';

        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => $message,
                'data' => [
                    'password_reset' => true,
                ],
            ]);
        }

        return response()->json([
            'message' => $message,
            'data' => [
                'redirect' => route('login'),
            ],
        ]);
    }
}