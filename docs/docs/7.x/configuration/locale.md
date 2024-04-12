# locale.php

The `config/boilerplate/locale.php` file allows to define the language options of the application.

---

```php
return [
    'default' => config('app.locale'),
    'switch' => false,
    'allowed' => ['en', 'es', 'fa', 'fr', 'it', 'tr'],
    'languages' => [
        'en' => ['label' => 'English', 'datatable' => 'English'],
        'es' => ['label' => 'Español', 'datatable' => 'Spanish'],
        'fa' => ['label' => 'فارسی', 'datatable' => 'Persian'],
        'fr' => ['label' => 'Français', 'datatable' => 'French'],
        'it' => ['label' => 'Italiano', 'datatable' => 'Italian'],
        'tr' => ['label' => 'Türkçe', 'datatable' => 'Turkish'],
    ],
];
```
---


## default

The `default` parameter allows you to define the language used in the back office. 

This makes possible to use a different language from the general language of the application, to work with your developments it will then be necessary to define the `boilerplatelocale` middleware on your routes.

> The `boilerplatelocale` middleware will replace default application locale by the locale set in the boilerplate's configuration file.
>
> See [Laravel documentation](https://laravel.com/docs/master/middleware#assigning-middleware-to-routes) on assigning middleware to routes.

To not breaking older version of Boilerplate, the parameter `locale` in `config/boilerplate/app.php` is used priorly if exists.

The default value is `config('app.locale')`

---

## switch

The `switcher` parameter allows you to display a language switch on the login view and to the top bar.

The default value is `false`

---

## allowed

The `allowed` array allows you to define which languages are visible in the language switch.

---

## languages

The `languages` array lists all available languages.

For each language you will find a `label` value that is used for the language switch and a `datatable` value to load the 
language file for datatables.

> The `datatable` value must match the name of the translation file of the i18n plugin for datatables, see the [datatables i18n plugin documentation](https://datatables.net/plug-ins/i18n/)

[See how to add a new language](../language)

