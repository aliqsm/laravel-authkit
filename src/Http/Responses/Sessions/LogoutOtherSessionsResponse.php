<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Sessions;

class LogoutOtherSessionsResponse
{
    public function toResponse()
    {
        return response()->json([
            'message' => 'تمام نشست‌های دیگر با موفقیت خارج شدند.',
            'data' => [
                'refresh' => true,
            ],
        ]);
    }
}