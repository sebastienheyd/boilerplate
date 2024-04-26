# Generate a dashboard widget

The dashboard is composed of configurable widgets. It is possible to generate these widgets using an artisan command.

<a :href="$withBase('/assets/img/dashboard.png')" class="img-link"><img :src="$withBase('/assets/img/dashboard.png')" style="max-width:100%;height:400px;margin-right:.5rem"/></a>

---

## Artisan Command

To generate a new widget for the dashboard, you can use the following artisan command:

```
php artisan boilerplate:widget
```

You can also directly define the name of the widget to generate as an argument of the command:

```
php artisan boilerplate:widget "my awesome widget"
```

Using this command with this example, three files will be generated:

- **/app/Dashboard/MyAwesomeWidget.php**: class called for rendering the widget, functions like a view composer
- **/resources/views/dashboard/widgets/my-awesome-widget.blade.php**: the view of the widget that will be rendered
- **/resources/views/dashboard/widgets/my-awesome-widgetEdit.blade.php**: the view of the widget parameter editing form

---

## For packages developers

By default, datatable classes are placed in the folder `app/Dashboard`

But you can declare your own widgets classes within your package service provider by using the `boilerplate.dashboard.widgets` singleton :

```
public function boot()
{
    app('boilerplate.dashboard.widgets')->registerWidget(MyPackageFirstWidget::class, MyPackageSecondWidget::class);
}
```