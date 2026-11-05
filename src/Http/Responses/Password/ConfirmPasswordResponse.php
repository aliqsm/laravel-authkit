<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Password;

use Illuminate\Http\Request;

class ConfirmPasswordResponse
{
    public function toResponse(Request $request)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'تأیید هویت با موفقیت انجام شد.',
                'data' => [
                    'password_confirmed' => true,
                ],
            ]);
        }

        return redirect()->intended();
    }
}