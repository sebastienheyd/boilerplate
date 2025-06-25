# app.php

The `config/boilerplate/app.php` file allows to define the general parameters of the application.

---

```php
<?php

return [
    // Backend routes prefix. Ex: "admin" => "http://..../admin"
    'prefix'            => 'admin',

    // Backend domain if different as current domain. Ex: "admin.mydomain.tld"
    'domain'            => '',

    // Backend application name, visible as meta title suffix
    'name'              => env('APP_NAME', 'Boilerplate'),

    // Redirect to this route after login
    'redirectTo'        => 'boilerplate.dashboard',

    // Activating daily logs and showing log viewer
    'logs'              => true,

    // When set to true, allows admins to view the site as a user of their choice
    'allowImpersonate'  => false,

    // If true, the session will be kept alive and the user must log out
    'keepalive'         => true,

    // Allows to generate text with ChatGPT in TinyMCE
    'openai'   => [
        'key'          => env('OPENAI_API_KEY'),
        'model'        => 'gpt-4o-mini',
        'organization' => env('OPENAI_API_ORGANIZATION'),
    ],

    // Progressive Web App configuration
    'pwa' => [
        'enabled'          => true,
        'name'             => env('APP_NAME', 'Boilerplate'),
        'short_name'       => env('APP_NAME', 'Boilerplate'),
        'description'      => '',
        'theme_color'      => '#454d55',
        'background_color' => '#454d55',
        'display'          => 'standalone',
        'orientation'      => 'portrait-primary',
        'apple_touch_icon' => 'assets/vendor/boilerplate/favicon.svg',
        'icons'            => [
            [
                'src'   => 'assets/vendor/boilerplate/favicon.svg',
                'sizes' => 'any',
                'type'  => 'image/svg+xml',
            ],
            // ... additional icons here, see documentation
        ],
    ],
];

```
---

## prefix

The `prefix` parameter will define the prefix of the application urls. This allows you to have no conflict if you need
to have frontend urls separated.

The default value is `"admin"` &rarr; http://mywebsite.tld/**admin**

> If your application does not have a front-end, you can define an empty string as `prefix`, this will then display the
login form at the root of your website.

See [Laravel documentation](https://laravel.com/docs/master/routing#route-group-prefixes) for route prefixes.

---

## domain

The `domain` parameter makes it possible to define a different and exclusive domain for the application.

The default value is `""`

> If the parameter is empty, all domains will allow access to the backend, otherwise only the specified domain will allow
access.

See [Laravel documentation](https://laravel.com/docs/master/routing#route-group-sub-domain-routing) for sub-domain
routing.

---

## redirectTo

The `redirectTo` parameter allows you to define the route to which you will be redirected after connecting.

The default value is `"boilerplate.dashboard"`

---

## logs

The `logs` parameter allows you to define if you want to add `daily` to the logging stack and enable the log viewer.

<blockquote>
Log viewer is only visible by administrators by default.
</blockquote>

---

## allowImpersonate

When `allowImpersonate` is set to true, admins are allowed to view the site as the user of their choice by using a
switch in the navbar.

> You can't switch to an admin user

---

## keepalive

Allows enabling or disabling session keep alive. If the value is set to `true`, the session will be maintained until the user logs out.

Conversely, if the value is set to `false`, the user will be logged out when the session expires.

---

## name

The `name` parameter allows you to define the backend application name, which is visible as meta title suffix.

The default value is `env('APP_NAME', 'Boilerplate')`

---

## openai

Allows setting variables for using ChatGPT in TinyMCE

### key

The OpenAI API key for authenticating with the ChatGPT service.

### model

The OpenAI model to use. The default value is `'gpt-3.5-turbo'`

### organization

The OpenAI organization ID if you belong to multiple organizations.

---

## pwa

Progressive Web App configuration that allows the backend to be installed as a PWA.

### enabled

Enable or disable PWA functionality. The default value is `true`

### name

The application name shown in the PWA installation dialog. The default value is `env('APP_NAME', 'Boilerplate')`

### short_name

The short name used when there is insufficient space to display the full name. The default value is `env('APP_NAME', 'Boilerplate')`

### description

A description of the application. The default value is an empty string.

### theme_color

The theme color for the PWA. The default value is `'#454d55'`

### background_color

The background color for the PWA splash screen. The default value is `'#454d55'`

### display

The display mode for the PWA. The default value is `'standalone'`

### orientation

The preferred orientation for the PWA. The default value is `'portrait-primary'`

### apple_touch_icon

The icon used for Apple Touch Icon. The default value is `'assets/vendor/boilerplate/favicon.svg'`

### icons

Array of icons for the PWA in different sizes and formats. The default includes an SVG icon that scales to any size.
