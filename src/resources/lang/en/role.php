<?php

return [
    'title'             => 'Role management',
    'role'              => 'Role',
    'parameters'        => 'Parameters',
    'label'             => 'Label',
    'description'       => 'Description',
    'permissions'       => 'Permissions',
    'savebutton'        => 'Save',
    'successadd'        => 'The role has been correctly added',
    'successmod'        => 'The role has been correctly modified',
    'admin'             => [
        'display_name'  => 'Admin',
        'description'   => 'Total access',
        'permissions'   => 'All permissions',
    ],
    'backend_user' => [
        'display_name'  => 'Backend user',
        'description'   => 'Users with backend access',
    ],
    'create' => [
        'title'         => 'Add a role',
    ],
    'edit' => [
        'title'         => 'Edit a role',
    ],
    'list' => [
        'title'         => 'Role list',
        'nbusers'       => 'Nb users',
        'confirmdelete' => 'Do you confirm that you want to delete this role ?',
        'deletesuccess' => 'The role has been correctly deleted',
    ],
];
