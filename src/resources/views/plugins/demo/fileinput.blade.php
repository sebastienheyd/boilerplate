@include('boilerplate::load.fileinput')

@component('boilerplate::card', ['color' => 'info', 'title' => 'Fileinput'])
    @slot('tools')
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
    @endslot
    <input id="files" name="files" type="file" class="file" multiple data-browse-on-zone-click="true">
    @slot('footer')
        <div class="text-muted small text-right">
            <a href="https://plugins.krajee.com/file-input" target="_blank">bootstrap-fileinput</a>
        </div>
    @endslot
@endcomponent
