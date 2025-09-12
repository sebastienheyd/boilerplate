# Add items to the menu

Menu items are supported by the [lavary/laravel-menu](https://github.com/lavary/laravel-menu) and [sebastienheyd/active](https://github.com/sebastienheyd/active) packages.

To add items to the main menu, boilerplate will use providers.

## Generating a new menu items provider

This package provides an artisan command to quickly generate a menu items provider.

This command will generate the provider file in the `app/Menu` folder, if the folder does not exists, it will be created.

```bash
php artisan boilerplate:menuitem {name} {-s} {-o=100}
```

| option / argument | description |
|---|---|
| name | Menu item name |
| -s --submenu | Menu item must have sub item(s) ? |
| -o --order | Menu item order in the backend menu, default is 100 |

Once generated, the class file can be edited to customize the items, see [Menu item provider](#menu-items-provider)

You can also add your own providers by adding their classnames to the array of providers in the configuration file
`config/boilerplate/menu.php`. This can be useful if you don't want to use the default directory `app/Menu` in your 
application.

---

## For package developpers

Menu items providers can be added by using the `boilerplate.menu.items` singleton in your 
package service provider. Example : 

```php
public function boot()
{
    app('boilerplate.menu.items')->registerMenuItem([
        \MyPackage\MyNamespace\MyMenu::class,
    ]);
}
```

---

## Menu items provider

Once generated menu items provider are used to build the back-office main menu. 

You will find a method `make` inside where items are added. 

To add an item at the root of the menu, you have to call the `add` method on `$menu` (instance of `Sebastienheyd\Boilerplate\Menu\Builder`) 

```php
public function make(Builder $menu)
{
    $menu->add($label, $options);
}
```

The `label` can be a string or a locale string. The locale string will be translated if exists.

Options are :

| Name | Description |
|---|---|
| **route** | The menu item link will point on this route, useless on items with sub items. |
| **permission** | Comma separated list of permissions required to display the menu item. |
| **role** | Comma separated list of roles required to display the menu item. Admin is setted by default. |
| **active**| Comma separated list of routes or route wildcard (eg: `boilerplate.users.*`). When one route is corresponding to the current one, item will be activated |
| **icon** | Font awesome icon or image URL to use. You can use by default solid icons (`fas`) by just set the icon name (eg: `square`). Or you can set the full classes to use (eg: `far fa-square`). [See icons here](https://fontawesome.com/icons?d=gallery&m=free). |
| **order** | Order in the main menu (default = 100), the dashboard is level 0, users management is level 1000. |

To add a sub item to an item :

```php
public function make(Builder $menu)
{
    $item = $menu->add($label, $options);
    
    // Adding the sub item to the item above.
    $item->add($label, $options);
}
``` 
