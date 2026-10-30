<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\Password\ChangePasswordAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Dashboard\ChangePasswordRequest;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\ConfirmPasswordRequest;

class PasswordController extends Controller
{
    // ------------------------------------
    // Show Confirm Password Form
    // ------------------------------------
    public function show()
    {
        return view('auth.password-confirm');
    }

    // ------------------------------------
    // Confirm Password
    // ------------------------------------
    public function store(ConfirmPasswordRequest $request)
    {
        $request->session()->passwordConfirmed();

        return response()->json([
            'message' => 'تأیید هویت با موفقیت انجام شد.',
            'data' => [
                'redirect' => redirect()->intended()->getTargetUrl(),
            ],
        ]);
    }



    // ------------------------------------
    // Show Change Password Form
    // ------------------------------------
    public function edit()
    {
        return view('dashboard.password.change-password');
    }


    
    // ------------------------------------
    // Change Password
    // ------------------------------------
    public function update(ChangePasswordRequest $request, ChangePasswordAction $action)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return response()->json([
            'message' => 'رمز عبور با موفقیت تغییر یافت.',
            'data' => [
                'redirect' => route('dashboard'),
            ],
        ]);
    }
}