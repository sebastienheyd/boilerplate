@if(empty($name))
<code>&lt;x-boilerplate::codemirror> The name attribute has not been set</code>
@else
<textarea id="{{ $id }}" name="{{ $name }}" style="visibility:hidden">{!! $value ?? $slot ?? '' !!}</textarea>
@include('boilerplate::load.codemirror', ['theme' => $theme])
@push('js')
    <script>$(function(){$('#{{ $id }}').codemirror({ {!! $options ?? '' !!} })});</script>
@endpush
@endif