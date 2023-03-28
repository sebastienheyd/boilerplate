<?php

return [
    'app.name' => 'Boilerplate Test',
    'app.key' => 'base64:Wo2VgRys/LE/wWcQhIh3GrKb+3GbvE0TEq41WMm1UkQ=',
    'app.cipher' => 'AES-256-CBC',
    'app.locale' => 'en',
    'app.url' => 'http://localhost',
    'app.fallback_locale' => 'en',
    'boilerplate.app.locale' => 'en',
    'boilerplate.locale.switch' => true,
    'boilerplate.locale.allowed' => ['fr'],
    'boilerplate.app.allowImpersonate' => true,
    'auth.defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    'auth.guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],
    'session.driver' => 'array',
    'mail.default' => 'array',
    'mailers.array.transport' => 'array',
    'queue.driver' => 'sync',
    'queue.connections.sync' => [
        'driver' => 'sync',
    ],
    'database.default' => 'testbench',
    'database.connections.testbench' => [
        'driver'   => 'sqlite',
        'database' => ':memory:',
        'prefix'   => '',
        'foreign_key_constraints' => false,
    ],
];
