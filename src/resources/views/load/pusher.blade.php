@once
<script src="{{ mix('/plugins/pusher/pusher.min.js', '/assets/vendor/boilerplate') }}"></script>
@component('boilerplate::minify')
<script>
    window.pshr = (new Pusher('{{ config('broadcasting.connections.pusher.key', false) }}', {cluster: '{{ config('broadcasting.connections.pusher.options.cluster', 'eu') }}'})).subscribe('{{ md5(config('app.name').config('app.env')) }}');
</script>
@endcomponent
@endonce