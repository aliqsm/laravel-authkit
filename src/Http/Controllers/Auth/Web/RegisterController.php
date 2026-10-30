<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Actions\Register\RegisterAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    // ------------------------------------
    // Show Register Form
    // ------------------------------------
    public function show()
    {
        return view('auth.register');
    }



    
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
                'redirect' => route('verification.notice'),
            ],
        ], 200);
    }
}