<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Password;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Password\ConfirmPasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Password\ConfirmPasswordResponse;

class ConfirmPasswordController extends Controller
{
    // ------------------------------------
    // Show Confirm Password Form
    // ------------------------------------
    public function show()
    {
        return view('authkit::auth.confirm-password');
    }

    // ------------------------------------
    // Confirm Password
    // ------------------------------------
    public function store(ConfirmPasswordRequest $request, ConfirmPasswordResponse $response)
    {
        $request->session()->passwordConfirmed();

        return $response->toResponse($request);
    }
}