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

        $this->publishes([
            __DIR__ . '/../public/build' => public_path('vendor/authkit/build'),
        ], 'authkit-build');


        // -------------------------------------
        // Views & Components
        // -------------------------------------
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'authkit');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/authkit'),
        ], 'authkit-views');

        Blade::anonymousComponentPath(
            __DIR__ . '/../resources/views/components',
            'authkit'
        );


        // -------------------------------------
        // Migrations
        // -------------------------------------
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'authkit-migrations');


        // -------------------------------------
        // Routes
        // -------------------------------------
        $appMode = config('authkit.app_mode', 'web');

        if ($appMode === 'web') {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        } elseif ($appMode === 'api') {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        }




        
        // -----------------------------------------------------
        // Authentication Rate Limiters
        // -----------------------------------------------------

        RateLimiter::for('authkit_pages', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_pages.ip'),
                    'authkit_pages:ip:' . $request->ip()
                ),
            ];
        });

        RateLimiter::for('authkit_login', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_login.ip'),
                    'authkit_login:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_login.email'),
                    'authkit_login:email:' . strtolower(trim((string) $request->input('email', '')))
                ),
            ];
        });

        RateLimiter::for('authkit_logout', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_logout.ip'),
                    'authkit_logout:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_logout.user'),
                    'authkit_logout:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_register', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_register.ip'),
                    'authkit_register:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_register.email'),
                    'authkit_register:email:' . strtolower(trim((string) $request->input('email', '')))
                ),
            ];
        });

        RateLimiter::for('authkit_verification_verify', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_verification_verify.ip'),
                    'authkit_verification_verify:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_verification_verify.user'),
                    'authkit_verification_verify:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_resend_verification_email', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_resend_verification_email.ip'),
                    'authkit_resend_verification_email:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_resend_verification_email.user'),
                    'authkit_resend_verification_email:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_forgot_password', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_forgot_password.ip'),
                    'authkit_forgot_password:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_forgot_password.email'),
                    'authkit_forgot_password:email:' . strtolower(trim((string) $request->input('email', '')))
                ),
            ];
        });

        RateLimiter::for('authkit_reset_password', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_reset_password.ip'),
                    'authkit_reset_password:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_reset_password.email'),
                    'authkit_reset_password:email:' . strtolower(trim((string) $request->input('email', '')))
                ),
            ];
        });

        RateLimiter::for('authkit_confirm_password', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_confirm_password.ip'),
                    'authkit_confirm_password:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_confirm_password.user'),
                    'authkit_confirm_password:user:' . $request->user()->id
                ),
            ];
        });


        // -----------------------------------------------------
        // Two-Factor Authentication (2FA)
        // -----------------------------------------------------

        RateLimiter::for('authkit_two_factor_enable', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_enable.ip'),
                    'authkit_two_factor_enable:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_enable.user'),
                    'authkit_two_factor_enable:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_two_factor_disable', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_disable.ip'),
                    'authkit_two_factor_disable:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_disable.user'),
                    'authkit_two_factor_disable:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_two_factor_generate_recovery_code', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_generate_recovery_code.ip'),
                    'authkit_two_factor_generate_recovery_code:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_generate_recovery_code.user'),
                    'authkit_two_factor_generate_recovery_code:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_two_factor_verify', function (Request $request) {
            $userId = $request->session()->get('2fa:user_id');

            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_verify.ip'),
                    'authkit_two_factor_verify:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_two_factor_verify.user'),
                    'authkit_two_factor_verify:user:' . ($userId ?? $request->ip())
                ),
            ];
        });


        // -----------------------------------------------------
        // Dashboard
        // -----------------------------------------------------

        RateLimiter::for('authkit_update_profile', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_update_profile.ip'),
                    'authkit_update_profile:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_update_profile.user'),
                    'authkit_update_profile:user:' . $request->user()->id
                ),
            ];
        });

        RateLimiter::for('authkit_change_password', function (Request $request) {
            return [
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_change_password.ip'),
                    'authkit_change_password:ip:' . $request->ip()
                ),
                $this->makeLimit(
                    config('authkit.rate_limits.authkit_change_password.user'),
                    'authkit_change_password:user:' . $request->user()->id
                ),
            ];
        });
    }


    // -------------------------------------
    // Rate Limit Helper
    // -------------------------------------
    private function makeLimit(array $settings, string $key): Limit
    {
        return Limit::perMinutes(
            $settings['decay_minutes'],
            $settings['max_attempts']
        )->by($key);
    }
}