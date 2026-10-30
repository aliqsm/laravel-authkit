<?php

return [

    // -------------------------------------
    // Auth Mode (web or api)
    // -------------------------------------
    'app_mode' => 'web',
    
    'frontend_url' => '',


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
];
