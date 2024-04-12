# Datetimepicker

Tempus Dominus is the successor to the very popular Eonasdan/bootstrap-datetimepicker. The plugin provide a robust date and time picker designed to integrate into your Bootstrap project. 

> [https://tempusdominus.github.io/bootstrap-4](https://tempusdominus.github.io/bootstrap-4/)

<img :src="$withBase('/assets/img/datetimepicker.png')" alt="Datetimepicker">

## Usage

To use date picker you can use the loading view [`boilerplate::load.datetimepicker`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/datetimepicker.blade.php)

You can find an example of use here : [datetimepicker.blade.php](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/plugins/demo/datetimepicker.blade.php)

```html
@section('content')
<input type="text" class="datepicker">
<input type="text" class="datetimepicker">
@endsection

@include('boilerplate::load.datetimepicker')

@push('js')
    <script>
        $('.datepicker').datetimepicker({ format: "L" });
        $('.datetimepicker').datetimepicker();
    </script>
@endpush
```