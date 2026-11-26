# Change theme

To change the theme, you can use the `BOILERPLATE_THEME` environment variable in your `.env` file or define it directly in the [`config/theme.php`](/configuration/theme) file.

## Method 1: Environment Variable (Recommended)

Add the theme name to your `.env` file:

```env
BOILERPLATE_THEME=black
```

With the `modern` theme, the color palette is set with the `BOILERPLATE_PALETTE` environment variable, see
[Modern theme](../modern_theme.md).

## Method 2: Direct Configuration

You can also manually modify the theme in your `config/boilerplate/theme.php` file:

```php
// Selected theme
$selectedTheme = env('BOILERPLATE_THEME', 'red'); // Change default here

// Check if theme exists
$themePath = __DIR__.'/themes/'.$selectedTheme.'.php';
if (!file_exists($themePath)) {
    $selectedTheme = 'default';
    $themePath = __DIR__.'/themes/default.php';
}

$theme = include $themePath;
```

> Available themes are `modern` (default), `default`, `black`, `red`. The system automatically validates theme existence and falls back to `modern` if the specified theme is not found.

<img :src="$withBase('/assets/img/theme_modern.png')" style="max-width:100%;height:100px;margin-right:.5rem" />
<img :src="$withBase('/assets/img/theme_modern_dark.png')" style="max-width:100%;height:100px;margin-right:.5rem" />
<img :src="$withBase('/assets/img/theme_default.png')" style="max-width:100%;height:100px;margin-right:.5rem" />
<img :src="$withBase('/assets/img/theme_black.png')" style="max-width:100%;height:100px;margin-right:.5rem" />
<img :src="$withBase('/assets/img/theme_red.png')" style="max-width:100%;height:100px;margin-right:.5rem" />

---

## Create a new theme

You don't have to create a new theme, you can also edit the `default` theme. But it is recommended to create a new theme, so you can add modifications without touching the default themes.

To create a new theme:

1. Copy the `modern.php` (or `default.php` for the classic style) file in the `config/boilerplate/themes/` folder to a new theme file (e.g., `custom.php`)
2. Modify your new theme file as needed  
3. Set the `BOILERPLATE_THEME` environment variable to your new theme name:

```env
BOILERPLATE_THEME=custom
```

The system will automatically load your custom theme. If the theme file doesn't exist, it will fallback to the `modern` theme.

---

## Application icon (logo) and display name

To change the application icon and the display name, just change the `sidebar/brand/logo/icon` and `sidebar/brand/logo/text` in the current theme file.

```php
'sidebar' => [
        'brand'   => [
            'logo' => [
                'bg'     => 'blue',
                'icon'   => '<i class="fa fa-cubes"></i>',
                'text'   => '<strong>BO</strong>ilerplate',
                'shadow' => 2,
            ],
        ]
]
```

You can use [Font Awesome](https://fontawesome.com/icons?d=gallery&m=free) icons for you logo.
