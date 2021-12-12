# Laravel / AdminLTE 3 Boilerplate

[![Packagist](https://img.shields.io/packagist/v/sebastienheyd/boilerplate.svg?style=flat-square)](https://packagist.org/packages/sebastienheyd/boilerplate)
[![Build Status](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/badges/build.png?b=master&style=flat-square)](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/build-status/master)
[![StyleCI](https://github.styleci.io/repos/86598046/shield?branch=master&style=flat-square)](https://github.styleci.io/repos/86598046)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/badges/quality-score.png?b=master&style=flat-square)](https://scrutinizer-ci.com/g/sebastienheyd/boilerplate/?branch=master)
![Laravel](https://img.shields.io/badge/Laravel-6.x%20→%208.x-green?logo=Laravel&style=flat-square)
[![Nb downloads](https://img.shields.io/packagist/dt/sebastienheyd/boilerplate.svg?style=flat-square)](https://packagist.org/packages/sebastienheyd/boilerplate)
[![MIT License](https://img.shields.io/github/license/sebastienheyd/boilerplate.svg?style=flat-square)](license.md)

This package serves as a basis for quickly creating a back-office. 
It includes profile creation and his management, user management, roles, permissions and log viewing.

It also makes it easy to add other packages to extend the features, have a look to
[sebastienheyd/boilerplate-packager](https://github.com/sebastienheyd/boilerplate-packager) to quickly build your own
package for boilerplate.

Other packages to extend the features :
* [sebastienheyd/boilerplate-media-manager](https://github.com/sebastienheyd/boilerplate-media-manager)
* [sebastienheyd/boilerplate-email-editor](https://github.com/sebastienheyd/boilerplate-email-editor)

---

<a href="https://sebastienheyd.github.io/boilerplate/assets/img/login.png" class="img-link"><img src="https://sebastienheyd.github.io/boilerplate/assets/img/login.png" style="max-width:100%;height:100px;margin-right:.5rem"/></a>
<a href="https://sebastienheyd.github.io/boilerplate/assets/img/add_user.png" class="img-link"><img src="https://sebastienheyd.github.io/boilerplate/assets/img/add_user.png" style="max-width:100%;height:100px;margin-right:.5rem" /></a>
<a href="https://sebastienheyd.github.io/boilerplate/assets/img/role.png" class="img-link"><img src="https://sebastienheyd.github.io/boilerplate/assets/img/role.png" style="max-width:100%;height:100px;margin-right:.5rem" /></a>
<a href="https://sebastienheyd.github.io/boilerplate/assets/img/logs.png" class="img-link"><img src="https://sebastienheyd.github.io/boilerplate/assets/img/logs.png" style="max-width:100%;height:100px;margin-right:.5rem" /></a>

## Documentation

The documentation is readable on [Github pages](https://sebastienheyd.github.io/boilerplate/)

## Features

* Configurable [backend theme](https://sebastienheyd.github.io/boilerplate/howto/change-theme) and [components](https://sebastienheyd.github.io/boilerplate/components/) for [AdminLTE 3](https://adminlte.io/docs/3.0/)
* Css framework [Bootstrap 4](https://getbootstrap.com/)
* Icons by [Font Awesome 5](https://fontawesome.com/)
* Role-based permissions support by [santigarcor/laratrust](https://github.com/santigarcor/laratrust)
* Forms & Html helpers by [laravelcollective/html](https://github.com/laravelcollective/html)
* Menu dynamically builded by [lavary/laravel-menu](https://github.com/lavary/laravel-menu)
* Menu items activated by [hieu-le/active](https://github.com/letrunghieu/active)
* Server-side datatables methods provided by [yajra/laravel-datatables](https://yajrabox.com/docs/laravel-datatables)
* Image manipulation by [intervention/image](https://github.com/intervention/image)
* Logs visualization by [arcanedev/log-viewer](https://github.com/ARCANEDEV/LogViewer)
* Gravatar import by [thomaswelton/laravel-gravatar](https://github.com/thomaswelton/laravel-gravatar)
* Default languages support by [overtrue/laravel-lang](https://github.com/overtrue/laravel-lang) and [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang)
* Javascript session keep-alive
* [Localized](https://github.com/sebastienheyd/boilerplate/tree/master/src/resources/lang)

## Installation

1. In order to install Laravel/AdminLTE Boilerplate run :

```
composer require sebastienheyd/boilerplate
```

2. Run the command below to publish assets, lang and configuration files

```
php artisan vendor:publish --tag=boilerplate
```

3. After you set your database parameters run :

```
php artisan migrate
```

**Optional**

If you want to quickly test your Laravel application.

```
php artisan serve
```

Now you can point your browser to [http://localhost:8000/admin](http://localhost:8000/admin)

## Package update (Laravel < 8.6.9)

Boilerplate comes with assets such as Javascript, CSS, and images. Since you typically will need to overwrite the assets
every time the package is updated, you may use the ```--force``` flag :

```
php artisan vendor:publish --tag=boilerplate-public --force
```

To auto update assets each time package is updated, you can add this command to `post-update-cmd` into the
file `composer.json` at the root of your project.

```json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=boilerplate-public --force -q"
        ]
    }
}
```

## Tests / Coding standards

This package is delivered with a `Makefile` used to launch checks for the respect of coding standards and the unit tests

Just call `make` to see the list of commands.

### Laravel Dusk functionnal tests

This package is also delivered with functional tests using [Laravel Dusk](https://laravel.com/docs/dusk)

After installing Laravel, Laravel Dusk and configuring your database, you can start the tests with the following command :

```
php artisan dusk vendor/sebastienheyd/boilerplate/tests/DuskTest.php
```

**Important** : Never launch tests with Laravel Dusk if you have data in your database,  Dusk will wipeout all your datas

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Credits

- [Sébastien HEYD](https://github.com/sebastienheyd)
- [All Contributors](https://github.com/sebastienheyd/boilerplate/contributors)


## License

This package is free software distributed under the terms of the [MIT license](license.md).

## Special thanks

This project is made with [PhpStorm](https://www.jetbrains.com/phpstorm/) and supported by [JetBrains](https://www.jetbrains.com/?from=LaravelBoilerplate)

[![JetBrains Logo](jetbrains.svg)](https://www.jetbrains.com/?from=LaravelBoilerplate)