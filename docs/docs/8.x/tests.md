# Tests

This package is delivered with a `Makefile` used to launch checks for the respect of coding standards and the unit tests

Just call `make` to see the list of commands.

### Local demo environment

The package can be run locally, without a Laravel application, with [Orchestra Testbench](https://packages.tools/testbench) :

```
composer install
composer serve
```

`composer serve` builds the workbench (publishes the assets, creates a SQLite database, runs the migrations and creates a
demo administrator), then starts a development server on [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin).

Sign in with `admin@example.com` / `password`, prefilled on the demo login page. The `/admin/demo` page shows the
components, the plugins and the elements styled by the theme.

Without a local PHP, the same demo runs with Docker, from the package root :

```
docker compose up
```

The container installs the Composer dependencies, builds the workbench and serves the demo on
[http://localhost:8000/admin](http://localhost:8000/admin). It runs as the user `1000:1000` so that the files written
in `vendor/` keep their owner : if your user id is different, start it with `UID=$(id -u) GID=$(id -g) docker compose up`.

The theme can be changed with the `BOILERPLATE_THEME` (`modern`, `default`, `black`, `red`) and `BOILERPLATE_PALETTE`
(`orange`, `blue`, `green`, `red`, `purple`, `teal`) environment variables, set in `testbench.yaml` or on the command
line :

```
BOILERPLATE_PALETTE=teal composer serve
BOILERPLATE_PALETTE=teal docker compose up
```

Use `composer build` alone to reset the demo database.

The demo server uses its own router (`workbench/server.php`, copied to the Testbench skeleton by `composer build`) : it
serves the assets with cache headers, as a real web server does, so that they are not downloaded again on each page.

### Laravel Dusk functionnal tests

This package is also delivered with functional tests using [Laravel Dusk](https://laravel.com/docs/dusk)

After installing Laravel, Laravel Dusk and configuring your database, you can start the tests with the following command :

```
php artisan dusk vendor/sebastienheyd/boilerplate/tests/DuskTest.php
```

**Important** : Never launch tests with Laravel Dusk if you have data in your database,  Dusk will wipeout all your datas
