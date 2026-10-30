<?php

namespace Aliqsm\LaravelAuthkit\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidCredentialsException extends Exception
{
    public function __construct(
        string $msg = 'نام کاربری یا رمزعبور صحیح نمی‌باشد.'
    ) {
        parent::__construct($msg);
    }


    public function render(Request $request)
    {
        // ---------------------------------------
        // Api
        // ---------------------------------------
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
            ], 422);
        }


        // ---------------------------------------
        // Web
        // ---------------------------------------
        return response()->view('errors.422', [
            'message' => $this->getMessage(),
        ], 422);
    }
}
