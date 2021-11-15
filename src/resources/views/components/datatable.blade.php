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
            <tr class="filters">
                @foreach($datatable->columns() as $k => $column)
                    <th>
                        @if($column->searchable !== false)
                            <x-boilerplate::input name="filter" groupClass="mb-0" class="form-control-sm" />
                        @endif
                    </th>
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
                processing: false,
                serverSide: true,
                autoWidth: false,
                searching: true,
                orderCellsTop: true,
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
                    type: 'post',
                    data: function data(d) {
                        $('#{{ $id }}_wrapper .dt-search-facet').each(function (i, e) {
                            d.columns[$(e).data('field')].search.value = $(e).data('value');
                        });
                    }
                },
                columns: [
                    @foreach($datatable->columns() as $column)
                        {!! $column->get() !!},
                    @endforeach
                ],
                initComplete: function() {
                    {{--$.ajax({--}}
                    {{--    url: '{!! route('boilerplate.datatables.search', $datatable->slug, false) !!}',--}}
                    {{--    type: 'post',--}}
                    {{--    success: function(html){--}}
                    {{--        $('#{{ $id }}_wrapper .row:first div:last').html(html);--}}
                    {{--    }--}}
                    {{--});--}}
                }
            });
        });
    </script>
    @endcomponent
@endif