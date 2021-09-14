<?php

$theme = include __DIR__.'/themes/default.php';

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left' => [],
        'right' => [],
    ],
    'favicon' => null,          // Favicon url
    'fullscreen' => true,       // Fullscreen switch
    'darkmode' => true,         // Dark mode switch
];

return $theme;
