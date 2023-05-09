<?php

return [
    // Backend routes prefix. Ex: "admin" => "http://..../admin"
    'prefix'            => 'admin',

    // Backend domain if different as current domain. Ex: "admin.mydomain.tld"
    'domain'            => '',

    // Redirect to this route after login
    'redirectTo'        => 'boilerplate.dashboard',

    // Activating daily logs and showing log viewer
    'logs'              => true,

    // When set to true, allows admins to view the site as a user of their choice
    'allowImpersonate'  => false,

    // Allows to generate text with ChatGPT in TinyMCE
    'openai'   => [
        'key' => env('OPENAI_API_KEY'),
        'model' => 'gpt-3.5-turbo',
        'organization' => env('OPENAI_API_ORGANIZATION'),
    ],
];
