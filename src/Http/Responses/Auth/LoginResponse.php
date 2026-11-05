<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\Auth;

use Illuminate\Http\Request;

class LoginResponse
{
    public function toResponse(Request $request, string $result)
    {
        if (config('authkit.app_mode') === 'api') {
            $nextStep = match ($result) {
                'two_factor' => 'two-factor-challenge-form',
                'success' => 'dashboard',
            };

            return response()->json([
                'message' => 'درحال ورود...',
                'data' => [
                    'next_step' => $nextStep,
                ],
            ]);
        }

        
        $redirect = match ($result) {
            'two_factor' => route('two-factor.challenge'),
            'success' => route('dashboard'),
        };

        return redirect()->to($redirect);
    }
}