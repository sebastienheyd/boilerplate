<?php

/**
 * Style : classic, modern
 * Palette (modern style only) : orange, blue, green, red, purple, teal
 * BG : blue, indigo, purple, pink, red, orange, yellow, green, teal, cyan, gray, gray-dark, black
 * Type : dark, light
 * Shadow : 0-4.
 */
return [
    'style'   => 'modern',
    'palette' => env('BOILERPLATE_PALETTE', 'orange'),
    'navbar'  => [
        'bg'     => 'white',
        'type'   => 'light',
        'border' => true,
        'user'   => [
            'visible' => false,
            'shadow'  => 0,
        ],
    ],
    'sidebar' => [
        'type'    => 'light',
        'shadow'  => 0,
        'border'  => false,
        'compact' => false,
        'links'   => [
            'bg'     => 'orange',
            'shadow' => 0,
        ],
        'brand'   => [
            'bg'   => '',
            'logo' => [
                'bg'     => '',
                'icon'   => '<i class="fa fa-cubes"></i>',
                'text'   => '<strong>BO</strong>ilerplate',
                'shadow' => 0,
            ],
        ],
        'user'    => [
            'visible' => true,
            'shadow'  => 0,
        ],
    ],
    'footer'  => [
        'visible'    => false,
        'vendorname' => 'Boilerplate',
        'vendorlink' => '',
    ],
    'card'    => [
        'outline'       => true,
        'default_color' => 'info',
    ],
];
