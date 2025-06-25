<?php

return [
    // Backend routes prefix. Ex: "admin" => "http://..../admin"
    'prefix'            => 'admin',

    // Backend domain if different as current domain. Ex: "admin.mydomain.tld"
    'domain'            => '',

    // Backend application name, visible as meta title suffix
    'name'              => env('APP_NAME', 'Boilerplate'),

    // Redirect to this route after login
    'redirectTo'        => 'boilerplate.dashboard',

    // Activating daily logs and showing log viewer
    'logs'              => true,

    // When set to true, allows admins to view the site as a user of their choice
    'allowImpersonate'  => false,

    // If true, the session will be kept alive and the user must log out
    'keepalive'         => true,

    // Allows to generate text with ChatGPT in TinyMCE
    'openai'   => [
        'key'          => env('OPENAI_API_KEY'),
        'model'        => 'gpt-4o-mini',
        'organization' => env('OPENAI_API_ORGANIZATION'),
    ],

    // Progressive Web App configuration
    'pwa' => [
        'enabled'          => true,
        'name'             => env('APP_NAME', 'Boilerplate'),
        'short_name'       => env('APP_NAME', 'Boilerplate'),
        'description'      => '',
        'theme_color'      => '#454d55',
        'background_color' => '#454d55',
        'display'          => 'standalone',
        'orientation'      => 'portrait-primary',
        'apple_touch_icon' => 'assets/vendor/boilerplate/favicon.svg',
        'icons'            => [
            [
                'src'   => 'assets/vendor/boilerplate/favicon.svg',
                'sizes' => 'any',
                'type'  => 'image/svg+xml',
            ],
            // ... additional icons here, see documentation
        ],
    ],
];
