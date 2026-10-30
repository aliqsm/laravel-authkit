<?php

namespace Aliqsm\LaravelAuthkit\Actions\Register;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterAction
{
    public function execute(array $data): void
    {
        $userModel = config('auth.providers.users.model');

        DB::transaction(function () use ($data, $userModel) {
            $user = $userModel::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            event(new Registered($user));
            Auth::login($user, false);
            request()->session()->regenerate();
        });
    }
}