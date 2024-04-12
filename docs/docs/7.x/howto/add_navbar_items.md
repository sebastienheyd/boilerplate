# Add items to the top bar

To add items to the main menu, boilerplate will use providers.

## By configuration

You can add additional views that will be included to the top bar by editing the `navbar` array in `config/boilerplate/theme.php`. This can be useful to add buttons, notifications, ...

```php
// Additionnal views to append items to the navbar
$theme['navbar'] += [
    'left'  => [],
    'right' => [],
];
``` 

To do that, just add view path using the "dot" notation, ex: `admin.topbar.left`.

As you can see in the config file, you can set them on the left or on the right. Simply place the declarations in the appropriate array.

> If you have data to be bound to a view that will be include to the top bar, you can use [Laravel View Composers](https://laravel.com/docs/views#view-composers), you can also use `@push('js')` to add js scripts to get the data via ajax calls.

## For package developpers

Like the configuration file, you can add navbar items programmatically by using the `boilerplate.navbar.items` singleton : 

```php
app('boilerplate.navbar.items')->registerItem('admin.topbar.left', 'left');

// or with an array on the right side
app('boilerplate.navbar.items')->registerItem(['admin.topbar.right', 'admin.topbar.notifications'], 'right');
```

This can be used everywhere : controllers, middlewares, etc.