<?php

namespace Aliqsm\LaravelAuthkit\Exceptions\TwoFactor;

use Exception;
use Illuminate\Http\Request;

class TwoFactorSetupSessionExpiredException extends Exception
{
    public function __construct(
        string $msg = 'مهلت انجام فرآیند راه‌اندازی تأیید دومرحله‌ای به پایان رسیده است. لطفاً مجدداً تلاش کنید.'
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
