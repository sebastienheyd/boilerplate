<div class="dashboard-widget @foreach($widget->width as $size => $col) @if($size === 'sm') col-{{ $col }} @else col-{{ $size }}-{{ $col }} @endif @endforeach()" data-widget-name="{{ $widget->slug }}" data-widget-edit="{{ $widget->isEditable() ? 'yes' : 'no' }}" data-widget-parameters="{{ json_encode($widget->getSettings()) }}">
    {!! $widget->render() !!}
</div>