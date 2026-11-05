<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

use Illuminate\Http\Request;

class LogoutResponse
{
    public function toResponse(Request $request)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'خروج از حساب موفقیت‌آمیز بود.',
            ]);
        }

        return redirect()->route('login');
    }
}