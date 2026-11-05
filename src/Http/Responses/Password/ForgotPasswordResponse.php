<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Password;

use Illuminate\Http\Request;

class ForgotPasswordResponse
{
    public function toResponse(Request $request)
    {
        $message = 'اگر حسابی با این ایمیل وجود داشته باشد، لینک بازیابی ارسال خواهد شد.';

        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => $message,
            ]);
        }

        return back()->with('status', $message);
    }
}