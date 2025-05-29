<?php

// Selected theme
$selectedTheme = env('BOILERPLATE_THEME', 'default');

// Check if theme exists
$themePath = __DIR__.'/themes/'.$selectedTheme.'.php';
if (! file_exists($themePath)) {
    $selectedTheme = 'default';
    $themePath = __DIR__.'/themes/default.php';
}

$theme = include $themePath;

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left'  => [],
        'right' => [],
    ],
    'favicon'    => null,       // Favicon url
    'fullscreen' => false,      // Fullscreen switch
    'darkmode'   => true,       // Dark mode switch
    'minify'     => true,       // Minify inline JS / CSS when using boilerplate::minify component
];

return $theme;
