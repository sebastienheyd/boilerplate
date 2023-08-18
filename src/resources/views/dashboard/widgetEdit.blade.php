<x-boilerplate::form method="post" route="boilerplate.dashboard.update-widget">
    <input type="hidden" name="widget-slug" value="{{ $widget->slug }}" />
    {!! $widget->renderEdit($params ?? []) !!}
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-outline-secondary mr-3" data-action="undo-update">Annuler</button>
        <button type="submit" class="btn btn-primary" data-action="update-widget">Update</button>
    </div>
</x-boilerplate::form>