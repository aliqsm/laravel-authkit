<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Password;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\Password\ChangePasswordAction;
use Aliqsm\LaravelAuthkit\Http\Requests\Password\ChangePasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Password\ChangePasswordResponse;

class ChangePasswordController extends Controller
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
    public function update(ChangePasswordRequest $request, ChangePasswordAction $action, ChangePasswordResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return $response->toResponse($request);
    }
}