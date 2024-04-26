# Replace the dashboard

::: warning IMPORTANT
This will replace the default dashboard. By doing this you will not be able to use the [dashboard widgets](../dashboard/generate_widget)
:::

If you need to fully replace the default dashboard by using your own controller, you can run the following artisan command :

```bash
php artisan boilerplate:dashboard
```

This will publish these two files :

* `app/Http/Controllers/Boilerplate/DashboardController.php`
* `resources/views/vendor/boilerplate/dashboard.blade.php`

It will also change the `dashboard` configuration value in [`config/boilerplate/menu.php`](../configuration/menu)

## Rollback

You can restore the configuration and delete the installed files by calling the command with the remove option:

```bash
php artisan boilerplate:dashboard -r
```