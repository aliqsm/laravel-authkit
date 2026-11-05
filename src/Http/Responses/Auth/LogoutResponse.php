<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

use Illuminate\Http\Request;

class LogoutResponse
{
    public function toResponse(Request $request)
    {
        return response()->json([
            'message' => 'خروج از حساب موفقیت‌آمیز بود.',
            'data' => [
                'redirect' => config('authkit.app_mode') === 'api'
                    ? null
                    : route('login'),
            ],
        ]);
    }
}