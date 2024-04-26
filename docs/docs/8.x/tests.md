# Tests

This package is delivered with a `Makefile` used to launch checks for the respect of coding standards and the unit tests

Just call `make` to see the list of commands.

### Laravel Dusk functionnal tests

This package is also delivered with functional tests using [Laravel Dusk](https://laravel.com/docs/dusk)

After installing Laravel, Laravel Dusk and configuring your database, you can start the tests with the following command :

```
php artisan dusk vendor/sebastienheyd/boilerplate/tests/DuskTest.php
```

**Important** : Never launch tests with Laravel Dusk if you have data in your database,  Dusk will wipeout all your datas
