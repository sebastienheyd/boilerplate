# Notifications

The boilerplate package ships with three email notifications sent during authentication flows. All notifications use a shared Markdown email template and support the application's configured mail settings.

## NewUser

Sent automatically when an administrator creates a new user. The email contains a link to the first-login page where the new user sets their password.

The notification is sent via:

```php
$user->sendNewUserNotification($token);
```

## VerifyEmail

Sent when a user needs to verify their email address. This notification is triggered automatically if `boilerplate.auth.verify_email` is set to `true` in your configuration.

The notification is sent via:

```php
$user->sendEmailVerificationNotification();
```

## ResetPassword

Sent when a user requests a password reset. This is triggered by the standard Laravel password reset flow.

The notification is sent via:

```php
$user->sendPasswordResetNotification($token);
```

## Customizing notifications

You can override any notification by publishing the notification views:

```bash
php artisan vendor:publish --tag=boilerplate-lang
```

This publishes the email template to `resources/views/vendor/boilerplate/notifications/email.blade.php`.

To override a notification class entirely, publish the package config and update the `User` model to use your own notification class:

```php
// In your custom User model
public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\MyResetPassword($token));
}
```

::: tip
To configure whether email verification is required, see the [auth configuration](../configuration/auth.md) page.
:::
