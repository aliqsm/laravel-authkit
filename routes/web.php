<?php

use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\SocialiteController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\LoginController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\RegisterController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\LogoutController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ResetPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ForgotPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ConfirmPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Password\ChangePasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Email\EmailController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\ProfileController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\SecurityActivityController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\DashboardController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Sessions\SessionController;
use Aliqsm\LaravelAuthkit\Http\Controllers\TwoFactor\TwoFactorController;
use Aliqsm\LaravelAuthkit\Http\Controllers\TwoFactor\TwoFactorChallengeController;

use Illuminate\Support\Facades\Route;



Route::middleware('web')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {

        // -------------------------------------
        // Dashboard
        // -------------------------------------
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('throttle:authkit_pages');


        // -------------------------------------
        // Edit Profile
        // -------------------------------------
        if (config('authkit.features.update_profile_information', true)) {
            Route::prefix('profile')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('throttle:authkit_pages');
                Route::put('/', [ProfileController::class, 'update'])->name('profile.update')->middleware('throttle:authkit_update_profile');
            });
        }


        // -------------------------------------
        // Sessions
        // -------------------------------------
        Route::prefix('sessions')->middleware('throttle:authkit_logout')->group(function () {
            Route::get('/', [SessionController::class, 'index'])->name('sessions.index')->middleware('throttle:authkit_pages');
            Route::post('/terminate-others', [SessionController::class, 'destroyOthers'])->name('sessions.destroy')->middleware('throttle:authkit_terminate_sessions');;
        });




        // -------------------------------------
        // Security Activities
        // -------------------------------------
        if (config('authkit.features.security_activities', true)) {
            Route::get('/security-activities', [SecurityActivityController::class, 'index'])->name('security-activities.index')->middleware('throttle:authkit_pages');
        }


        // -------------------------------------
        // Change Password
        // -------------------------------------
        if (config('authkit.features.change_password', true)) {
            Route::prefix('change-password')->group(function () {
                Route::get('/', [ChangePasswordController::class, 'edit'])->name('password.edit')->middleware('throttle:authkit_pages');
                Route::post('/', [ChangePasswordController::class, 'update'])->name('password.change')->middleware('throttle:authkit_change_password');
            });
        }
    });




    Route::middleware('guest')->group(function () {

        // -------------------------------------
        // Login
        // -------------------------------------
        Route::prefix('login')->group(function () {
            Route::get('/', [LoginController::class, 'show'])->name('login.form')->middleware('throttle:authkit_pages');
            Route::post('/', [LoginController::class, 'login'])->name('login')->middleware('throttle:authkit_login');
        });


        // -------------------------------------
        // Login/Register With Oauth
        // -------------------------------------
        if (config('authkit.features.google_login', true)) {
            Route::prefix('oauth/google')->middleware('throttle:authkit_pages')->group(function () {
                Route::get('/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('oauth.google.redirect');
                Route::get('/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('oauth.google.callback');
            });
        }


        // -------------------------------------
        // Register
        // -------------------------------------
        if (config('authkit.features.registration', true)) {
            Route::prefix('register')->group(function () {
                Route::get('/', [RegisterController::class, 'show'])->name('register.form')->middleware('throttle:authkit_pages');
                Route::post('/', [RegisterController::class, 'register'])->name('register')->middleware('throttle:authkit_register');
            });
        }


        // -------------------------------------
        // Forgot Password
        // -------------------------------------
        if (config('authkit.features.password_reset', true)) {
            Route::prefix('forgot-password')->group(function () {
                Route::get('/', [ForgotPasswordController::class, 'show'])->name('password.request')->middleware('throttle:authkit_pages');
                Route::post('/', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email')->middleware('throttle:authkit_forgot_password');
            });
        }


        // -------------------------------------
        // 2FA
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa/challenge')->group(function () {
                Route::get('/', [TwoFactorChallengeController::class, 'show'])->name('two-factor.challenge')->middleware('throttle:authkit_pages');
                Route::post('/', [TwoFactorChallengeController::class, 'verify'])->name('two-factor.verify')->middleware('throttle:authkit_two_factor_verify');
            });
        }
    });



    // -------------------------------------
    // Password Reset (Guest + Authenticated)
    // -------------------------------------
    if (config('authkit.features.password_reset', true)) {
        Route::prefix('reset-password')->group(function () {
            Route::get('/{token}', [ResetPasswordController::class, 'show'])->name('password.reset')->middleware('throttle:authkit_pages');
            Route::post('/', [ResetPasswordController::class, 'resetPassword'])->name('password.update')->middleware('throttle:authkit_reset_password');
        });
    }



    Route::middleware('auth')->group(function () {

        // -------------------------------------
        // Email Verification
        // -------------------------------------
        Route::prefix('email')->group(function () {
            Route::get('/verify', [EmailController::class, 'showVerificationNotice'])->name('verification.notice')->middleware('throttle:authkit_pages');
            Route::post('/verification-notification', [EmailController::class, 'resendVerificationEmail'])->name('verification.send')->middleware('throttle:authkit_resend_verification_email');
            Route::get('/verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->name('verification.verify')->middleware(['signed', 'throttle:authkit_verification_verify']);
        });


        // -------------------------------------
        // Logout
        // -------------------------------------
        Route::prefix('logout')->middleware('throttle:authkit_logout')->group(function () {
            Route::post('/', [LogoutController::class, 'logout'])->name('logout');
        });


        // -------------------------------------
        // Confirm Password
        // -------------------------------------
        Route::prefix('confirm-password')->group(function () {
            Route::get('/', [ConfirmPasswordController::class, 'show'])->name('password.confirm')->middleware('throttle:authkit_pages');
            Route::post('/', [ConfirmPasswordController::class, 'store'])->name('password.confirm.verify')->middleware('throttle:authkit_confirm_password');
        });


        // -------------------------------------
        // Send Password Reset Link (Authenticated)
        // -------------------------------------
        // برای وقتی که کاربر با گوگل ثبت نام کرده و رمز عبورش رو نمیدونه
        if (config('authkit.features.password_reset', true)) {
            Route::post('/password/send-reset-link', [ForgotPasswordController::class, 'sendResetLinkForAuthenticatedUser'])->name('password.send-reset-link')->middleware('throttle:authkit_forgot_password');
        }


        // -------------------------------------
        // 2FA
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa')->middleware('password.confirm')->group(function () {
                Route::get('/', [TwoFactorController::class, 'index'])->name('two-factor.index')->middleware('throttle:authkit_pages');
                Route::post('/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable')->middleware('throttle:authkit_two_factor_enable');
                Route::post('/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable')->middleware('throttle:authkit_two_factor_disable');
                Route::post('/regenerate', [TwoFactorController::class, 'regenerate'])->name('two-factor.recovery-code.regenerate')->middleware('throttle:authkit_two_factor_generate_recovery_code');
            });
        }
    });
});
