<?php

namespace Aliqsm\LaravelAuthkit\TwoFactor;

use Exception;
use Illuminate\Http\Request;

class InvalidTwoFactorCodeException extends Exception
{
    public function __construct(
        string $msg = 'کد وارد شده معتبر نمی‌باشد.'
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
        return back()->with([
            'type' => 'error',
            'message' => $this->getMessage(),
        ])->withInput();
    }
}
