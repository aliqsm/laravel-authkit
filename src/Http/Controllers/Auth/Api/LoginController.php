<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Actions\Login\LoginAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    // ------------------------------------
    // Login
    // ------------------------------------
    public function login(LoginRequest $request, LoginAction $action)
    {
        $result = $action->execute(
            request: $request,
            data: $request->validated(),
        );

        $next_step = match ($result) {
            'two_factor' => 'two-factor-challenge-form',
            'success' => 'dashboard',
        };

        return response()->json([
            'message' => 'درحال ورود...',
            'data' => [
                'next_step' => $next_step,
            ],
        ]);
    }
}
