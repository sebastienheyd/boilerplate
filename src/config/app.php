<?php

return [
    // Backend routes prefix. Ex: "admin" => "http://..../admin"
    'prefix'     => 'admin',

    // Backend domain if different as current domain. Ex: "admin.mydomain.tld"
    'domain'     => '',

    // Redirect to this route after login
    'redirectTo' => 'boilerplate.dashboard',

    // Backend locale
    'locale'     => config('app.locale'),
];
