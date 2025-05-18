# Upgrade from 7.x to 8.x

::: tip IMPORTANT
Boilerplate 8.x requires at least PHP 8.2 and Laravel 11.x
:::

## What's new in 8.x

- PHP >= 8.2
- [Laravel >= 11.x](https://laravel.com/docs/)
- [Intervention Image >= 3.x](http://image.intervention.io/) now with [Laravel Integration 1.x](https://github.com/Intervention/image-laravel)
- [Nesbot Carbon >= 3.x](https://carbon.nesbot.com/)
- [Laratrust >= 8.x](https://laratrust.santigarcor.me/)
- [Laravel Datatables >= 11.x](https://yajrabox.com/docs/laravel-datatables/master)
- [PHPUnit >= 11.x](https://phpunit.de/)
- [Laravel Orchestra Testbench >= 9.x](https://packages.tools/testbench.html)
- Replaced Arcanedev Log Viewer (which seems to be no longer maintained) with a custom solution.

## Upgrade steps

In order to upgrade from Boilerplate 7.x to 8.x you have to follow these steps:

1. Change your `composer.json` to require the 8.x version of Boilerplate:

```json
"sebastienheyd/boilerplate":"^8.0"
```

2. Run `composer update` to update the source code.

3. Run `php artisan config:clear`, `php artisan cache:clear` and `php artisan view:clear`.

## Intervention Image

Intervention Image v2.x is end of life and no longer maintained. The service provider for Laravel has been removed and the package has been replaced by the [Intervention Laravel Integration 1.x](https://github.com/Intervention/image-laravel) package.

Intervention Image has been updated to version 3.x. You can find the upgrade guide [here](https://image.intervention.io/v3/introduction/upgrade).