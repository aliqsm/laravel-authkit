<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api;

use Aliqsm\LaravelAuthkit\Actions\Logout\LogoutAction;
use Aliqsm\LaravelAuthkit\Actions\Logout\LogoutOtherDevicesAction;
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
    public function logout(Request $request, LogoutAction $action)
    {
        $action->execute(
            request: $request,
        );

        return response()->json([
            'message' => 'خروج از حساب موفقیت‌آمیز بود.',
        ]);
    }



    // ------------------------------------
    // Logout Other Devices
    // ------------------------------------
    public function logoutOtherDevices(LogoutOtherDevicesRequest $request, LogoutOtherDevicesAction $action)
    {
        $action->execute(
            request: $request,
        );

        return response()->json([
            'message' => 'خروج از حساب در تمامی دستگاه‌های دیگر با موفقیت انجام شد.'
        ]);
    }
}
