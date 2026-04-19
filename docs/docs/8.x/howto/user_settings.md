# User settings

Sometimes it is useful to save the settings for each user, for example to keep the dark mode on each page.

For this purpose, the parameters of each user can be saved or read from the database using the following methods

## Retrieve a setting

To retrieve a setting, you can use the method `setting` of the model `User` :

```php
Auth::user()->setting('my-setting-name'); // Returns null as default value if setting does not exists
Auth::user()->setting('my-setting-name', false); // Returns false as default value if setting does not exists
```

To retrieve all settings as an associative array for the current user : 

```php
Auth::user()->settings;
```

## Store a setting or multiple settings

To store a setting or multiple settings, you have to pass an associative array to the method `setting` of the model `User` :

```php
// Store one setting
Auth::user()->setting(['my-setting-name' => 'my-setting-value']);

// Store multiple settings
Auth::user()->setting([
    'my-first-setting-name' => 'my-setting-value',
    'my-second-setting-name' => [
        'my-setting-value-1',
        'my-setting-value-2',        
    ],
]);
```

Or directly with the helper :

```php
setting(['my-setting-name' => 'my-setting-value']);
```

### Store with ajax

If you want to store a setting via ajax you can use the JS `storeSetting` function :

```html
<script>
    storeSetting('my-setting-name', 'my-setting-value')
</script>
```

## Avatar management

Each user can have a profile picture (avatar). The avatar is stored locally in `public/images/avatars/` and is served via the `avatar_url` attribute.

If no avatar has been uploaded, the package falls back to a generated initials image from [ui-avatars.com](https://ui-avatars.com).

### Retrieve the avatar URL

```php
Auth::user()->avatar_url; // Returns the URL of the avatar, or the fallback initials image
```

### Check if a user has an avatar

```php
Auth::user()->hasAvatar(); // Returns true if a local avatar file exists
```

### Fetch avatar from Gravatar

At user creation, the package automatically attempts to download a Gravatar image for the new user's email address. You can also trigger this manually:

```php
Auth::user()->getAvatarFromGravatar(); // Returns true if a Gravatar was found and saved
```

### Delete the avatar

```php
Auth::user()->deleteAvatar(); // Returns true if the file was deleted
```

## Active sessions

When the session driver is set to `database`, users can view and manage their active sessions across devices from the profile page.

::: warning
Session management requires `SESSION_DRIVER=database` in your `.env` file and the `sessions` table to exist. Run `php artisan session:table && php artisan migrate` if needed.
:::

### List active sessions

Returns the list of active sessions for the current user, including device info (browser, OS, IP address, last activity):

```php
// Via the built-in route (AJAX)
// GET /boilerplate/user/sessions
```

Each session entry includes:
- `ip_address` — IP address of the session
- `browser` — Detected browser (Chrome, Firefox, Safari, Edge, Opera)
- `os` — Detected OS (Windows, macOS, Linux, iOS, Android)
- `icon` — FontAwesome icon class (`fa-desktop` or `fa-mobile-alt`)
- `last_activity` — Human-readable relative time
- `is_current` — Whether this is the current session

### Disconnect a specific session

```php
// Via the built-in route (AJAX)
// DELETE /boilerplate/user/sessions/{sessionId}
```

### Disconnect all other sessions

When a user changes their password from the profile page, they can optionally disconnect all other devices by enabling the "disconnect other devices" toggle. This deletes all sessions except the current one from the `sessions` table.