<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Dashboard;

use Illuminate\Http\Request;

class ProfileEditResponse
{
    public function toResponse(Request $request, $user)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'user' => [
                    'name' => $user->name,
                ],
            ]);
        }

        return view('authkit::dashboard.profile.edit', [
            'user' => $user,
        ]);
    }
}