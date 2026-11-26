# Upgrade from 7.x to 8.x

::: tip IMPORTANT
Boilerplate 8.x requires at least PHP 8.2 and Laravel 11.x to 13.x
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
## Modern theme

Version 8.x adds a `modern` theme with named color palettes, see [Modern theme](modern_theme.md). It is the default
theme of new installations.

Existing installations keep their current look: a theme configuration published before this version has no `style` key
in its theme file, and is rendered with the `classic` style.

To switch an existing installation to the modern theme, either:

- add `'style' => 'modern'` to the theme file you use (for example `config/boilerplate/themes/default.php`). This works
  with any published configuration. You can also copy the AdminLTE settings of
  `vendor/sebastienheyd/boilerplate/src/config/themes/modern.php` into this file;

- or republish the configuration (your changes to the `config/boilerplate` files will be overwritten), which adds the
  `modern` theme file and makes it the default one:

```
php artisan vendor:publish --tag=boilerplate-config --force
```

::: tip
A `config/boilerplate/theme.php` file published before version 8.3.1 always loads `themes/default.php`: the
`BOILERPLATE_THEME` variable has no effect with it. Use the first method, or republish the configuration.
:::

Then publish the assets, which contain the modern stylesheet: `php artisan vendor:publish --tag=boilerplate-public --force`.

::: warning
An application that has never published the boilerplate configuration uses the package configuration, and switches to
the modern theme on update. Publish the assets (`php artisan vendor:publish --tag=boilerplate-public --force`), or set
`BOILERPLATE_THEME=default` in your `.env` file to keep the previous look. Without up-to-date assets, the modern
stylesheet is missing from the Mix manifest and Laravel throws an "Unable to locate Mix file" error in debug mode.
:::

The automatic dark mode (when the user has not chosen a mode) now follows the system preference. It was previously
enabled whatever this preference was.
