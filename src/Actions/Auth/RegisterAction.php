<?php

namespace Aliqsm\LaravelAuthkit\Actions\Auth;

use Aliqsm\LaravelAuthkit\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterAction
{
    public function execute(RegisterRequest $request, array $data): void
    {
        $userModel = config('auth.providers.users.model');

        DB::transaction(function () use ($request,$data, $userModel) {
            $user = $userModel::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            event(new Registered($user));
            Auth::login($user, false);
            $request->session()->regenerate();
        });
    }
}
