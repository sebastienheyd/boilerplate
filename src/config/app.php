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

    // AI provider for text generation in TinyMCE (openai, anthropic, ollama, or custom slug)
    'ai' => [
        'default' => env('AI_PROVIDER', 'openai'),

        'providers' => [
            'openai' => [
                'key'          => env('OPENAI_API_KEY'),
                'model'        => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'organization' => env('OPENAI_API_ORGANIZATION'),
            ],
            'anthropic' => [
                'key'   => env('ANTHROPIC_API_KEY'),
                'model' => env('ANTHROPIC_MODEL', 'claude-3-5-haiku-20241022'),
            ],
            'ollama' => [
                'endpoint' => env('OLLAMA_ENDPOINT', 'http://localhost:11434'),
                'model'    => env('OLLAMA_MODEL', ''),
            ],
        ],
    ],

    // Kept for backward compatibility — OpenAiProvider falls back to this if ai.providers.openai.key is empty
    'openai' => [
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
