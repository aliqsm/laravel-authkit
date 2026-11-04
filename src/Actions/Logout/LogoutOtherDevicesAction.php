<?php

namespace Aliqsm\LaravelAuthkit\Actions\Logout;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogoutOtherDevicesAction
{
    public function execute(Request $request): void
    {
        $user = $request->user();

        Auth::logoutOtherDevices($request->password);

        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $request->session()->getId())
                ->delete();
        }

        $user->setRememberToken(Str::random(72));
        $user->save();

        $request->session()->regenerate();
    }
}
