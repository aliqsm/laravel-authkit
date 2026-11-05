<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Dashboard\UpdateProfileRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Dashboard\ProfileResponse;

class ProfileController extends Controller
{
    // -------------------------------------
    // Edit Profile
    // -------------------------------------
    public function edit(Request $request, ProfileResponse $response)
    {
        $user = $request->user();

        return $response->edit($user);
    }



    // -------------------------------------
    // Update Profile
    // -------------------------------------
    public function update(UpdateProfileRequest $request, ProfileResponse $response)
    {
        $user = $request->user();

        $user->update([
            'name' => $request->validated()['name'],
        ]);

        return $response->update($user);
    }
}
