<script src="{{ mix('/pusher.min.js', '/assets/vendor/boilerplate') }}"></script>
@component('boilerplate::minify')
<script>
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ config('broadcasting.connections.pusher.key') }}',
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: true
    });
</script>
@endcomponent