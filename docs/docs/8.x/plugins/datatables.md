# DataTables

DataTables is a plugin to convert html tables into dynamic tables, allowing fast search, sorting, pagination, etc.

> [https://datatables.net/](https://datatables.net/)

<img :src="$withBase('/assets/img/datatables.png')" alt="DataTables">

## Loading

To use DataTables on your page you can use the loading view [`boilerplate::load.datatables`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/datatables.blade.php)

```html
@include('boilerplate::load.datatables')
```

You can load plugins by passing their names to the loader :

```html
@include('boilerplate::load.datatables', ['fixedHeader' => true])
```

The available plugins are :

* [autoFill](https://datatables.net/extensions/autofill/)
* [buttons](https://datatables.net/extensions/buttons/)
* [colReorder](https://datatables.net/extensions/colreorder/)
* [fixedHeader](https://datatables.net/extensions/fixedheader/)
* [keyTable](https://datatables.net/extensions/keytable/)
* [responsive](https://datatables.net/extensions/responsive/)
* [rowGroup](https://datatables.net/extensions/rowgroup/)
* [rowReorder](https://datatables.net/extensions/rowreorder/)
* [scroller](https://datatables.net/extensions/rowreorder/)
* [searchBuilder](https://datatables.net/extensions/searchbuilder/)
* [searchPanes](https://datatables.net/extensions/searchpanes/)
* [select](https://datatables.net/extensions/select/)

## API

Boilerplate is delivered with the excellent package [`yajra/laravel-datatables`](https://packagist.org/packages/yajra/laravel-datatables-oracle) to load data in controllers via ajax.

> [https://yajrabox.com/docs/laravel-datatables](https://yajrabox.com/docs/laravel-datatables)

## Usage

You can see an example of use in [UsersController](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/Controllers/Users/UsersController.php#L59) and [list.blade.php](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/users/list.blade.php#L74)

```html
@include('boilerplate::load.datatables')
@push('js')
    <script>
        $('#dt').dataTable();
    </script>
@endpush
```