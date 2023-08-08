<div class="dashboard-widget @foreach($width as $size => $col) @if($size === 'sm') col-{{ $col }} @else col-{{ $size }}-{{ $col }} @endif @endforeach()">
{{--<div class="dashboard-widget-tools d-flex flex-column justify-content-between">
    <div class="d-flex justify-content-between">
        <i class="fa fa-solid fa-square-plus" data-action="add-before"></i>
        <i class="fa fa-solid fa-square-plus" data-action="add-after"></i>
    </div>
    <div class="d-flex justify-content-center">
        <i class="fa-solid fa-trash-can" data-action="remove"></i>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <span>
            <i class="fa-solid fa-square-caret-left" data-action="move-left"></i>
            <i class="fa-solid fa-square-caret-right" data-action="move-right"></i>
        </span>
        <span><i class="fa-solid fa-share fa-rotate-180" data-action="new-line"></i></span>
    </div>
</div>--}}
    {!! $content !!}
</div>