<div class="dashboard-widget col-{{ $width ?? 3 }}">
    <div class="dashboard-widget-tools d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between">
            <i class="fa fa-solid fa-square-plus"></i>
            <i class="fa fa-solid fa-square-plus"></i>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <span>
                <i class="fa-solid fa-angle-left"></i>
                <i class="fa-solid fa-angle-right"></i>
            </span>
            <span>↲</span>
        </div>
    </div>
    {!! $content !!}
</div>