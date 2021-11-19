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
                @if($datatable->checkboxes)
                    <th>
                        @php($cbid = uniqid('checkbox_'))
                        <div class="icheck-primary mb-0 mt-0">
                            <input type="checkbox" name="dt-check-all" id="{{ $cbid }}" autocomplete="off">
                            <label for="{{ $cbid }}"></label>
                        </div>
                    </th>
                @endif
                @foreach($datatable->columns() as $column)
                    <th>{{ $column->title }}</th>
                @endforeach
            </tr>
            @if($datatable->filters)
            <tr class="filters" style="display:none">
                @foreach($datatable->getColumns() as $k => $column)
                    <th>
                        @if($column->searchable === false)
                            @continue
                        @endif
                        @if(!empty($column->filterOptions))
                            @component('boilerplate::select2', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'form-control-sm dt-filter-select', 'options' => $column->filterOptions, 'data-field' => "$k", 'allowClear' => true])@endcomponent
                        @elseif(!empty($column->render))
                            @component('boilerplate::daterangepicker', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'dt-filter-daterange form-control-sm', 'data-field' => "$k"])@endcomponent
                        @else
                            @component('boilerplate::input', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'dt-filter-text form-control-sm', 'data-field' => "$k"])@endcomponent
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
            window.{{ \Str::camel($id) }} = $('#{{ $id }}').on('processing.dt', $.fn.dataTable.customProcessing).DataTable({
                processing: false,
                serverSide: true,
                autoWidth: false,
                orderCellsTop: true,
                info: {{ (int) $datatable->info }},
                searching: {{ (int) $datatable->searching }},
                ordering: {{ (int) $datatable->ordering }},
                @if($datatable->ordering)
                    order: {!! $datatable->order !!},
                @endif
                paging: {{ (int) $datatable->paging }},
                @if($datatable->paging)
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
                    data: $.fn.dataTable.parseDatatableFilters,
                    complete: () => {
                        $('#{{ $id }} [name=dt-check-all]').prop('checked', false);
                    }
                },
                columns: [
                    @foreach($datatable->getColumns() as $column)
                        {!! $column->get() !!},
                    @endforeach
                ],
                @if($datatable->filters)
                    initComplete: () => {
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