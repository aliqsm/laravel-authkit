<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

use Illuminate\Http\Request;

class RegisterResponse
{
    public function toResponse(Request $request)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'درحال انتقال به صفحه تأیید ایمیل',
                'data' => [
                    'next_step' => 'email_verification',
                ],
            ], 200);
        }

        return redirect()->route('verification.notice');
    }
}