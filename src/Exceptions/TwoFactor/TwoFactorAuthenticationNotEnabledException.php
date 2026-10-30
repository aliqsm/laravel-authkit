<?php

namespace Aliqsm\LaravelAuthkit\TwoFactor;

use Exception;
use Illuminate\Http\Request;

class TwoFactorAuthenticationNotEnabledException extends Exception
{
    public function __construct(
        string $msg = 'تأیید هویت دومرحله‌ای برای این حساب فعال نمی‌باشد.'
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
            ], 403);
        }


        // ---------------------------------------
        // Web
        // ---------------------------------------
        return back()->with([
            'type' => 'info',
            'message' => $this->getMessage(),
        ]);
    }
}
