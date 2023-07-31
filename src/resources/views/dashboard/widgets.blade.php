@foreach($widgets as $widget)
    @if($widget->permission === null || Auth::user()->ability('admin', $widget->permission))

    @endif()
@endforeach