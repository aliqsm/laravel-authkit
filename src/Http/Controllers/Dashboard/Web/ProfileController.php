<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Dashboard\UpdateProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // -------------------------------------
    // Edit Profile
    // -------------------------------------
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('authkit::dashboard.profile.edit', [
            'user' => $user,
        ]);
    }



    
    // -------------------------------------
    // Update Profile
    // -------------------------------------
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'اطلاعات حساب با موفقیت به‌روزرسانی شد.',
            'data' => [
                'redirect' => route('dashboard'),
                'user' => [
                    'name' => $user->name,
                ],
            ],
        ]);
    }
}