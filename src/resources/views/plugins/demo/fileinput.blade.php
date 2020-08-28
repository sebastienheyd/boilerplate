@include('boilerplate::load.fileinput')

@push('js')
    <script>
        $('#files').fileinput()
    </script>
@endpush

@component('boilerplate::card', ['color' => 'primary', 'title' => 'Fileinput'])
    @slot('tools')
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
    @endslot
    Usage :
    <pre>
&commat;include('boilerplate::load.fileinput')
&commat;push('js')
    &lt;script>
        $('#files').fileinput()
    &lt;/script>
&commat;endpush</pre>
    <input id="files" name="files" type="file" class="file" multiple>
    @slot('footer')
        <div class="text-muted small text-right">
            <a href="https://plugins.krajee.com/file-input" target="_blank">bootstrap-fileinput</a>
        </div>
    @endslot
@endcomponent
