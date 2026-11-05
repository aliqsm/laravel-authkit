<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth;

use Aliqsm\LaravelAuthkit\Actions\Auth\LoginAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\LoginRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Auth\LoginResponse;

class LoginController extends Controller
{
    // ------------------------------------
    // Show Login Form
    // ------------------------------------
    public function show()
    {
        return view('authkit::auth.login');
    }


    
    // ------------------------------------
    // Login
    // ------------------------------------
    public function login(LoginRequest $request, LoginAction $action, LoginResponse $response)
    {
        $result = $action->execute(
            request: $request,
            data: $request->validated(),
        );

        return $response->toResponse($request, $result);
    }
}