<?php

return [
    'app.key' => 'base64:Wo2VgRys/LE/wWcQhIh3GrKb+3GbvE0TEq41WMm1UkQ=',
    'app.cipher' => 'AES-256-CBC',
    'app.locale' => 'en',
    'app.fallback_locale' => 'en',
    'auth.defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    'auth.guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ]
    ],
    'session.driver' => 'array',
    'queue.driver' => 'sync',
    'database.default' => 'testbench',
    'database.connections.testbench' => [
        'driver'   => 'sqlite',
        'database' => ':memory:',
        'prefix'   => '',
    ]
];