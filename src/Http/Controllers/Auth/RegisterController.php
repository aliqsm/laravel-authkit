<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth;

use Aliqsm\LaravelAuthkit\Actions\Auth\RegisterAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\RegisterRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Auth\RegisterResponse;

class RegisterController extends Controller
{
    // ------------------------------------
    // Show Register Form
    // ------------------------------------
    public function show()
    {
        return view('authkit::auth.register');
    }

    // ------------------------------------
    // Register
    // ------------------------------------
    public function register(RegisterRequest $request, RegisterAction $action, RegisterResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated(),
        );

        return $response->toResponse($request);
    }
}
