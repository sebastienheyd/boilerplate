@if(empty($name))
    <code>
        &lt;x-boilerplate::datatable>
        The name attribute has not been set
    </code>
@else
    <div class="table-responsive">
        <table class="table table-striped table-hover va-middle w-100" id="{{ $id }}" data-options="{{ route('boilerplate.datatables.options', $datatable->slug, false) }}">
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
                searching: 0,
                info: {{ (int) $datatable->info }},
                lengthChange: {{ (int) $datatable->lengthChange }},
                lengthMenu: {!! $datatable->lengthMenu !!},
                order: {!! $datatable->order !!},
                ordering: {{ (int) $datatable->ordering }},
                pageLength: {{ $datatable->pageLength }},
                paging: {{ (int) $datatable->paging }},
                pagingType: '{{ $datatable->pagingType }}',
                stateSave: {{ (int) $datatable->stateSave }},
                ajax: {
                    url: '{!! route('boilerplate.datatables', $datatable->slug, false) !!}',
                    type: 'post'
                },
                columns: [
                    @foreach($datatable->columns() as $column)
                        {!! $column->get() !!},
                    @endforeach
                ],
                fnInitComplete: function() {
                    $.fn.dataTable.initSearch('{{ $id }}')
                }
            });
        });
    </script>
    @endcomponent
@endif