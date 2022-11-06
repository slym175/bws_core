<?php

return [
    'dashboard' => [
        'prefix' => 'admin',
        'action' => [\Bws\Core\Http\Controllers\AdminDashboardController::class, 'getDashboard']
    ],
    'can_create_account' => true,
    'supported_languages' => [
        'en',
        'vi'
    ],
    'languages' => [
        'en' => [
            'display' => 'English',
            'flag-icon' => 'us'
        ],
        'vi' => [
            'display' => 'Việt Nam',
            'flag-icon' => 'vi'
        ]
    ],
    'localization_enabled' => env('LOCALIZATION_ENABLED', true),
    'plugins' => [
        'bws/media', 'bws/shortcode', 'bws/assets'
    ],
    'super_role' => [
        'name' => 'super-admin',
        'display_name' => 'Super admin',
        'description' => 'Super admin role',
    ]
];
