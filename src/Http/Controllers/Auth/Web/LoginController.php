<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\Login\LoginAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\LoginRequest;

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
    public function login(LoginRequest $request, LoginAction $action)
    {
        $result = $action->execute(
            request: $request,
            data: $request->validated(),
        );

        $redirect = match ($result) {
            'two_factor' => route('two-factor.challenge'),
            'success' => route('dashboard'),
        };

        return response()->json([
            'message' => 'درحال ورود...',
            'data' => [
                'redirect' => $redirect,
            ],
        ]);
    }
}