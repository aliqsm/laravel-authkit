<?php

namespace Aliqsm\LaravelAuthkit\TwoFactor;

use Exception;
use Illuminate\Http\Request;

class TwoFactorAlreadyEnabledException extends Exception
{
    public function __construct(
        string $msg = 'تأیید هویت دو مرحله‌ای برای این حساب فعال است.'
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
            'type' => 'info',
            'message' => $this->getMessage(),
        ])->withInput();
    }
}
