<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Dashboard;

use Illuminate\Database\Eloquent\Collection;

class SecurityActivitiesResponse
{
    public function toResponse(Collection $activities)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'data' => [
                    'activities' => $activities,
                ],
            ]);
        }

        return view('authkit::dashboard.security-activities.index', [
            'activities' => $activities,
        ]);
    }
}