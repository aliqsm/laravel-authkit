<?php

use Illuminate\Support\Facades\Route;

use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\LoginController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\RegisterController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\ResetPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\EmailController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\ForgotPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\LogoutController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\PasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\SocialiteController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Api\TwoFactorController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Api\ProfileController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Api\SessionController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Api\SecurityActivityController;



Route::middleware('api')->group(function () {
    Route::prefix('dashboard')->middleware(['auth:sanctum', 'verified'])->group(function () {

        // -------------------------------------
        // Edit Profile
        // -------------------------------------
        if (config('authkit.features.update_profile_information', true)) {
            Route::prefix('profile')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('api.profile.edit')->middleware('throttle:my_auth_pages');
                Route::put('/', [ProfileController::class, 'update'])->name('api.profile.update')->middleware('throttle:update_profile');
            });
        }


        // -------------------------------------
        // Sessions
        // -------------------------------------
        Route::get('/sessions', [SessionController::class, 'index'])->name('api.dashboard.sessions.index')->middleware('throttle:my_auth_pages');


        // -------------------------------------
        // Security Activities
        // -------------------------------------
        if (config('authkit.features.security_activities', true)) {
            Route::get('/security-activities', [SecurityActivityController::class, 'index'])->name('api.dashboard.security-activities.index')->middleware('throttle:my_auth_pages');
        }


        // -------------------------------------
        // Change Password
        // -------------------------------------
        if (config('authkit.features.change_password', true)) {
            Route::put('/password', [PasswordController::class, 'update'])->name('api.password.change')->middleware(['password.confirm', 'throttle:change_password']);
        }
    });




    Route::middleware('guest')->group(function () {

        // -------------------------------------
        // Login
        // -------------------------------------
        Route::post('/login', [LoginController::class, 'login'])->name('api.login')->middleware('throttle:login');


        // -------------------------------------
        // Login/Register With Oauth
        // -------------------------------------
        if (config('authkit.features.google_login', true)) {
            Route::prefix('oauth/google')->middleware('throttle:my_auth_pages')->group(function () {
                Route::get('/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('api.oauth.google.redirect');
                Route::get('/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('api.oauth.google.callback');
            });
        }


        // -------------------------------------
        // Register
        // -------------------------------------
        if (config('authkit.features.registration', true)) {
            Route::post('/register', [RegisterController::class, 'register'])->name('api.register')->middleware('throttle:register');
        }


        // -------------------------------------
        // Forgot Password
        // -------------------------------------
        if (config('authkit.features.password_reset', true)) {
            Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('api.password.email')->middleware('throttle:forgot_password');
        }


        // -------------------------------------
        // 2FA Challenge
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa/challenge')->group(function () {
                Route::get('/', [TwoFactorController::class, 'show'])->name('api.two-factor.challenge')->middleware('throttle:my_auth_pages');
                Route::post('/', [TwoFactorController::class, 'verify'])->name('api.two-factor.verify')->middleware('throttle:two_factor_verify');
            });
        }
    });




    // -------------------------------------
    // Password Reset
    // Guest + Authenticated
    // -------------------------------------
    if (config('authkit.features.password_reset', true)) {
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('api.password.update')->middleware('throttle:reset_password');
    }



    Route::middleware('auth:sanctum')->group(function () {

        // -------------------------------------
        // Email Verification
        // -------------------------------------
        Route::prefix('email')->group(function () {
            Route::get('/verify', [EmailController::class, 'showVerificationNotice'])->name('api.verification.notice')->middleware('throttle:my_auth_pages');
            Route::post('/verification-notification', [EmailController::class, 'resendVerificationEmail'])->name('api.verification.send')->middleware('throttle:resend_verification_email');
            Route::get('/verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->name('api.verification.verify')->middleware(['signed', 'throttle:verification_verify']);
        });


        // -------------------------------------
        // Logout
        // -------------------------------------
        Route::prefix('logout')->middleware('throttle:logout')->group(function () {
            Route::post('/', [LogoutController::class, 'logout'])->name('api.logout');
            Route::post('/logout-other-devices', [LogoutController::class, 'logoutOtherDevices'])->name('api.sessions.destroy');
        });


        // -------------------------------------
        // Confirm Password
        // -------------------------------------
        Route::post('/confirm-password', [PasswordController::class, 'store'])->name('api.password.confirm.verify')->middleware('throttle:password_confirm');


        // -------------------------------------
        // Send Password Reset Link (Authenticated)
        // -------------------------------------
        // برای وقتی که کاربر با گوگل ثبت نام کرده و رمز عبورش رو نمیدونه
        if (config('authkit.features.password_reset', true)) {
            Route::post('/password/send-reset-link', [ForgotPasswordController::class, 'sendResetLinkForAuthenticatedUser'])->name('api.password.send-reset-link')->middleware('throttle:forgot_password');
        }


        // -------------------------------------
        // 2FA
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa')->middleware('password.confirm')->group(function () {
                Route::get('/', [TwoFactorController::class, 'index'])->name('api.two-factor.index')->middleware('throttle:my_auth_pages');
                Route::post('/enable', [TwoFactorController::class, 'enable'])->name('api.two-factor.enable')->middleware('throttle:two_factor_enable');
                Route::post('/disable', [TwoFactorController::class, 'disable'])->name('api.two-factor.disable')->middleware('throttle:two_factor_disable');
                Route::post('/regenerate', [TwoFactorController::class, 'regenerate'])->name('api.two-factor.recovery-code.regenerate')->middleware('throttle:two_factor_generate_recovery_code');
            });
        }
    });
});