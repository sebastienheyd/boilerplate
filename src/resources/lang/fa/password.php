<?php

return [
    'requirements' => 'requirements',
    'length'       => ':nb characters',
    'letter'       => 'One letter',
    'capital'      => 'One capital letter',
    'number'       => 'One number',
    'special'      => 'One special character',
    'rules'        => [
        'length'  => 'The :attribute must be at least :min characters.',
        'letter'  => 'The :attribute must contain at least one letter.',
        'capital' => 'The :attribute must contain at least one capital letter.',
        'number'  => 'The :attribute must contain at least one number.',
        'special'  => 'The :attribute must contain at least one special character.',
    ],
];
