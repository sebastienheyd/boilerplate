# Full customization

Sometimes you need to customize templates, controllers or views for your needs.

For example: you need to add fields to your user to be able to identify him, for that you have to modify the user model, but also the views and the controller that manages the data of the user.

## Scaffold

::: warning
By using this command, all updates from future versions of boilerplate will be ignored. Use this only if you know what you are doing !
:::

This command will publish in your project the necessary files that will override those of the package and will allow you to modify them as you want.

```bash
php artisan boilerplate:scaffold
```

This command will create these files or directories :

| Path from project root | Description |
| --- | --- |
| routes/boilerplate.php | Edit this file to customize url or called controllers |
| app/Http/Controllers/Boilerplate | All controllers used by this package |
| app/Models/Boilerplate | User, Permission, Role and PermissionCategory models. Here you can add data to your user |
| app/Events/Boilerplate | Events linked to User when created or deleted |
| app/Notifications/Boilerplate | Notifications sended to user when created or when requesting a new password |
| resources/views/vendor/boilerplate | Here you can customize all views used by this package |
| resources/lang/vendor/boilerplate | Customize or add new translations |
| config/boilerplate | Configuration files |
| public/assets/vendor/boilerplate | Default public assets (must not be edited) |

The command will make a modification in the config file `menu.php` to replace `Sebastienheyd\Boilerplate\Controllers` 
by `\App\Http\Controllers\Boilerplate` for the dashboard.

The command will also make some modifications in the config files `laratrust.php` and `auth.php` to replace 
`Sebastienheyd\Boilerplate\Models` by `App\Models\Boilerplate`.

And finally, if you have existing users in the database, they will be updated to the new user model.

## Rollback

You can restore the configuration and delete the installed files by calling the command with the remove option:

```bash
php artisan boilerplate:scaffold -r
```