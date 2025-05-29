# theme.php

The `config/boilerplate/theme.php` file allows to define the backend theme parameters.

---

```php
<?php
// Selected theme
$selectedTheme = env('BOILERPLATE_THEME', 'default');

// Check if theme exists
$themePath = __DIR__.'/themes/'.$selectedTheme.'.php';
if (!file_exists($themePath)) {
    $selectedTheme = 'default';
    $themePath = __DIR__.'/themes/default.php';
}

$theme = include $themePath;

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left' => [],
        'right' => [],
    ],
    'favicon' => null,          // Favicon url
    'fullscreen' => true,       // Fullscreen switch
    'darkmode' => true,         // Dark mode switch
];

return $theme;
```
---

## theme

Theme to use. You can change the theme by setting the `BOILERPLATE_THEME` environment variable in your `.env` file.

The system automatically validates that the specified theme file exists and falls back to the default theme if not found.

See [How to change theme](/howto/change-theme)

---

## navbar

Allows you to define additionnal views that will be displayed to the top bar.

See [How-to add items to the top bar](/howto/add-navbar-items)

---

## favicon

Allows you to define an url to the favicon.

If null, a default favicon will be shown.

---

## fullscreen

If true will show a switch to activate the full screen.

---

## darkmode

If true will show a switch to activate the dark mode. 