# Laravel - AdminLTE - Boilerplate [![Packagist License][badge_license]](LICENSE.md)

This package is to be served as a basis for a web application. It allows you to manage users, roles and permissions.

## Features

* [Admin LTE Theme](https://almsaeedstudio.com/)
* [Bootstrap 3](http://getbootstrap.com/)
* [Font Awesome](http://fontawesome.io/)
* [zizaco/entrust](https://github.com/Zizaco/entrust)
* [laravelcollective/html](https://github.com/laravelcollective/html)

## Installation

1. In order to install Laravel - AdminLTE - Boilerplate run :

```
require sebastienheyd/boilerplate
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