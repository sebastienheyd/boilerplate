<ul data-facet="{{ route('boilerplate.datatables.facet', $slug, false) }}" data-id="{{ $id }}">
@foreach($searchable as $option => $label)
    <li><a href="#" data-option="{{ $option }}">Rechercher <strong>{{ $q }}</strong> dans <i>{{ $label }}</i></a></li>
@endforeach
</ul>