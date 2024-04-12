# Options

Options are defined by using the `setUp` method, E.g.:

```php
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class ExampleDatatable extends Datatable
{
    public function setUp()
    {
        $this->permissions('users_crud')
            ->buttons('filters', 'csv', 'print')
            ->order('created_at', 'desc')
            ->pageLength(50)
            ->stateSave();
    }

    //...
}
```

| option | default | description |
| --- | --- | --- |
| [order()](#order) | [] | Defines which column(s) the order is performed upon, and the ordering direction |
| [buttons()](#buttons) | ['filters'] | Shows buttons that will trigger some actions like showing filters, exporting to csv, ... |
| [condensed()](#condensed) | false | If called, the table will be condensed | 
| [permissions()](#permissions) | ['backend_access'] | Sets the permissions to have to show the DataTable. |
| [stateSave](#statesave) | false | Restores table state on page reload |
| [showCheckboxes](#showcheckboxes) | false | Shows checkbox on each row |
| [lengthMenu()](#lengthmenu) | [[10, 25, 50, 100, -1],[10,25,50,100,'∞']] | Specifies the entries in the length drop down |
| [pageLength()](#pagelength) | 10 | Number of rows to display on a single page when using pagination |
| [pagingType()](#pagingtype) | simple_numbers | Type of buttons shown in the pagination control |
| [setRowId()](#setrowid) | null | Sets id to rows |
| [setRowClass()](#setrowclass) | null | Sets class to rows |
| [setRowAttr()](#setrowattr) | null | Sets attribute(s) to rows |
| [noPaging()](#nopaging) | visible | Disable paging |
| [noLengthChange()](#nolengthchange) | visible | Disable length change |
| [noSorting()](#nosorting) | visible | Disable sorting |
| [noOrdering()](#noordering) | visible | Disable sorting (alias) |
| [noSearching()](#nosearching) | visible | Disable searching |
| [noInfo()](#noinfo) | visible | Disable table informations |
| [locale()](#locale) | [] | Set different locale for generic buttons |

---

## order

Single-column ordering as the initial state:

```php
$this->order('id', 'desc')
```

Multi-column ordering as the initial state:

```php
$this->order(['name' => 'desc', 'created_at' => 'desc'])
```

## buttons

Shows buttons that will trigger some actions. The arguments order is the order of appearance.

```php
$this->buttons('filters', 'csv', 'refresh')
```

Built-in buttons : `filters`, `colvis`, `csv`, `excel`, `copy`, `print`, `refresh`

## condensed

If called, the table will be condensed.

```php
$this->condensed()
```

## permissions

Sets the permissions to have to show the DataTable.

```php
$this->permissions('users_crud', 'roles')
```

## stateSave

Enables state saving:

```php
$this->stateSave()
```

## showCheckboxes

Shows checkbox on every row:

```php
$this->showCheckboxes()
```

This will generate a checkbox on every row that can be used to select multiple elements.

To do this, every checkbox will be named `dt-checkbox[]` and use the id as the key. E.g `dt-checkbox[123]`. 

But it's possible to set another field as the key by setting it when calling the method. E.g `$this->showCheckboxes('item_id')`

> You can pass all the selected checkboxes to an ajax call by using the following selector : `$('input[name^=dt-checkbox]:checked').serialize()` 

## lengthMenu

Sets length menu options.

```php
$this->lengthMenu([10,50,100])
```

To show options 10, 50, 100 and all records:

```php
$this->lengthMenu([[10, 50, 100, -1] , [10, 50, 100, 'All']])
```

## pageLength

Shows 50 records per page:

```php
$this->pageLength(50])
```

## pagingType

Sets `numbers` as paging Type

```php
->setPagingType('numbers')
```

Allowed types are 

* `numbers` - Page number buttons only
* `simple` - 'Previous' and 'Next' buttons only
* `simple_numbers` - 'Previous' and 'Next' buttons, plus page numbers
* `full` - 'First', 'Previous', 'Next' and 'Last' buttons
* `full_numbers` - 'First', 'Previous', 'Next' and 'Last' buttons, plus page numbers 
* `first_last_numbers` - 'First' and 'Last' buttons, plus page numbers

## setRowId

Sets row id via `column` name.

```php
->setRowId('id')
```

Sets row id via `closure`.

```php
->setRowId(function ($user) {
    return $user->id;
})
```

Sets row id via `blade` string.

```php
->setRowId('{{$id}}')
```

## setRowClass

Sets row class via `closure`.

```php
->setRowClass(function ($user) {
return $user->id % 2 == 0 ? 'alert-success' : 'alert-warning';
})
```

## setRowAttr

Sets row attribute(s) via `closure`.

```php
->setRowAttr([
    'data-id' => function($user) {
        return 'row-' . $user->id;
    },
    'data-name' => function($user) {
        return 'row-' . $user->name;
    },
])
```

Sets row attribute(s) via `blade` string.

```php
->setRowAttr([
    'data-id' => 'row-{{$id}}',
    'data-name' => 'row-{{$name}}',
])
```

## noPaging

Disables paging:

```php
$this->noPaging() 
```

## noLengthChange

Disables length change:

```php
$this->noLengthChange() 
```

## noSorting

Disables sorting:

```php
$this->noSorting() 
```

## noOrdering

Disables sorting (alias):

```php
$this->noOrdering() 
```

## noSearching

Disables searching:

```php
$this->noSearching() 
```

## noInfo

Disables table informations:

```php
$this->noInfo() 
```

## locale

Sets different locale to use with generic buttons:

```php
$this->locale([
    'deleteConfirm' => 'Delete the article?',
    'deleteSuccess' => 'Article has been successfully deleted',    
])
```

> Default locale can be found in the [`datatable.php`](https://github.com/sebastienheyd/boilerplate/blob/master/src/resources/lang/en/datatable.php) lang file.