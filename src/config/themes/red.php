<?php

/**
 * BG : blue, indigo, purple, pink, red, orange, yellow, green, teal, cyan, gray, gray-dark, black
 * Type : dark, light
 * Shadow : 0-4.
 */
return [
    'navbar'  => [
        'bg'     => 'red',
        'type'   => 'dark',
        'border' => true,
        'user'   => [
            'visible' => true,
            'shadow'  => 0,
        ],
    ],
    'sidebar' => [
        'type'    => 'dark',
        'shadow'  => 0,
        'border'  => true,
        'compact' => false,
        'links'   => [
            'bg'     => 'red',
            'shadow' => 0,
        ],
        'brand'   => [
            'bg'   => 'red',
            'logo' => [
                'bg'     => 'white',
                'icon'   => '<i class="fa fa-cubes"></i>',
                'text'   => '<strong>BO</strong>ilerplate',
                'shadow' => 2,
            ],
        ],
        'user'    => [
            'visible' => false,
            'shadow'  => 2,
        ],
    ],
    'footer'  => [
        'visible'    => true,
        'vendorname' => 'Boilerplate',
        'vendorlink' => '',
    ],
    'card'    => [
        'outline'       => true,
        'default_color' => 'red',
    ],
];
