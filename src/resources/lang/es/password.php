<?php

return [
    'requirements' => 'requisitos',
    'length'       => ':nb caracteres',
    'letter'       => 'Una carta',
    'capital'      => 'Una letra mayúscula',
    'number'       => 'Un número',
    'special'      => 'Un carácter especial',
    'rules'        => [
        'length'  => 'El :attribute debe tener al menos :min caracteres.',
        'letter'  => 'El :attribute debe contener al menos una letra.',
        'capital' => 'El :attribute debe contener al menos una letra mayúscula.',
        'number'  => 'El :attribute debe contener al menos un número.',
        'special'  => 'El :attribute debe contener al menos un carácter especial.',
    ],
];
