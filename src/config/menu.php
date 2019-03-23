<?php

return [
    'dashboard' => \Sebastienheyd\Boilerplate\Controllers\DashboardController::class,
    'providers' => [
        \Sebastienheyd\Boilerplate\Menu\Users::class,
        \Sebastienheyd\Boilerplate\Menu\Logs::class,
    ],
];
