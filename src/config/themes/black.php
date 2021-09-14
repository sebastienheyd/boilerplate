<?php

/**
 * BG : blue, indigo, purple, pink, red, orange, yellow, green, teal, cyan, gray, gray-dark, black
 * Type : dark, light
 * Shadow : 0-4.
 */
return [
    'navbar'  => [
        'bg'     => 'gray-dark',
        'type'   => 'dark',
        'border' => true,
        'user'   => [
            'visible' => false,
            'shadow'  => 0,
        ],
    ],
    'sidebar' => [
        'type'    => 'dark',
        'shadow'  => 0,
        'border'  => false,
        'compact' => false,
        'links'   => [
            'bg'     => 'gray-dark',
            'shadow' => 0,
        ],
        'brand'   => [
            'bg'   => 'gray-dark',
            'logo' => [
                'bg'     => 'white',
                'icon'   => '<i class="fa fa-cubes"></i>',
                'text'   => '<strong>BO</strong>ilerplate',
                'shadow' => 2,
            ],
        ],
        'user'    => [
            'visible' => true,
            'shadow'  => 0,
        ],
    ],
    'footer'  => [
        'visible'    => true,
        'vendorname' => 'Boilerplate',
        'vendorlink' => '',
    ],
    'card'    => [
        'outline'       => true,
        'default_color' => 'info',
    ],
];
