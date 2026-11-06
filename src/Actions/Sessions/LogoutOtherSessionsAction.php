<?php

namespace Aliqsm\LaravelAuthkit\Actions\Sessions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogoutOtherSessionsAction
{
    public function execute(Request $request, array $data): void
    {
        $user = $request->user();

        Auth::guard('web')->logoutOtherDevices($data['password']);

        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $request->session()->getId())
                ->delete();
        }

        $user->setRememberToken(Str::random(60));
        $user->save();

        $request->session()->regenerate();
    }
}