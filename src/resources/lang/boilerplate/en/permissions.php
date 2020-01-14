<?php

return [
    'categories' => [
        'default' => 'Back Office',
        'users'   => 'Users',
    ],
    'backend_access' => [
        'display_name' => 'Access to the back office',
        'description'  => 'User can access to the administration panel',
    ],
    'users_crud' => [
        'display_name' => 'User management',
        'description'  => 'User can create, delete or modify the users',
    ],
    'roles_crud' => [
        'display_name' => 'Role and permissions management',
        'description'  => 'User can edit and define permissions for a role',
    ],
    'logs' => [
        'display_name' => 'Viewing logs',
        'description'  => 'User can view application logs',
    ],
];
