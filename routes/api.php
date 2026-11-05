<?php

use Illuminate\Support\Facades\Route;

use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\LoginController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\RegisterController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\LogoutController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\SocialiteController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ResetPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ForgotPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ConfirmPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\UpdatePasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Email\EmailController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\ProfileController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\SecurityActivityController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Sessions\SessionController;
use Aliqsm\LaravelAuthkit\Http\Controllers\TwoFactor\TwoFactorController;
use Aliqsm\LaravelAuthkit\Http\Controllers\TwoFactor\TwoFactorChallengeController;



Route::prefix('api')->middleware('api')->group(function () {
    Route::prefix('dashboard')->middleware(['auth:sanctum', 'verified'])->group(function () {

        // -------------------------------------
        // Edit Profile
        // -------------------------------------
        if (config('authkit.features.update_profile_information', true)) {
            Route::prefix('profile')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('api.profile.edit')->middleware('throttle:authkit_pages');
                Route::put('/', [ProfileController::class, 'update'])->name('api.profile.update')->middleware('throttle:authkit_update_profile');
            });
        }


        // -------------------------------------
        // Sessions
        // -------------------------------------
        Route::prefix('sessions')->middleware('throttle:authkit_logout')->group(function () {
            Route::get('/', [SessionController::class, 'index'])->name('api.dashboard.sessions.index')->middleware('throttle:authkit_pages');
            Route::post('/terminate-others', [SessionController::class, 'destroyOthers'])->name('api.sessions.destroy')->middleware('throttle:authkit_terminate_sessions');
        });


        // -------------------------------------
        // Security Activities
        // -------------------------------------
        if (config('authkit.features.security_activities', true)) {
            Route::get('/security-activities', [SecurityActivityController::class, 'index'])->name('api.dashboard.security-activities.index')->middleware('throttle:authkit_pages');
        }


        // -------------------------------------
        // Update Password
        // -------------------------------------
        if (config('authkit.features.change_password', true)) {
            Route::put('/password', [UpdatePasswordController::class, 'update'])->name('api.password.change')->middleware('throttle:authkit_change_password');
        }
    });




    Route::middleware('guest')->group(function () {

        // -------------------------------------
        // Login
        // -------------------------------------
        Route::post('/login', [LoginController::class, 'login'])->name('api.login')->middleware('throttle:authkit_login');


        // -------------------------------------
        // Login/Register With Oauth
        // -------------------------------------
        if (config('authkit.features.google_login', true)) {
            Route::prefix('oauth/google')->middleware('throttle:authkit_pages')->group(function () {
                Route::get('/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('api.oauth.google.redirect');
                Route::get('/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('api.oauth.google.callback');
            });
        }


        // -------------------------------------
        // Register
        // -------------------------------------
        if (config('authkit.features.registration', true)) {
            Route::post('/register', [RegisterController::class, 'register'])->name('api.register')->middleware('throttle:authkit_register');
        }


        // -------------------------------------
        // Forgot Password
        // -------------------------------------
        if (config('authkit.features.password_reset', true)) {
            Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('api.password.email')->middleware('throttle:authkit_forgot_password');
        }


        // -------------------------------------
        // 2FA Challenge
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa/challenge')->group(function () {
                Route::get('/', [TwoFactorChallengeController::class, 'show'])->name('api.two-factor.challenge')->middleware('throttle:authkit_pages');
                Route::post('/', [TwoFactorChallengeController::class, 'verify'])->name('api.two-factor.verify')->middleware('throttle:authkit_two_factor_verify');
            });
        }
    });




    // -------------------------------------
    // Password Reset
    // Guest + Authenticated
    // -------------------------------------
    if (config('authkit.features.password_reset', true)) {
        Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('api.password.update')->middleware('throttle:authkit_reset_password');
    }


    // -------------------------------------
    // Email Verification
    // -------------------------------------
    // تشخیص نمی‌داد SPA ندارن رو به‌عنوان درخواست Origin/Referer درخواست‌هایی که Sanctum چون
    // درنتیجه سشن رو لود نمی‌کرد، و سرور فکر میکرد کاربر لاگین نیست و ایمیل اونو تایید نمیکرد
    // استفاده کنیم auth:sanctum بجای web برای همین مجبور شدیم از میدلور
    Route::prefix('email')->middleware(['web', 'signed', 'throttle:authkit_verification_verify'])->group(function () {
        Route::get('/verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->name('api.verification.verify');
    });



    Route::middleware('auth:sanctum')->group(function () {

        // -------------------------------------
        // Email Verification
        // -------------------------------------
        Route::prefix('email')->group(function () {
            Route::get('/verify', [EmailController::class, 'showVerificationNotice'])->name('api.verification.notice')->middleware('throttle:authkit_pages');
            Route::post('/verification-notification', [EmailController::class, 'resendVerificationEmail'])->name('api.verification.send')->middleware('throttle:authkit_resend_verification_email');
        });


        // -------------------------------------
        // Logout
        // -------------------------------------
        Route::prefix('logout')->middleware('throttle:authkit_logout')->group(function () {
            Route::post('/', [LogoutController::class, 'logout'])->name('api.logout');
        });


        // -------------------------------------
        // Confirm Password
        // -------------------------------------
        Route::post('/confirm-password', [ConfirmPasswordController::class, 'store'])->name('api.password.confirm.verify')->middleware('throttle:authkit_confirm_password');


        // -------------------------------------
        // Send Password Reset Link (Authenticated)
        // -------------------------------------
        // برای وقتی که کاربر با گوگل ثبت نام کرده و رمز عبورش رو نمیدونه
        if (config('authkit.features.password_reset', true)) {
            Route::post('/password/send-reset-link', [ForgotPasswordController::class, 'sendResetLinkForAuthenticatedUser'])->name('api.password.send-reset-link')->middleware('throttle:authkit_forgot_password');
        }


        // -------------------------------------
        // 2FA
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa')->middleware('password.confirm')->group(function () {
                Route::get('/', [TwoFactorController::class, 'index'])->name('api.two-factor.index')->middleware('throttle:authkit_pages');
                Route::post('/enable', [TwoFactorController::class, 'enable'])->name('api.two-factor.enable')->middleware('throttle:authkit_two_factor_enable');
                Route::post('/disable', [TwoFactorController::class, 'disable'])->name('api.two-factor.disable')->middleware('throttle:authkit_two_factor_disable');
                Route::post('/regenerate', [TwoFactorController::class, 'regenerate'])->name('api.two-factor.recovery-code.regenerate')->middleware('throttle:authkit_two_factor_generate_recovery_code');
            });
        }
    });
});
