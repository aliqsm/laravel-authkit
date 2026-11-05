<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Dashboard;

use Illuminate\Http\Request;

class ProfileUpdateResponse
{
    public function toResponse(Request $request, $user)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'اطلاعات حساب با موفقیت به‌روزرسانی شد.',
                'user' => [
                    'name' => $user->name,
                ],
            ]);
        }

        return redirect()->route('dashboard')->with(
            'status',
            'اطلاعات حساب با موفقیت به‌روزرسانی شد.'
        );
    }
}