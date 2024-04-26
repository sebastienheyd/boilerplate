# auth.php

The `config/boilerplate/auth.php` file allows to define the authentication and registration parameters of the application.


---

```php
<?php
return [
    'register'      => false,           // Allow to register new users on backend login page
    'register_role' => 'backend_user',  // Given role to new users (except the first one who is admin)
    'verify_email'  => false,           // Users must have a valid e-mail (a verification email is sent when a user registers)
    'providers'     => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => Sebastienheyd\Boilerplate\Models\User::class,
            'table'  => 'users',
        ],
    ],
    'throttle' => [
        'maxAttempts' => 3,            // Maximum number of login attempts to allow
        'decayMinutes' => 1,           // Number of minutes to wait before login will be available again
    ],
];
```

---

## register

If `register` is set to `true` then it is possible for new users to register themselves to access the application.

A link "Register a new user" appears on the login page.

The default value is `false`.

---

## register_role

The `register_role` parameter allows to set the default role when a new user registers (if the "register" parameter
above is set to "true").

The default value is `backend_user`

> The first user created will always have the role admin

---

## verify_email

If `verify_email` is set to `true` all new registered users must confirm their e-mail address before accessing the application.

To do this, an e-mail is sent in which each user must click to confirm his address.

The default value is `false`.

> Only the first user (admin) and users invited to join the admin by e-mail will not be asked to confirm their e-mails.

---

## providers

The `providers` parameter overwrites `config/auth.php` to use boilerplate's user model
(`Sebastienheyd\Boilerplate\Models\User::class`) instead of the default Laravel one (`App\User::class`).

This setting allows you to define your own user class or your own provider if you want to add features.

---

## throttle

This configuration section allows you to set how many times a user can try to login unsuccessfully, and how many minutes
he must wait until he can try again. 