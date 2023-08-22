<x-boilerplate::form method="post" route="boilerplate.dashboard.update-widget">
    <input type="hidden" name="widget-slug" value="{{ $widget->slug }}" />
    <div id="widget-edition-form">
        {!! $widget->renderEdit($params ?? []) !!}
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-outline-secondary mr-3" data-action="undo-update">@lang('boilerplate::dashboard.cancel')</button>
        <button type="submit" class="btn btn-primary" data-action="update-widget">@lang('boilerplate::dashboard.update')</button>
    </div>
</x-boilerplate::form>