
<?php

use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\SocialiteController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\LoginController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\RegisterController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\ResetPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\EmailController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\ForgotPasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\LogoutController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\PasswordController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Auth\Web\TwoFactorController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web\DashboardController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web\ProfileController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web\SecurityActivityController;
use Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web\SessionController;
use Illuminate\Support\Facades\Route;



Route::middleware('web')->group(function () {
    Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {

        // -------------------------------------
        // Dashboard
        // -------------------------------------
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('throttle:my_auth_pages');


        // -------------------------------------
        // Edit Profile
        // -------------------------------------
        if (config('authkit.features.update_profile_information', true)) {
            Route::prefix('/profile')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('throttle:my_auth_pages');
                Route::put('/', [ProfileController::class, 'update'])->name('profile.update')->middleware('throttle:update_profile');
            });
        }


        // -------------------------------------
        // Sessions
        // -------------------------------------
        Route::get('/sessions', [SessionController::class, 'index'])->name('dashboard.sessions.index')->middleware('throttle:my_auth_pages');


        // -------------------------------------
        // Security Activities
        // -------------------------------------
        if (config('authkit.features.security_activities', true)) {
            Route::get('/security-activities', [SecurityActivityController::class, 'index'])->name('dashboard.security-activities.index')->middleware('throttle:my_auth_pages');
        }


        // -------------------------------------
        // Change Password
        // -------------------------------------
        if (config('authkit.features.change_password', true)) {
            Route::prefix('change-password')->middleware('password.confirm')->group(function () {
                Route::get('/', [PasswordController::class, 'edit'])->name('password.edit')->middleware('throttle:my_auth_pages');
                Route::post('/', [PasswordController::class, 'update'])->name('password.change')->middleware('throttle:change_password');
            });
        }
    });




    Route::middleware('guest')->group(function () {

        // -------------------------------------
        // Login
        // -------------------------------------
        Route::prefix('login')->group(function () {
            Route::get('/', [LoginController::class, 'show'])->name('login.form')->middleware('throttle:my_auth_pages');
            Route::post('/', [LoginController::class, 'login'])->name('login')->middleware('throttle:login');
        });


        // -------------------------------------
        // Login/Register With Oauth
        // -------------------------------------
        if (config('authkit.features.google_login', true)) {
            Route::prefix('oauth/google')->middleware('throttle:my_auth_pages')->group(function () {
                Route::get('/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('oauth.google.redirect');
                Route::get('/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('oauth.google.callback');
            });
        }


        // -------------------------------------
        // Register
        // -------------------------------------
        if (config('authkit.features.registration', true)) {
            Route::prefix('register')->group(function () {
                Route::get('/', [RegisterController::class, 'show'])->name('register.form')->middleware('throttle:my_auth_pages');
                Route::post('/', [RegisterController::class, 'register'])->name('register')->middleware('throttle:register');
            });
        }


        // -------------------------------------
        // Forgot Password
        // -------------------------------------
        if (config('authkit.features.password_reset', true)) {
            Route::prefix('forgot-password')->group(function () {
                Route::get('/', [ForgotPasswordController::class, 'show'])->name('password.request')->middleware('throttle:my_auth_pages');
                Route::post('/', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email')->middleware('throttle:forgot_password');
            });
        }


        // -------------------------------------
        // 2FA
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa/challenge')->group(function () {
                Route::get('/', [TwoFactorController::class, 'show'])->name('two-factor.challenge')->middleware('throttle:my_auth_pages');
                Route::post('/', [TwoFactorController::class, 'verify'])->name('two-factor.verify')->middleware('throttle:two_factor_verify');
            });
        }
    });


    
    // -------------------------------------
    // Password Reset (Guest + Authenticated)
    // -------------------------------------
    if (config('authkit.features.password_reset', true)) {
        Route::prefix('reset-password')->group(function () {
            Route::get('/{token}', [ResetPasswordController::class, 'show'])->name('password.reset')->middleware('throttle:my_auth_pages');
            Route::post('/', [ResetPasswordController::class, 'resetPassword'])->name('password.update')->middleware('throttle:reset_password');
        });
    }



    Route::middleware('auth')->group(function () {

        // -------------------------------------
        // Email Verification
        // -------------------------------------
        Route::prefix('email')->group(function () {
            Route::get('/verify', [EmailController::class, 'showVerificationNotice'])->name('verification.notice')->middleware('throttle:my_auth_pages');
            Route::post('/verification-notification', [EmailController::class, 'resendVerificationEmail'])->name('verification.send')->middleware('throttle:resend_verification_email');
            Route::get('/verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->name('verification.verify')->middleware(['signed', 'throttle:verification_verify']);;
        });


        // -------------------------------------
        // Logout
        // -------------------------------------
        Route::prefix('logout')->middleware('throttle:logout')->group(function () {
            Route::post('/', [LogoutController::class, 'logout'])->name('logout');
            Route::post('/logout-other-devices', [LogoutController::class, 'logoutOtherDevices'])->name('sessions.destroy');
        });


        // -------------------------------------
        // Confirm Password
        // -------------------------------------
        Route::prefix('confirm-password')->group(function () {
            Route::get('/', [PasswordController::class, 'show'])->name('password.confirm')->middleware('throttle:my_auth_pages');
            Route::post('/', [PasswordController::class, 'store'])->name('password.confirm.verify')->middleware('throttle:password_confirm');
        });


        // -------------------------------------
        // Send Password Reset Link (Authenticated)
        // -------------------------------------
        // برای وقتی که کاربر با گوگل ثبت نام کرده و رمز عبورش رو نمیدونه
        if (config('authkit.features.password_reset', true)) {
            Route::post('/password/send-reset-link', [ForgotPasswordController::class, 'sendResetLinkForAuthenticatedUser'])->name('password.send-reset-link')->middleware('throttle:forgot_password');
        }


        // -------------------------------------
        // 2FA
        // -------------------------------------
        if (config('authkit.features.two_factor_authentication', true)) {
            Route::prefix('2fa')->middleware('password.confirm')->group(function () {
                Route::get('/', [TwoFactorController::class, 'index'])->name('two-factor.index')->middleware('throttle:my_auth_pages');
                Route::post('/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable')->middleware('throttle:two_factor_enable');
                Route::post('/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable')->middleware('throttle:two_factor_disable');
                Route::post('/regenerate', [TwoFactorController::class, 'regenerate'])->name('two-factor.recovery-code.regenerate')->middleware('throttle:two_factor_generate_recovery_code');
            });
        }
    });
});
