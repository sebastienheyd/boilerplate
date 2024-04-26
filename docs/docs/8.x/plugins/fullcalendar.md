# FullCalendar

A full-sized drag & drop JavaScript event calendar

> [https://fullcalendar.io](https://fullcalendar.io)

<img :src="$withBase('/assets/img/fullcalendar.png')" alt="FullCalendar" style="max-width:500px">

## Loading

To use FullCalendar on your page you can use the loading view [`boilerplate::load.fullcalendar`](https://github.com/sebastienheyd/boilerplate/blob/823362552694320095dfdc5de69d190f7c159505/src/resources/views/load/fullcalendar.blade.php)

```html
@include('boilerplate::load.fullcalendar')
```

## Usage

You can see an example of use in [fullcalendar.blade.php](https://github.com/sebastienheyd/boilerplate/blob/823362552694320095dfdc5de69d190f7c159505/src/resources/views/plugins/demo/fullcalendar.blade.php)

```html
@section('content')
<div id="calendar"></div>
@endsection

@include('boilerplate::load.fullcalendar')

@push('js')
    var calendar = $('#calendar').fullCalendar({
        buttonIcons: false
    })
@endpush
```