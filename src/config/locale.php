<?php

return [
    'default' => config('app.locale'),
    'switch' => false,
    'allowed' => ['en', 'es', 'fa', 'fr', 'it', 'tr'],
    'languages' => [
        'en' => ['label' => 'English', 'datatable' => 'English'],
        'es' => ['label' => 'Español', 'datatable' => 'Spanish'],
        'fa' => ['label' => 'فارسی', 'datatable' => 'Persian'],
        'fr' => ['label' => 'Français', 'datatable' => 'French'],
        'it' => ['label' => 'Italiano', 'datatable' => 'Italian'],
        'tr' => ['label' => 'Türkçe', 'datatable' => 'Turkish'],
    ],
];
