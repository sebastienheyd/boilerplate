# Progressive Web App (PWA)

The Boilerplate package provides built-in support for Progressive Web App (PWA) functionality, allowing you to transform your admin panel into an installable web application.

## Configuration

PWA support is controlled through the `app.php` configuration file. Add or modify the `pwa` section:

```php
// Progressive Web App configuration
'pwa' => [
    'enabled'          => false,
    'name'             => 'Admin Panel',
    'short_name'       => 'Admin',
    'description'      => 'Administration Panel',
    'theme_color'      => '#007bff',
    'background_color' => '#ffffff',
    'display'          => 'standalone',
    'orientation'      => 'portrait',
    'icons' => [
        [
            'src'   => 'favicon.svg',
            'sizes' => 'any',
            'type'  => 'image/svg+xml'
        ],
        [
            'src'   => 'icon-192.png',
            'sizes' => '192x192',
            'type'  => 'image/png'
        ],
        [
            'src'   => 'icon-512.png',
            'sizes' => '512x512',
            'type'  => 'image/png'
        ]
    ]
]
```

### Configuration Options

- **`enabled`**: Enable or disable PWA functionality
- **`name`**: Full application name displayed during installation
- **`short_name`**: Short name displayed on the home screen
- **`description`**: Application description
- **`theme_color`**: Browser UI color (address bar, etc.)
- **`background_color`**: Splash screen background color
- **`display`**: Display mode (`standalone`, `minimal-ui`, `fullscreen`, `browser`)
- **`orientation`**: Screen orientation (`portrait`, `landscape`, `any`)
- **`icons`**: Array of icon definitions with `src`, `sizes`, and `type`

## Activation

To enable PWA functionality:

1. Set `enabled` to `true` in your configuration
2. Ensure you have the required icon files in your `public` directory
3. The manifest route will be automatically registered at `/manifest.json`

## Manifest Generation

When PWA is enabled, the package automatically:

- Registers a route at `manifest.json` 
- Generates the manifest dynamically based on your configuration
- Adjusts `start_url` and `scope` based on your app's prefix and domain settings
- Converts icon paths to full URLs using Laravel's `asset()` helper

The manifest route name is `boilerplate.pwa.manifest`.

## Required Assets

Ensure you have the following icon files in your `public` directory:

- `favicon.svg` - Scalable vector icon (recommended)
- `icon-192.png` - 192×192 pixel PNG icon (required for installation)  
- `icon-512.png` - 512×512 pixel PNG icon (required for installation)

You can customize the icon configuration in the `pwa.icons` array to include additional sizes or different file formats.

## URL Handling

The package automatically handles URL configuration:

- **Start URL**: Uses the configured app prefix (e.g., `/admin` if prefix is set to `admin`)
- **Scope**: Automatically sets scope to include the app prefix with trailing slash
- **Domain**: Respects the configured domain setting for absolute URLs

## Installation

Once configured and enabled:

1. Modern browsers will detect PWA capability
2. Users will see an installation prompt when criteria are met
3. The app can be installed to the device's home screen
4. It will launch in standalone mode without browser UI

## Browser Requirements

PWA features require:

- Valid manifest.json file
- HTTPS connection (or localhost for development)
- At least one valid icon (192x192 minimum)
- Modern browser support (Chrome 57+, Firefox 58+, Safari 11.1+, Edge 17+)

## Troubleshooting

**Manifest not loading**: Verify PWA is enabled in configuration and check the route is registered.

**Installation prompt not showing**: Ensure all PWA criteria are met (HTTPS, valid manifest, required icons).

**Icons not displaying**: Check file paths exist in public directory and match configuration.

**Wrong URLs in manifest**: Verify your app's prefix and domain configuration settings.