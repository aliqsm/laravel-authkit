<?php

namespace Aliqsm\LaravelAuthkit\Exceptions\TwoFactor;

use Exception;
use Illuminate\Http\Request;

class TwoFactorChallengeInvalidException extends Exception
{
    public function __construct(
        string $msg = 'درخواست تأیید دومرحله‌ای نامعتبر یا منقضی شده است. لطفاً مجدداً وارد حساب خود شوید.'
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
