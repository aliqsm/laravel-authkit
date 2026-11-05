<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Dashboard;


class ProfileResponse
{
    // ------------------------------------
    // Edit Profile
    // ------------------------------------
    public function edit($user)
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



    // ------------------------------------
    // Update Profile
    // ------------------------------------
    public function update($user)
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