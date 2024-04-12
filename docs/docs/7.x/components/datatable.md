# DataTable

::: warning IMPORTANT
Boilerplate version >= 7.10
:::

```html
<x-boilerplate::datatable name="users" />
```

Will render

<img :src="$withBase('/assets/img/datatable.jpg')" alt="DataTable" style="max-width: 700px">

## How to create a DataTable

[See the dedicated documentation](../datatables/create)

## Laravel 6

Laravel 6 does not support Blade x components, but you can use the `@component` directive instead :

```html
@component('boilerplate::datatable', ['name' => 'users']) @endcomponent
```