<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Sessions;

class UserSessionsResponse
{
    public function toResponse($sessions)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'data' => [
                    'sessions' => $sessions,
                ],
            ]);
        }

        return view('authkit::dashboard.sessions.index', [
            'sessions' => $sessions,
        ]);
    }
}