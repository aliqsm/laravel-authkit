<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Password;

use Illuminate\Http\Request;

class UpdatePasswordResponse
{
    public function toResponse(Request $request)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'رمز عبور با موفقیت تغییر یافت.',
                'data' => [
                    'password_changed' => true,
                ],
            ]);
        }

        return response()->json([
            'message' => 'رمز عبور با موفقیت تغییر یافت.',
            'data' => [
                'redirect' => route('dashboard'),
            ],
        ]);
    }
}