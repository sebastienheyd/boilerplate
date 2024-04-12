# Create a DataTable

::: warning IMPORTANT
Boilerplate version >= 7.10
:::

<a :href="$withBase('/assets/img/datatable.jpg')" class="img-link"><img :src="$withBase('/assets/img/datatable.png')" style="max-width:100%;height:400px;margin-right:.5rem"/></a>

The [datatable component](../components/datatable) uses a class to operate. The class will specify the [options](options) of the table, the [data source](datasource), and the [columns](column) to be used.

This class can be generated via an artisan command.

---

## Generating a DataTable class

To generate a new class that can be used with the component, you can use the artisan command:

```
php artisan boilerplate:datatable
```

You can define the name of the component directly by specifying it :

```
php artisan boilerplate:datatable users
```

You can also define the model to use as data source directly :

```
php artisan boilerplate:datatable users --model="App\Models\User" 
```

> Defining a model as data source will automatically scan the database to define the visible fields as datatable columns. You can avoid this scan by using the `--nodb` option, in this case the generator will only use the fields declared in the model class.

---

## For package developpers

By default, generated datatable classes are placed in the folder `app\Datatables`

But you can declare your own datatable class within your package service provider by using the `boilerplate.datatables` singleton :

```
public function boot()
{
    app('boilerplate.datatables')->registerDatatable(\MyVendoName\MyPackage\MyModelDatatable::class);
} 
```

---

## Calling the datatable

The attribute `slug` will be used as `name` by the component to know which class must be called.

Set the `slug` property in the datatable class :

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ExampleDatatable extends Datatable
{
    public $slug = 'example';

    //...
}
```

Then call the datatable :

```html
<x-boilerplate::datatable name="example" />
```