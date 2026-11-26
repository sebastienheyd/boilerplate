# theme.php

The `config/boilerplate/theme.php` file allows to define the backend theme parameters.

---

```php
<?php
// Selected theme
$selectedTheme = env('BOILERPLATE_THEME', 'modern');

// Check if theme exists
$themePath = __DIR__.'/themes/'.$selectedTheme.'.php';
if (!file_exists($themePath)) {
    $selectedTheme = 'modern';
    $themePath = __DIR__.'/themes/modern.php';
}

$theme = include $themePath;

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left' => [],
        'right' => [],
    ],
    'favicon' => null,          // Favicon url
    'fullscreen' => false,      // Fullscreen switch
    'darkmode' => true,         // Dark mode switch
    'minify' => true,           // Minify inline JS / CSS when using boilerplate::minify component
];

return $theme;
```
---

## theme

Theme to use. You can change the theme by setting the `BOILERPLATE_THEME` environment variable in your `.env` file.

The system automatically validates that the specified theme file exists and falls back to the `modern` theme if not found.

Available themes are `modern` (default), `default`, `black` and `red`. They are stored in the `config/boilerplate/themes`
folder.

See [How to change theme](/howto/change-theme)

---

## style

Each theme file defines a `style` key:

| Value | Description |
|-------|-------------|
| `modern` | Modern style with named color palettes, see [Modern theme](../modern_theme.md) |
| `classic` | AdminLTE style, colors are set by the theme file only |

Any other value is handled as `classic`. The `modern` theme uses `modern`, the `default`, `black` and `red` themes use
`classic`.

::: tip
A theme file published before the modern style was added has no `style` key: it keeps the `classic` style.
:::

---

## palette

Color palette of the `modern` style: `orange` (default), `blue`, `green`, `red`, `purple` or `teal`. It has no effect
with the `classic` style, and an unknown palette falls back to `orange`.

In the `modern` theme, the palette is set by the `BOILERPLATE_PALETTE` environment variable:

```env
BOILERPLATE_PALETTE=teal
```

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