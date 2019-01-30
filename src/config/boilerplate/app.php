<?php

return [
    'vendorname' => 'Boilerplate',           // Vendor name
    'vendorlink' => '',                      // Vendor URL
    'logo-lg'    => '<b>BO</b>ilerplate',    // Logo displayed on large screen (title on the top of the main menu)
    'logo-mini'  => 'BO',                    // Logo displayed on small screen
    'prefix'     => 'admin',                 // Backend routes prefix. Ex: "admin" => "http://..../admin"
    'domain'     => '',                      // Backend domain. Ex: "http://admin.mydomain.tld"
    'redirectTo' => 'boilerplate.dashboard', // Redirection to route after backend login
    'locale'     => config('app.locale'),    // Backend locale
    'skin'       => 'blue',                  // AdminLTE skin (blue, yellow, green, purple, red, black, *-light)
];