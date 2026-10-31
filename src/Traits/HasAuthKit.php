<?php

namespace Aliqsm\LaravelAuthkit\Traits;

use Aliqsm\LaravelAuthkit\Notifications\ResetPasswordNotification;
use Aliqsm\LaravelAuthkit\Notifications\VerifyEmailNotification;

trait HasAuthKit
{
    // ------------------------------------
    // Initialize Auth Features
    // ------------------------------------
    public function initializeHasAuthKit(): void
    {
        $this->mergeFillable([
            'google_id',
            'email_verified_at',
            'two_factor_secret',
            'two_factor_recovery_codes',
        ]);

        $this->mergeHidden([
            'two_factor_secret',
            'two_factor_recovery_codes',
        ]);

        $this->mergeCasts([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'array',
        ]);
    }



    // ------------------------------------
    // Check Two-Factor Authentication Status
    // ------------------------------------
    public function hasEnabledTwoFactorAuthentication(): bool
    {
        return $this->two_factor_secret !== null;
    }


    // ------------------------------------
    // Forgot Password
    // ------------------------------------
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    // ------------------------------------
    // Verify Account
    // ------------------------------------
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }
}