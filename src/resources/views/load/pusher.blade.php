<script src="{{ mix('/pusher.min.js', '/assets/vendor/boilerplate') }}"></script>
@component('boilerplate::minify')
<script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        authEndpoint: '{{ route('boilerplate.pusher.auth', [], false) }}',
        key: '{{ config('broadcasting.connections.pusher.key') }}',
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: true
    });
    window.channel = Echo.private('{{ md5(config('app.name').config('app.env')) }}');
</script>
@endcomponent