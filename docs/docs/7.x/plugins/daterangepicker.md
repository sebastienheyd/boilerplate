# Daterangepicker

Originally created for reports at Improvely, the Date Range Picker can be attached to any webpage element to pop up two calendars for selecting dates, times, or predefined ranges like "Last 30 Days".

> [https://www.daterangepicker.com](https://www.daterangepicker.com/)

<img :src="$withBase('/assets/img/daterange.png')" alt="Daterangepicker">

## Usage

To use date range picker you can use the loading view [`boilerplate::load.daterangepicker`](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/load/daterangepicker.blade.php)

You can find an example of use here : [daterangepicker.blade.php](https://github.com/sebastienheyd/boilerplate/blob/e1dc4b29920f011271a1a7ad682c3e82643180d9/src/resources/views/plugins/demo/daterangepicker.blade.php)

```html
@section('content')
<input type="text" class="daterangepicker">
@endsection

@include('boilerplate::load.daterangepicker')

@push('js')
    <script>
        $('.daterangepicker').daterangepicker();
    </script>
@endpush
```