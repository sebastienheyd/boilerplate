@component('boilerplate::minify')
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
    var session={
        login:"{!! route('boilerplate.login') . '?expired=1&path='.request()->path() !!}",
        @if(config('boilerplate.app.keepalive', false))
        keepalive:"{{ route('boilerplate.session.keepalive', null, false) }}",
        @else
        warning:"@lang('boilerplate::auth.session.warning')",
        @endif
        expire:{{ time() +  config('session.lifetime') * 60 }},
        lifetime:{{ config('session.lifetime') * 60 }},
        id:"{{ session()->getId() }}"
    };
</script>
@endcomponent