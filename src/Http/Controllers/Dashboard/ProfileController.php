<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Dashboard\UpdateProfileRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Dashboard\ProfileEditResponse;
use Aliqsm\LaravelAuthkit\Http\Responses\Dashboard\ProfileUpdateResponse;

class ProfileController extends Controller
{
    // -------------------------------------
    // Edit Profile
    // -------------------------------------
    public function edit(Request $request, ProfileEditResponse $response)
    {
        return $response->toResponse($request, $request->user());
    }


    
    // -------------------------------------
    // Update Profile
    // -------------------------------------
    public function update(UpdateProfileRequest $request, ProfileUpdateResponse $response)
    {
        $user = $request->user();

        $user->update([
            'name' => $request->validated()['name'],
        ]);

        return $response->toResponse($request, $user);
    }
}