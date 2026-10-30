<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Actions\Register\RegisterAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    // ------------------------------------
    // Register
    // ------------------------------------
    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $action->execute(
            data: $request->validated(),
        );

        return response()->json([
            'message' => 'درحال انتقال به صفحه تأیید ایمیل',
            'data' => [
                'next_step' => 'email_verification',
            ],
        ], 200);
    }
}