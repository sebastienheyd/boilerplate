<div class="dashboard-widget @foreach($width as $size => $col) @if($size === 'sm') col-{{ $col }} @else col-{{ $size }}-{{ $col }} @endif @endforeach()">
    {!! $content !!}
</div>