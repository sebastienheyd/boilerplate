# Language

The default language used by boilerplate is the global application language declared as `locale` in `config/app.php`.

You can define another default language for the admin panel by setting the `default` parameter in `config/boilerplate/locale.php`. 
To not breaking older version of Boilerplate, the parameter `locale` in `config/boilerplate/app.php` is used priorly if exists.

You can activate a language switch by setting to true the `switch` parameter in `config/boilerplate/locale.php`. A language
selector will so be shown on the login page and in the top bar. Select allowed switchable languages by setting the `allowed` parameter
in `config/boilerplate/locale.php`

To work with your developments it will then be necessary to define the `boilerplatelocale` middleware on your routes.

> The `boilerplatelocale` middleware will replace default application locale by the locale set in the boilerplate's configuration file.
> 
> See [Laravel documentation](https://laravel.com/docs/master/middleware#assigning-middleware-to-routes) on assigning middleware to routes.

[See locale.php configuration file](configuration/locale)

## Add a new language

To add a new language run the following command : `php artisan vendor:publish --tag=boilerplate-lang`. 

After running the command, you will find translations folders into `resources/lang/vendor/boilerplate`. Copy one of the language 
folder to the destination language you want to add.

When your files are all translated, add the language to `languages` in the file `config/boilerplate/locale.php`

To add the language to the language switch, you have to add it to the `allowed` array in the file `config/boilerplate/locale.php`