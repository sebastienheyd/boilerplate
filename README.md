# Laravel/AdminLTE Boilerplate

![Package](https://img.shields.io/badge/Package-sebastienheyd%2Fboilerplate-lightgrey.svg)
![Laravel](https://img.shields.io/badge/Laravel-5.6.x-green.svg)
![Packagist](https://img.shields.io/badge/packagist-v5.5.1-blue.svg)
![Nb downloads](https://img.shields.io/packagist/dt/sebastienheyd/boilerplate.svg)
![MIT License](https://img.shields.io/github/license/sebastienheyd/boilerplate.svg)

This package is to be served as a basis for a web application. 
It allows you to access to an administration panel to manage users, 
roles and permissions.

For other Laravel versions : [5.5](https://github.com/sebastienheyd/boilerplate/blob/5.5/README.md) / [5.4](https://github.com/sebastienheyd/boilerplate/blob/5.4/README.md)

## Features

* Backend theme [Admin LTE](https://almsaeedstudio.com/)
* Css framework [Bootstrap 3](http://getbootstrap.com/)
* Additional icons by [Font Awesome](http://fontawesome.io/)
* Role-based permissions provided by [santigarcor/laratrust](https://github.com/santigarcor/laratrust)
* Forms & Html helpers by [laravelcollective/html](https://github.com/laravelcollective/html) 
* Menu dynamically builded by [lavary/laravel-menu](https://github.com/lavary/laravel-menu)
* Menu items activated by [hieu-le/active](https://github.com/letrunghieu/active)
* Server-sided datatables methods provided by [yajra/laravel-datatables](https://github.com/yajra/laravel-datatables)
* Multi-language date support by [jenssegers/date](https://github.com/jenssegers/date)
* Image manipulation by [intervention/image](https://github.com/intervention/image)
* Localized English / French / Spanish

## Installation

1. In order to install Laravel/AdminLTE Boilerplate run :

```
composer require sebastienheyd/boilerplate
```

2. Run the command below to publish assets, views, lang files, ... 

```
php artisan vendor:publish --provider="Sebastienheyd\Boilerplate\BoilerplateServiceProvider"
```

3. After you set your database parameters in your ```.env``` file run :

```
php artisan migrate
```

**Optional**

If you want to quickly test your Laravel application.
               
```
php artisan serve
```

Now you can point your browser to [http://localhost:8000/](http://localhost:8000/) you will see buttons on the top right 
of the Laravel's default page. Click on Login or Register to access the administration panel.

## Update

Boilerplate comes with assets such as Javascript, CSS, and images. Since you typically will need to overwrite the assets every time the package is updated, you may use the ```--force``` flag. For example :
  
```
php artisan vendor:publish --provider="Sebastienheyd\Boilerplate\BoilerplateServiceProvider" --tag=public --force
```

If needed, you can force update for these tags : ```config```, ```routes```, ```resources```, ```public```, ```models```, ```notifications```, ```webpack```

## Configuration

After `php artisan vendor:publish --provider="Sebastienheyd\Boilerplate\BoilerplateServiceProvider"` you will find a folder `boilerplate` into the directory `config`.

* [`app.php`](src/config/boilerplate/app.php) : name of the application (only backend), admin panel prefix and redirection after login (see comments in file)
* [`auth.php`](src/config/boilerplate/auth.php) : overriding of `config/auth.php` to use boilerplate's models instead of default Laravel's models. Allow you to define if users can register from login page and which role will be assigned to a new user.
* [`laratrust.php`](src/config/boilerplate/laratrust.php) : overriding of Laratrust's (package santigarcor/laratrust) default config.
* [`menu.php`](src/config/boilerplate/menu.php) : classes to add menu items, [see below](#adding-items-to-the-main-menu).

### Adding items to the main menu

If in your application you need to add items to the main menu, you must declare the classes you want to use to build your menu into 
the config file [`menu.php`](src/config/boilerplate/menu.php).

As you can see you have already two classes declared into this file, if you check the code into [Users.php](src/Menu/Users.php) or [Logs.php](src/Menu/Logs.php) you will find a method named `make(Builder $menu)`.
This is the method called to build menu items. Feel free to use these files as an example to build your own menu items.

So, to add menu  items : create a class, declare this class into the config file `menu.php` and add a `make(Builder $menu)` method into the class.

Don't forget to declare ```use Sebastienheyd\Boilerplate\Menu\Builder as Builder;```

See [lavary/laravel-menu](https://github.com/lavary/laravel-menu) and [hieu-le/active](https://github.com/letrunghieu/active) documentations.

### Customizing views

When published by `php artisan vendor:publish --provider="Sebastienheyd\Boilerplate\BoilerplateServiceProvider"` views are copied to the folder `resources/views/vendor/boilerplate`.

Error views are copied to the folder `resources/views/errors`

Every view into these folders can be modified, they will not be overwrited if you launch `php artisan vendor:publish --provider=sebastienheyd/boilerplate` again. You can already delete these files to reset them if needed, just remove them and run `php artisan vendor:publish --provider=sebastienheyd/boilerplate`

### Routes

Routes are loaded from the file [`boilerplate.php`](src/routes/boilerplate.php). 
After `php artisan vendor:publish --provider="Sebastienheyd\Boilerplate\BoilerplateServiceProvider"` the file will be found in the folder `routes` at the root of your project.

A default prefix `admin` is set into the config file [`app.php`](src/config/boilerplate/app.php), this is why boilerplate is accessible by /admin url. 
You can set an empty prefix if you remove the default route / defined in `routes/web.php`  

### Language

Language used by boilerplate is the application language declared into `config/app.php`. 
For the moment only english, french and spanish are supported.

When you run `php artisan vendor:publish --provider="Sebastienheyd\Boilerplate\BoilerplateServiceProvider"`, locale files are copied to the folder `resources/lang/vendor/boilerplate`
 
NB : Dates are translated by the package [jenssegers/date](https://github.com/jenssegers/date)

### Loading plugins assets

By default, only jQuery, bootstrap 3, Font Awesome and AdminLTE scripts and css are loaded.

To "activate" and use plugins like datatable, datepicker, icheck, ... you can use "loaders". These are blade templates prepared to add the loading of scripts and styles for a plugin.

For example, you want to use a datepicker on a text field :
 
```blade
@include('boilerplate::load.datepicker')
@push('js')
    <script>
        $('.daterangepicker').daterangepicker();
        $('.datepicker').datepicker();
    </script>
@endpush
```

Here `@include('boilerplate::load.datepicker')` will load scripts and styles to allow usage of datepicker. After that you can push your scripts on the `js` stack (or styles on the `css` stack).

Available loaders are :

* [`boilerplate::load.datatables`](src/resources/views/vendor/boilerplate/load/datatables.blade.php) : [Datatables](https://www.datatables.net/) - [Example](src/resources/views/vendor/boilerplate/plugins/demo/datatables.blade.php) 
* [`boilerplate::load.datepicker`](src/resources/views/vendor/boilerplate/load/datepicker.blade.php) : [Datepicker](https://github.com/uxsolutions/bootstrap-datepicker) & [DateRangePicker](https://github.com/dangrossman/bootstrap-daterangepicker) - [Example](src/resources/views/vendor/boilerplate/plugins/demo/datepicker.blade.php)
* [`boilerplate::load.icheck`](src/resources/views/vendor/boilerplate/load/icheck.blade.php) : [iCheck](http://icheck.fronteed.com/) - [Example](src/resources/views/vendor/boilerplate/plugins/demo/icheck.blade.php)
* [`boilerplate::load.select2`](src/resources/views/vendor/boilerplate/load/select2.blade.php) : [Select2](https://select2.github.io/) - [Example](src/resources/views/vendor/boilerplate/plugins/demo/select2.blade.php)
* [`boilerplate::load.moment`](src/resources/views/vendor/boilerplate/load/moment.blade.php) : [MomentJs](http://momentjs.com/)
* [`boilerplate::load.fileinput`](src/resources/views/vendor/boilerplate/load/fileinput.blade.php) : [Bootstrap FileInput](http://plugins.krajee.com/file-input)

More will come...

Some plugins are loaded by default :

* [Bootbox](https://github.com/makeusabrew/bootbox) - [Example](src/resources/views/vendor/boilerplate/plugins/demo/bootbox.blade.php)
* [Notify](https://github.com/mouse0270/bootstrap-notify) - [Example](src/resources/views/vendor/boilerplate/plugins/demo/notify.blade.php)

You can see examples on the default dashboard.

### Updating assets

Boilerplate come with compiled assets. To do this, this package is frequently updated by using `npm` and `mix`.

If you need to update assets by yourself, remove the file `webpack.mix.js` at the root of your Laravel project and do a `php artisan vendor:publish --provider=sebastienheyd/boilerplate`. The file from this package will be automatically copied to this location.

You can already replace by yourself the file with the file [`webpack.mix.js`](src/webpack.mix.js) from this package.
 
After that, at the root of your project, run `npm update` and `npm run dev` (or `npm run production`).

[See Laravel `Mix` documentation](https://laravel.com/docs/5.5/mix)

## Troubleshooting

### Migration error

MySQL < v5.7.7 or MariaDB

When you run `php artisan migrate` and you hit this error :

```
[PDOException]                                                                                                   
  SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes
```

This is an error from a change since Laravel 5.4 : [see here](https://laravel-news.com/laravel-5-4-key-too-long-error)

To correct this, edit your `app/Providers/AppServiceProvider.php` file and define a default string inside the boot method : 

```php
use Illuminate\Support\Facades\Schema;

public function boot()
{
    Schema::defaultStringLength(191);
}
```

## License

This package is free software distributed under the terms of the [MIT license](LICENSE.md).
