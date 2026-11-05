<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Password;

use Illuminate\Http\Request;

class ResetPasswordResponse
{
    public function toResponse(Request $request)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'گذرواژه شما با موفقیت تغییر کرد.',
                'data' => [
                    'password_reset' => true,
                ],
            ]);
        }

        return redirect()->route('login')->with(
            'status',
            'گذرواژه شما با موفقیت تغییر کرد.'
        );
    }
}