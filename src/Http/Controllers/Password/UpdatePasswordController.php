<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Password;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\Password\ChangePasswordAction;
use Aliqsm\LaravelAuthkit\Http\Requests\Password\UpdatePasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Password\UpdatePasswordResponse;

class UpdatePasswordController extends Controller
{
    // ------------------------------------
    // Show Change Password Form
    // ------------------------------------
    public function edit()
    {
        return view('authkit::dashboard.password.change-password');
    }


    
    // ------------------------------------
    // Update Password
    // ------------------------------------
    public function update(UpdatePasswordRequest $request, ChangePasswordAction $action, UpdatePasswordResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return $response->toResponse($request);
    }
}