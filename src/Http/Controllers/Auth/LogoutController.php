<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Actions\Auth\LogoutAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Responses\Auth\LogoutResponse;

class LogoutController extends Controller
{
    // ------------------------------------
    // Logout
    // ------------------------------------
    public function logout(Request $request, LogoutAction $action, LogoutResponse $response)
    {
        $action->execute(
            request: $request,
        );

        return $response->toResponse($request);
    }
}