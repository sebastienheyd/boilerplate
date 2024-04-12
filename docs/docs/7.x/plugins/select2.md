# Select2

Select2 gives you a customizable select box with support for searching, tagging, remote data sets, infinite scrolling, and many other highly used options.

> [https://select2.org](https://select2.org)

<img :src="$withBase('/assets/img/select2.png')" alt="Select2">

## Component

A Laravel Blade Component is available for select2, see the [component documentation](../components/select2)

## Usage

To use select2 you can use the loading view [`boilerplate::load.select2`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/select2.blade.php)

> When loaded, select2 will use the locale defined in [config/app.php](../configuration/app#locale)

You can find an example of use here : [select2.blade.php](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/plugins/demo/select2.blade.php)

```html
@section('content')
<select class="select2">
    <option selected="selected">Alabama</option>
    <option>Alaska</option>
    <option>California</option>
</select>
@endsection

@include('boilerplate::load.select2')

@push('js')
<script>
    $(function() {
        $(".select2").select2();
    });
</script>
@endpush
```