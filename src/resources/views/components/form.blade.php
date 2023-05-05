@if($method === 'GET')
<form method="GET" action="{{ $route }}"{!! empty($attributes) ? '' : ' '.$attributes !!}>
@else
<form method="POST" action="{{ $route }}"{!! empty($attributes) ? '' : ' '.$attributes !!}{!! $files ? ' enctype="multipart/form-data"' : '' !!}>
@csrf()
@if($method !== 'POST')
    <input type="hidden" name="_method" value="{{ $method }}">
@endif
@endif
{{ $slot }}
</form>