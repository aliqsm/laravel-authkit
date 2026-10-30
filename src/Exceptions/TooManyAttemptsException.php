<?php

namespace Aliqsm\LaravelAuthkit\Exceptions;

use Exception;
use Illuminate\Http\Request;

class TooManyAttemptsException extends Exception
{
    public function __construct(
        string $msg = 'تعداد تلاش‌های شما بیش از حد بوده. لطفاً چند دقیقه دیگر مجدداً تلاش نمایید.'
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
            ], 429);
        }


        // ---------------------------------------
        // Web
        // ---------------------------------------
        return response()->view('errors.429', [
            'message' => $this->getMessage(),
        ], 429);
    }
}
