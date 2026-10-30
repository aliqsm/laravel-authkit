<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Api;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Illuminate\Http\Request;

class SecurityActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = $request->user()
            ->notifications()
            ->where('type', SecurityEventNotification::class)
            ->latest()
            ->limit(20)
            ->get(['id', 'data', 'read_at', 'created_at']);

        return response()->json([
            'message' => '',
            'data' => [
                'activities' => $activities,
            ],
        ]);
    }
}