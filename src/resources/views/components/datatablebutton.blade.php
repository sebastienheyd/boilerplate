@if($button === 'refresh')
{className: 'btn-sm', text: '<span class="fa fa-fw fa-sync-alt"></span>', action: ( e, dt ) => { dt.ajax.reload() } },
@elseif($button === 'filters')
{className: 'btn-sm show-filters', text:'<span class="fa fa-fw fa-filter"></span><span class="fa fa-caret-down"></span>'},
@else
{className: 'btn-sm', extend: '{{ $button }}', text:'<span class="fa fa-fw fa-{{ $icons[$button] ?? $button }}"></span>'},
@endif