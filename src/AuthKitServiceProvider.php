<?php

namespace Aliqsm\LaravelAuthkit;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;

class AuthKitServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/authkit.php', 'authkit');
    }



    public function boot(): void
    {
        // -------------------------------------
        // Config
        // -------------------------------------
        $this->publishes([
            __DIR__ . '/../config/authkit.php' => config_path('authkit.php'),
        ], 'authkit-config');


        // -------------------------------------
        // Source Assets
        // -------------------------------------
        $this->publishes([
            __DIR__ . '/../resources/css' => resource_path('vendor/authkit/css'),
            __DIR__ . '/../resources/js' => resource_path('vendor/authkit/js'),
        ], 'authkit-assets');


        // -------------------------------------
        // Views
        // -------------------------------------
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'authkit');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/authkit'),
        ], 'authkit-views');


        // -------------------------------------
        // Component
        // -------------------------------------
        Blade::anonymousComponentPath(
            __DIR__ . '/../resources/views/components',
            'authkit'
        );

        // -------------------------------------
        // Migrations
        // -------------------------------------
        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'authkit-migrations');


        // -------------------------------------
        // Routes
        // -------------------------------------
        if (config('authkit.app_mode', 'web') === 'web') {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }

        if (config('authkit.app_mode', 'web') === 'api') {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        }



        // -----------------------------------------------------
        // Authentication Rate Limiters
        // -----------------------------------------------------
        RateLimiter::for('my_auth_pages', function (Request $request) {
            $ipKey = 'my_auth_pages:ip:' . $request->ip();

            return [
                Limit::perMinutes(30, 120)->by($ipKey),
            ];
        });

        RateLimiter::for('login', function (Request $request) {
            $ipKey = 'login:ip:' . $request->ip();
            $emailKey = 'login:email:' . strtolower(trim((string) $request->input('email', '')));

            return [
                Limit::perMinutes(30, 60)->by($ipKey),
                Limit::perMinutes(30, 10)->by($emailKey),
            ];
        });

        RateLimiter::for('logout', function (Request $request) {
            $ipKey = 'logout:ip:' . $request->ip();
            $userKey = 'logout:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(30, 15)->by($userKey),
            ];
        });

        RateLimiter::for('register', function (Request $request) {
            $ipKey = 'register:ip:' . $request->ip();
            $emailKey = 'register:email:' . strtolower(trim((string) $request->input('email', '')));

            return [
                Limit::perMinutes(30, 20)->by($ipKey),
                Limit::perMinutes(30, 5)->by($emailKey),
            ];
        });

        RateLimiter::for('verification_verify', function (Request $request) {
            $ipKey = 'verification:verify:ip:' . $request->ip();
            $userKey = 'verification:verify:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(30, 10)->by($userKey),
            ];
        });

        RateLimiter::for('resend_verification_email', function (Request $request) {
            $ipKey = 'verification:resend:ip:' . $request->ip();
            $userKey = 'verification:resend:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(2, 1)->by($userKey),
            ];
        });

        RateLimiter::for('forgot_password', function (Request $request) {
            $ipKey = 'forgot_password:ip:' . $request->ip();
            $emailKey = 'forgot_password:email:' . strtolower(trim((string) $request->input('email', '')));

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(30, 5)->by($emailKey),
            ];
        });

        RateLimiter::for('reset_password', function (Request $request) {
            $ipKey = 'reset_password:ip:' . $request->ip();
            $emailKey = 'reset_password:email:' . strtolower(trim((string) $request->input('email', '')));

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(30, 10)->by($emailKey),
            ];
        });

        RateLimiter::for('password_confirm', function (Request $request) {
            $ipKey = 'password_confirm:ip:' . $request->ip();
            $userKey = 'password_confirm:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(30, 10)->by($userKey),
            ];
        });


        // -----------------------------------------------------
        // Two-Factor Authentication (2FA)
        // -----------------------------------------------------
        RateLimiter::for('two_factor_enable', function (Request $request) {
            $ipKey = 'two_factor_enable_disable:ip:' . $request->ip();
            $userKey = 'two_factor_enable_disable:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 15)->by($ipKey),
                Limit::perMinutes(30, 10)->by($userKey),
            ];
        });

        RateLimiter::for('two_factor_disable', function (Request $request) {
            $ipKey = 'two_factor_enable_disable:ip:' . $request->ip();
            $userKey = 'two_factor_enable_disable:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 15)->by($ipKey),
                Limit::perMinutes(30, 10)->by($userKey),
            ];
        });

        RateLimiter::for('two_factor_generate_recovery_code', function (Request $request) {
            $ipKey = 'two_factor_generate_recovery_code:ip:' . $request->ip();
            $userKey = 'two_factor_generate_recovery_code:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 15)->by($ipKey),
                Limit::perMinutes(30, 5)->by($userKey),
            ];
        });

        RateLimiter::for('two_factor_verify', function (Request $request) {
            $ipKey = 'two_factor_verify:ip:' . $request->ip();
            $userId = $request->session()->get('2fa:user_id');
            $userKey = 'two_factor_verify:user:' . ($userId ?? $request->ip());

            return [
                Limit::perMinutes(30, 15)->by($ipKey),
                Limit::perMinutes(30, 10)->by($userKey),
            ];
        });


        // -----------------------------------------------------
        // in Dashboard
        // -----------------------------------------------------
        RateLimiter::for('update_profile', function (Request $request) {
            $ipKey = 'update_profile:ip:' . $request->ip();
            $userKey = 'update_profile:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 30)->by($ipKey),
                Limit::perMinutes(30, 10)->by($userKey),
            ];
        });

        RateLimiter::for('change_password', function (Request $request) {
            $ipKey = 'change_password:ip:' . $request->ip();
            $userKey = 'change_password:user:' . $request->user()->id;

            return [
                Limit::perMinutes(30, 20)->by($ipKey),
                Limit::perMinutes(30, 5)->by($userKey),
            ];
        });
    }
}
