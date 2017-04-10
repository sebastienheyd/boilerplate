# Laravel - AdminLTE - Boilerplate

This package is to be served as a basis for a web application. It allows you to manage users, roles and permissions.

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
* Localized English-French

## Installation

1. In order to install Laravel - AdminLTE - Boilerplate run :

```
composer require sebastienheyd/boilerplate
```

2. Open ```config/app.php``` and add the following to the ```providers``` array :

```
Sebastienheyd\Boilerplate\BoilerplateServiceProvider::class,
```

3. Run the command below to publish assets, views, lang files, ...

```
php artisan vendor:publish
```

4. After you set your database parameters in your ```.env``` file run :

```
php artisan migrate
```

You are ready to go !