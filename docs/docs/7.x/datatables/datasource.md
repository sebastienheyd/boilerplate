# Datasource

You may use Laravel's Eloquent Model, Query Builder or Collection as data source for your dataTables.

---

## Eloquent

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use Sebastienheyd\Boilerplate\Models\User;

class ExampleDatatable extends Datatable
{
    public function datasource()
    {
        return User::query();
    }

    //...
}
```

---

## Query Builder

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use DB;

class ExampleDatatable extends Datatable
{
    public function datasource()
    {
        return DB::table('users');
    }

    //...
}
```

---

## Collection

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ExampleDatatable extends Datatable
{
    public function datasource()
    {
        return collect([
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'James'],
        ]);
    }

    //...
}
```

---

## Array

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ExampleDatatable extends Datatable
{
    public function datasource()
    {
        return [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'James'],
        ];
    }

    //...
}
```

---

## API

When using an API as data source, you can use `setOffset`, `setTotalRecords`, `setFilteredRecords` and `skipPaging` to set the Datatable informations.

```php
use GuzzleHttp\Client;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ExampleDatatable extends Datatable
{
    public function datasource()
    {
        $json = (new Client())->get('https://myapiurl.tld/api', [
            'query' => [
                'q' => request()->input('search.value'),
                'offset' => request()->input('start'),
                'length' => request()->input('length'),
                'filter_on_field_1' => request()->input('columns.0.search.value'),
                'filter_on_field_2' => request()->input('columns.1.search.value'),
            ]
        ])->getBody()->getContents();
        
        $data = json_decode($json, true);
                
        $this->setOffset(request()->input('start'))
             ->setTotalRecords($data['total'])
             ->setFilteredRecords($data['total'])
             ->skipPaging();
    
        return $data['items'];
    }
}
```

---

## Passing parameters

Sometimes you need to pass some parameters to the ajax call that retrieves the data. To do that, you can pass the parameters 
with the `ajax` argument :

```html
<x-boilerplate::datatable name="example" :ajax="['role' => 'admin']"/>
```

Then you can retrieve the value by getting the posted argument :

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use DB;

class ExampleDatatable extends Datatable
{
    public function datasource()
    {
        return DB::table('users')->whereRoleIs(request()->post('role'));
    }

    //...
}
```