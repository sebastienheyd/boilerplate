@once
@if(config('broadcasting.default') === 'pusher')
@component('boilerplate::minify')
<script>
    loadScript("{{ mix('/pusher.min.js', '/assets/vendor/boilerplate') }}", function() {
        window.Echo = new Echo({
            broadcaster: 'pusher',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
@if(config('broadcasting.connections.pusher.options.host', false))
            wsHost: '{{ config('broadcasting.connections.pusher.options.host') }}',
            forceTLS: false,
            encrypted: true,
            enabledTransports: ['ws', 'wss'],
            disableStats: true,
@endif
@if(config('broadcasting.connections.pusher.options.port', false))
            wsPort: {{ config('broadcasting.connections.pusher.options.port') }},
@endif
@if(config('broadcasting.connections.pusher.options.wss_port', false))
            wssPort: {{ config('broadcasting.connections.pusher.options.wss_port') }},
@endif
        });
        registerAsset('echo');
    })
</script>
@endcomponent
@endif
@endonce