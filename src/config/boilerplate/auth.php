<?php

return [
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Sebastienheyd\Boilerplate\Models\User::class,
            'table' => 'users'
        ]
    ]
];