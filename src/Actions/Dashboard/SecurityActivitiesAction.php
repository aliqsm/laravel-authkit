<?php

namespace Aliqsm\LaravelAuthkit\Actions\Dashboard;

use Aliqsm\LaravelAuthkit\Notifications\SecurityEventNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SecurityActivitiesAction
{
    public function execute(Request $request): Collection
    {
        return $request->user()
            ->notifications()
            ->where('type', SecurityEventNotification::class)
            ->latest()
            ->limit(20)
            ->get(['id', 'data', 'read_at', 'created_at']);
    }
}
