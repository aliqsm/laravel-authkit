<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Password;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\Password\UpdatePasswordAction;
use Aliqsm\LaravelAuthkit\Http\Requests\Password\UpdatePasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Password\UpdatePasswordResponse;

class UpdatePasswordController extends Controller
{
    // ------------------------------------
    // Show Update Password Form
    // ------------------------------------
    public function edit()
    {
        return view('authkit::dashboard.password.update-password');
    }


    
    // ------------------------------------
    // Update Password
    // ------------------------------------
    public function update(UpdatePasswordRequest $request, UpdatePasswordAction $action, UpdatePasswordResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return $response->toResponse($request);
    }
}