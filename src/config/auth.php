<?php

return [
    'register' => true, // Allow to register new users on backend login page
    'register_role' => 'backend_user', // Given role to new users (except the first one who is admin)
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Sebastienheyd\Boilerplate\Models\User::class,
            'table' => 'users'
        ]
    ]
];