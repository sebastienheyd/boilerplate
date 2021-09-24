@if(empty($name))
<code>&lt;x-boilerplate::tinymce>The name attribute has not been set</code>
@else
<textarea id="{{ $id }}"{!! !empty($attributes) ? ' '.$attributes : '' !!} style="visibility:hidden">{!! $value ?? $slot ?? '' !!}</textarea>
@if($hasMediaManager)
@include('boilerplate-media-manager::load.tinymce')
@else
@include('boilerplate::load.tinymce')
@endif
@push('js')<script>$(function(){$('#{{ $id }}').tinymce({})});</script>@endpush()
@endif