@if(!defined('LOAD_SELECT2'))

    @push('js')
        <script src="{!! asset('/mix/plugins/select2/select2.full.min.js') !!}"></script>
        <script src="{!! asset('/mix/plugins/select2/i18n/fr.js') !!}"></script>
    @endpush

    <?php define('LOAD_SELECT2', true)  ?>
@endif