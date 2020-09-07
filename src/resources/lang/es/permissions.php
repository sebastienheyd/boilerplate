<?php

return [
    'categories' => [
        'default' => 'Panel de administración',
        'users'   => 'Gestión de usuarios',
    ],
    'backend_access' => [
        'display_name' => 'Acceso al panel de administración',
        'description'  => 'El usuario puede acceder al panel de administración',
    ],
    'users_crud' => [
        'display_name' => 'Gestión de usuarios',
        'description'  => 'El usuario puede crear, eliminar o modificar usuarios',
    ],
    'roles_crud' => [
        'display_name' => 'Gestión de roles y permisos',
        'description'  => 'El usuario puede editar y definir permisos para un rol',
    ],
    'logs' => [
        'display_name' => 'Ver logs',
        'description'  => 'El usuario puede ver los logs de la aplicación',
    ],
];
