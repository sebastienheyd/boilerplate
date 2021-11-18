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
            @if($datatable->filters)
            <tr class="filters" style="display:none">
                @foreach($datatable->columns() as $k => $column)
                    <th>
                        @if($column->searchable === false)
                            @continue
                        @endif
                        @if(!empty($column->filterOptions))
                            <x-boilerplate::select2 name="filter[{{ $k }}]" groupClass="mb-0" class="form-control-sm dt-filter-select" :options="$column->filterOptions" data-field="{{ $k }}" :allowClear="true"/>
                        @elseif(!empty($column->render))
                            <x-boilerplate::daterangepicker name="filter[{{ $k }}]" groupClass="mb-0" class="dt-filter-daterange form-control-sm" data-field="{{ $k }}" />
                        @else
                            <x-boilerplate::input name="filter[{{ $k }}]" groupClass="mb-0" class="dt-filter-text form-control-sm" data-field="{{ $k }}" />
                        @endif
                    </th>
                @endforeach
            </tr>
            @endif
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
                orderCellsTop: true,
                info: {{ (int) $datatable->info }},
                searching: {{ (int) $datatable->searching }},
                @if($datatable->ordering)
                    ordering: true,
                    order: {!! $datatable->order !!},
                @endif
                @if($datatable->paging)
                    paging: true,
                    pageLength: {{ $datatable->pageLength }},
                    pagingType: '{{ $datatable->pagingType }}',
                    lengthChange: {{ (int) $datatable->lengthChange }},
                    lengthMenu: {!! $datatable->lengthMenu !!},
                @endif
                @if($datatable->stateSave)
                    stateSave: true,
                    stateSaveParams: $.fn.dataTable.saveFiltersState,
                    stateLoadParams: $.fn.dataTable.loadFiltersState,
                @endif
                ajax: {
                    url: '{!! route('boilerplate.datatables', $datatable->slug, false) !!}',
                    type: 'post',
                    data: $.fn.dataTable.parseDatatableFilters
                },
                columns: [
                    @foreach($datatable->columns() as $column)
                        {!! $column->get() !!},
                    @endforeach
                ],
                @if($datatable->filters)
                    initComplete: function() {
                        $('#{{ $id }}_filter').append(
                            '<button type="button" class="btn btn-sm btn-default mb-1 ml-1 show-filters"><span class="fa fa-fw fa-caret-down"></span></button>'
                        );
                        registerAsset('{{ $id }}');
                    }
                @endif
            });
        });
    </script>
    @endcomponent
@endif