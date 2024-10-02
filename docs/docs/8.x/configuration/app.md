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
        'model'        => 'gpt-3.5-turbo',
        'organization' => env('OPENAI_API_ORGANIZATION'),
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

## openai

Allows setting variables for using ChatGPT in TinyMCE