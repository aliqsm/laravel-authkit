<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Aliqsm\LaravelAuthkit\Actions\Auth\GoogleAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Responses\Auth\GoogleLoginResponse;

class SocialiteController extends Controller
{
    // ------------------------------------
    // Redirect User to Google
    // ------------------------------------
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    // ------------------------------------
    // Handle Google Callback
    // ------------------------------------
    public function handleGoogleCallback(Request $request, GoogleAction $action, GoogleLoginResponse $response)
    {
        $result = $action->execute($request);

        return $response->toResponse($result);
    }
}