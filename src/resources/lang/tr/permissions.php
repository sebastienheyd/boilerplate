<?php

return [
    'categories' => [
        'default' => 'Yönetim paneli erişimi',
        'users'   => 'Kullanıcı yönetimi',
    ],
    'backend_access' => [
        'display_name' => 'Yönetim paneli erişimi',
        'description'  => 'Kullanıcı yönetim paneline erişebilir',
    ],
    'users_crud' => [
        'display_name' => 'Kullanıcı yönetimi',
        'description'  => 'Kullanıcı, kullanıcı ekleyebilir, silebilir ve düzenleyebilir',
    ],
    'roles_crud' => [
        'display_name' => 'Rol ve izin yönetimi',
        'description'  => 'Kullanıcı, bir rol için izinleri düzenleyebilir ve tanımlayabilir',
    ],
    'logs' => [
        'display_name' => 'Günlükleri görüntüleme',
        'description'  => 'Kullanıcı, uygulama günlüklerini görüntüleyebilir',
    ],
];
