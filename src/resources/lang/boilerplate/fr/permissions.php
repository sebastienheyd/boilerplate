<?php

return [
    'categories' => [
        'default' => 'Back-Office',
        'users'   => 'Utilisateurs',
    ],
    'backend_access' => [
        'display_name' => 'Accès au Back-Office',
        'description'  => "L'utilisateur peut accéder à l'administration",
    ],
    'users_crud' => [
        'display_name' => 'Gestion des utilisateurs',
        'description'  => 'Permet de créer, de supprimer et de modifier les utilisateurs',
    ],
    'roles_crud' => [
        'display_name' => 'Gestion des rôles et permissions',
        'description'  => "Permet d'éditer et de définir les permissions pour un rôle",
    ],
    'logs' => [
        'display_name' => 'Visualisation des journaux',
        'description'  => "L'utilisateur peut consulter les journaux de l'application",
    ],
];
