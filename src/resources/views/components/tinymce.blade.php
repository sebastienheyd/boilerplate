<textarea id="{{ $id }}"{!! !empty($attributes) ? ' '.$attributes : '' !!}></textarea>
@if($hasMediaManager)
@include('boilerplate-media-manager::load.tinymce')
@else
@include('boilerplate::load.tinymce')
@endif
@push('js')
    <script>$(function(){$('#{{ $id }}').tinymce({})});</script>
@endpush