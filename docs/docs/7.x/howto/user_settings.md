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