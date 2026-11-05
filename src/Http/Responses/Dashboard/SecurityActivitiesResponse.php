<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class SecurityActivitiesResponse
{
    public function toResponse(Request $request, Collection $activities)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => '',
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