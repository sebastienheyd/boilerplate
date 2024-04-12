# Installation

In order to install Laravel/AdminLTE Boilerplate run :

```
composer require sebastienheyd/boilerplate
```

Run the command below to publish assets, lang and configuration files

```
php artisan vendor:publish --tag=boilerplate
```

After you set your database run :

```
php artisan migrate
```

## Optional

If you want to quickly test your Laravel application.

```
php artisan serve
```

Now you can point your browser to [http://localhost:8000/admin](http://localhost:8000/admin)

If everything is ok, you will see the first user registration form.

<img :src="$withBase('/assets/img/register.png')" alt="Register">