# Troubleshooting

---

## Dates localization

Since Laravel 5.8, this package use [Carbon 2](https://carbon.nesbot.com/docs/#api-localization) instead of [Jenssegers/Date](https://github.com/jenssegers/date) to translate dates.

Date format now use the format of momentjs. To translate your dates, you must now use the Carbon 2 class method `isoFormat`
instead of `format`

See [Carbon 2 documentation](https://carbon.nesbot.com/docs/#api-localization)

---

## Migration error

MySQL < v5.7.7 or MariaDB

When you run `php artisan migrate` and you hit this error :

```
[PDOException]
  SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes
```

This is an error from a change since Laravel 5.4 : [see here](https://laravel-news.com/laravel-5-4-key-too-long-error)

To correct this, two possibilities :

- Define `utf8` instead of `utf8mb4` as default database charset and `utf8_unicode_ci` instead of
`utf8mb4_unicode_ci` as default database collation.

- Edit your `app/Providers/AppServiceProvider.php` file and define a default string inside the boot method :

```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```