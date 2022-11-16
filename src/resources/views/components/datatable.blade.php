@if(empty($name))
<code>
    &lt;x-boilerplate::datatable>
    The name attribute has not been set
</code>
@elseif(! $permission)
<code>
    &lt;x-boilerplate::datatable>
    You don't have permission to access the table "{{ $name }}"
</code>
@else
<div class="table-responsive">
    <table class="table table-striped table-hover va-middle w-100{{ $datatable->condensed ? ' table-sm' : '' }}" id="{{ $id }}">
        <thead>
        <tr>
            @foreach($datatable->getColumns() as $column)
                <th>@if(!empty($column->tooltip))<span data-toggle="tooltip" title="{{ $column->tooltip }}">@endif{!! $column->title !!}@if(!empty($column->tooltip))</span>@endif</th>
            @endforeach
        </tr>
        @if(in_array('filters', $datatable->buttons))
        <tr class="filters" style="display:none">
            @foreach($datatable->getColumns() as $k => $column)
                <th>
                    @if($column->searchable === false)
                        @continue
                    @endif
                    @switch($column->filterType)
                        @case('select')
                            @component('boilerplate::select2', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'form-control-sm dt-filter-select', 'options' => $column->filterOptions, 'data-field' => "$k", 'allowClear' => true])@endcomponent
                        @break
                        @case('select-multiple')
                            @component('boilerplate::select2', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'form-control-sm dt-filter-select', 'options' => $column->filterOptions, 'data-field' => "$k", 'multiple' => true])@endcomponent
                        @break
                        @case('daterangepicker')
                            @component('boilerplate::daterangepicker', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'dt-filter-daterange', 'controlClass' => 'form-control-sm', 'data-field' => "$k", 'alignment' => 'center'])@endcomponent
                        @break
                        @default
                            @component('boilerplate::input', ['name' => "filter[$k]", 'groupClass' => 'mb-0', 'class' => 'dt-filter-text form-control-sm', 'data-field' => "$k", 'clearable' => true])@endcomponent
                        @break
                    @endswitch
                </th>
            @endforeach
        </tr>
        @endif
        </thead>
        <tbody></tbody>
    </table>
</div>
@include('boilerplate::load.async.datatables', ['buttons' => true])
@include('boilerplate::load.pusher')
@component('boilerplate::minify')
<script>
    whenAssetIsLoaded('datatables', function() {
        window.{{ $id }}_ajax = {!! json_encode($ajax) !!}
        window.{{ \Str::camel($id) }} = $('#{{ $id }}')
            .data('inst', '{{ \Str::camel($id) }}' )
            .on('processing.dt', $.fn.dataTable.customProcessing).DataTable({
            processing: false,
            serverSide: true,
            autoWidth: false,
            orderCellsTop: true,
            buttons: { buttons: [{!! $datatable->getButtons() !!}]},
            info: {{ (int) $datatable->info }},
            searching: {{ (int) $datatable->searching }},
            ordering: {{ (int) $datatable->ordering }},
            @if($datatable->ordering)
                order: {!! $datatable->order !!},
            @endif
            paging: {{ (int) $datatable->paging }},
            pageLength: {{ $datatable->pageLength }},
            @if($datatable->paging)
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
                complete: () => { $('#{{ $id }} [name=dt-check-all]').prop('checked', false) }
            },
            columns: [
                @foreach($datatable->getColumns() as $column)
                    {!! $column->get() !!},
                @endforeach
            ],
            initComplete: $.fn.dataTable.init,
            dom:
                "<'d-flex flex-wrap justify-content-between'<'dt_top_left mb-2 mr-2'l><'dt_top_right d-flex mb-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'d-flex flex-wrap align-items-center justify-content-between'<'dt_bottom_left mt-2'i><'dt_bottom_right mt-2'p>>",
        });

        window.{{ \Str::camel($id) }}.locale = {!! $datatable->getLocale() !!}
    });

    whenAssetIsLoaded('echo', () => {
        Echo.private('{{ channel_hash('dt', $name) }}')
            .listen('.RefreshDatatable', (res) => {
                if (res.name === '{{ $name }}') {
                    window.{{ \Str::camel($id) }}.draw('full-hold');
                }
            });
    });
</script>
@endcomponent
@endif