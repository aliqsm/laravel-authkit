<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Sessions;

class LogoutOtherSessionsResponse
{
    public function toResponse()
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'تمام نشست‌های دیگر با موفقیت خارج شدند.',
            ]);
        }

        
        return redirect()->back()->with([
            'type' => 'success',
            'message' => 'تمام نشست‌های دیگر با موفقیت خارج شدند.',
        ]);
    }
}