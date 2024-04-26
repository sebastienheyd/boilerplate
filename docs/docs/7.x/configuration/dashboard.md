# dashboard.php

:::warning IMPORTANT
Boilerplate version >= 7.24
:::

The `config/boilerplate/dashboard.php` file allows to manage the dashboard.

---

```php
return [
    'edition'    => true,
    'widgets'    => [
        ['users-number' => []],
    ],
];

```

> NB: To maintain retrocompatibility with older versions of Boilerplate, the configuration value that defines the controller for the dashboard is located in the [menu.php](menu.md) configuration file.

---

## edition

Allows editing of the dashboard. By setting the value to `true`, it is possible to manage the widgets that will constitute the dashboard.

---

## widgets

Array of widgets that will be displayed by default on the dashboard. For each widget, a sub-array will be declared with the `slug` as the key, and if necessary, a sub-array containing the parameters, for example:

```php
return [
    'edition' => true,
    'widgets' => [
        ['users-number' => ['color' => 'info']],
    ],
];
```