<?php

namespace Aliqsm\LaravelAuthkit\Exceptions;

use Exception;
use Illuminate\Http\Request;

class PasswordResetLinkException extends Exception
{
    public function __construct(
        string $msg = 'خطایی در ارسال لینک بازیابی رمزعبور رخ داد.'
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
            ], 500);
        }


        // ---------------------------------------
        // Web
        // ---------------------------------------
        return response()->view('errors.500', [
            'message' => $this->getMessage(),
        ], 500);
    }
}
