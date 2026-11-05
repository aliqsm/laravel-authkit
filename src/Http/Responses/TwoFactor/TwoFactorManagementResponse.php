<?php

namespace Aliqsm\LaravelAuthkit\Http\Responses\TwoFactor;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFactorManagementResponse
{
    // -------------------------------------
    // Show Two-Factor Management
    // -------------------------------------
    public function index(?array $data)
    {
        if (config('authkit.app_mode') === 'api') {
            if ($data === null) {
                return response()->json([
                    'message' => 'تأیید دومرحله‌ای قبلاً فعال شده است.',
                    'data' => [
                        'enabled' => true,
                    ],
                ]);
            }

            return response()->json([
                'message' => 'اطلاعات راه‌اندازی تأیید دومرحله‌ای آماده است.',
                'data' => [
                    'enabled' => false,
                    'secret' => $data['secret'],
                    'qr_url' => $data['qrUrl'],
                ],
            ]);
        }

        if ($data === null) {
            return view('authkit::dashboard.2fa.manage');
        }

        return view('authkit::dashboard.2fa.setup', [
            'qrImage' => QrCode::size(150)->generate($data['qrUrl']),
            'secret' => $data['secret'],
        ]);
    }


    // -------------------------------------
    // Enable Two-Factor Authentication
    // -------------------------------------
    public function enable(Request $request, array $recoveryCodes)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'تأیید دومرحله‌ای با موفقیت فعال شد.',
                'data' => [
                    'enabled' => true,
                    'recovery_codes' => $recoveryCodes,
                ],
            ]);
        }

        $request->session()->flash('recovery_codes', $recoveryCodes);

        return response()->json([
            'message' => 'تأیید دومرحله‌ای با موفقیت فعال شد.',
            'data' => [
                'redirect' => route('two-factor.index'),
            ],
        ]);
    }


    // -------------------------------------
    // Disable Two-Factor Authentication
    // -------------------------------------
    public function disable()
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'تأیید دومرحله‌ای با موفقیت غیرفعال شد.',
                'data' => [
                    'enabled' => false,
                ],
            ]);
        }

        return response()->json([
            'message' => 'تأیید دومرحله‌ای با موفقیت غیرفعال شد.',
        ]);
    }


    // -------------------------------------
    // Regenerate Recovery Codes
    // -------------------------------------
    public function regenerate(array $codes)
    {
        if (config('authkit.app_mode') === 'api') {
            return response()->json([
                'message' => 'کدهای بازیابی با موفقیت تولید شدند.',
                'data' => [
                    'recovery_codes' => $codes,
                ],
            ]);
        }

        return response()->json([
            'message' => 'کدهای بازیابی با موفقیت تولید شدند.',
            'data' => [
                'recovery_codes' => $codes,
            ],
        ]);
    }
}