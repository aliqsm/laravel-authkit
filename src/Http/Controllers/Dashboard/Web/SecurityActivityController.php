<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web;

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
            ->get();

        return view('dashboard.security-activities.index', [
            'activities' => $activities,
        ]);
    }
}