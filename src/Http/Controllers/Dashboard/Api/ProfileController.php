<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Api;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Dashboard\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // -------------------------------------
    // Edit Profile
    // -------------------------------------
    public function edit(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'name' => $user->name,
            ],
        ]);
    }

    

    // -------------------------------------
    // Update Profile
    // -------------------------------------
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'اطلاعات حساب با موفقیت به‌روزرسانی شد.',
            'user' => [
                'name' => $user->name,
            ],
        ]);
    }
}