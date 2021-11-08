@if(empty($name))
    <code>
        &lt;x-boilerplate::datatable>
        The name attribute has not been set
    </code>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover va-middle w-100" id="{{ $id }}">
            <thead>
            <tr>
                @foreach($datatable->columns() as $column)
                    <th>{{ $column->title }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    @include('boilerplate::load.async.datatables')
    @component('boilerplate::minify')
    <script>
        whenAssetIsLoaded('datatables', function() {
            window.{{ \Str::camel($id) }} = $('#{{ $id }}').DataTable({
                processing: 1,
                serverSide: 1,
                autoWidth: 0,
                stateSave: {{ (int) $datatable->stateSave }},
                paging: {{ (int) $datatable->paging }},
                pageLength: {{ $datatable->pageLength }},
                lengthChange: {{ (int) $datatable->lengthChange }},
                ordering: {{ (int) $datatable->ordering }},
                searching: {{ (int) $datatable->searching }},
                info: {{ (int) $datatable->info }},
                ajax: {
                    url: '{!! route('boilerplate.datatables', $datatable->slug) !!}',
                    type: 'post'
                },
                columns: [
                    @foreach($datatable->columns() as $column)
                        {!! $column->get() !!},
                    @endforeach
                ]
            });
        });
    </script>
    @endcomponent
@endif