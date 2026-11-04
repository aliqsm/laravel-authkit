<?php

return [

    // -------------------------------------
    // Font
    // -------------------------------------
    'font' => [
        'family' => 'ExampleFont',
        'fallback' => 'Tahoma, Arial, sans-serif',
        'weights' => [
            400 => 'fonts/example-font/ExampleFont-Regular.woff2',
            500 => 'fonts/example-font/ExampleFont-Medium.woff2',
            700 => 'fonts/example-font/ExampleFont-Bold.woff2',
        ],
    ],



    // -------------------------------------
    // Auth Mode (web or api)
    // -------------------------------------
    'app_mode' => 'web',

    // Set in API mode
'password_reset_url' => env('AUTHKIT_PASSWORD_RESET_URL'),
'email_verification_redirect_url' => env('AUTHKIT_EMAIL_VERIFICATION_REDIRECT_URL'),



    // -------------------------------------
    // Features
    // -------------------------------------
    'features' => [
        'registration' => true,
        'google_login' => true,
        'two_factor_authentication' => true,
        'update_profile_information' => true,
        'change_password' => true,
        'security_activities' => true,
        'password_reset' => true,
    ],



    // -------------------------------------
    // 2FA Authentication
    // -------------------------------------
    'two_factor' => [
        'challenge_expire_minutes' => (int) env('TWO_FACTOR_CHALLENGE_EXPIRE_MINUTES', 10),
        'setup_expire_minutes' => (int) env('TWO_FACTOR_SETUP_EXPIRE_MINUTES', 10),
        'recovery_code_length' => (int) env('TWO_FACTOR_RECOVERY_CODE_LENGTH', 12),
        'recovery_codes_count' => (int) env('TWO_FACTOR_RECOVERY_CODES_COUNT', 6),
    ],



    // -------------------------------------
    // Rate Limits
    // -------------------------------------
    'rate_limits' => [

        'authkit_pages' => [
            'ip' => ['max_attempts' => 120, 'decay_minutes' => 30],
        ],

        'authkit_login' => [
            'ip' => ['max_attempts' => 60, 'decay_minutes' => 30],
            'email' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_logout' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 15, 'decay_minutes' => 30],
        ],

        'authkit_register' => [
            'ip' => ['max_attempts' => 20, 'decay_minutes' => 30],
            'email' => ['max_attempts' => 5, 'decay_minutes' => 30],
        ],

        'authkit_verification_verify' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_resend_verification_email' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 1, 'decay_minutes' => 2],
        ],

        'authkit_forgot_password' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'email' => ['max_attempts' => 5, 'decay_minutes' => 30],
        ],

        'authkit_reset_password' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'email' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_password_confirm' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_two_factor_enable' => [
            'ip' => ['max_attempts' => 15, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_two_factor_disable' => [
            'ip' => ['max_attempts' => 15, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_two_factor_generate_recovery_code' => [
            'ip' => ['max_attempts' => 15, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 5, 'decay_minutes' => 30],
        ],

        'authkit_two_factor_verify' => [
            'ip' => ['max_attempts' => 15, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_update_profile' => [
            'ip' => ['max_attempts' => 30, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 10, 'decay_minutes' => 30],
        ],

        'authkit_change_password' => [
            'ip' => ['max_attempts' => 20, 'decay_minutes' => 30],
            'user' => ['max_attempts' => 5, 'decay_minutes' => 30],
        ],
    ],
];
