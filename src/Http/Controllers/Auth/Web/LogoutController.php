<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Http\Requests\Auth\LogoutOtherDevicesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogoutController extends Controller
{
    // ------------------------------------
    // Logout
    // ------------------------------------
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'خروج از حساب موفقیت‌آمیز بود.',
            'data' => [
                'redirect' => route('login'),
            ],
        ]);
    }



    // ------------------------------------
    // Logout Other Devices
    // ------------------------------------
    public function logoutOtherDevices(LogoutOtherDevicesRequest $request)
    {
        $user = $request->user();

        // ------------------------------------
        // Invalidate Other Device Sessions
        // ------------------------------------
        Auth::logoutOtherDevices($request->password);

        if (config('session.driver') === 'database') {
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', $request->session()->getId())
                ->delete();
        }

        // ------------------------------------
        // Regenerate Current Session
        // ------------------------------------
        $user->setRememberToken(Str::random(72))->save();

        $request->session()->regenerate();

        return response()->json([
            'message' => 'خروج از حساب در تمامی دستگاه‌های دیگر با موفقیت انجام شد.',
            'data' => [
                'refresh' => true,
            ],
        ]);
    }
}