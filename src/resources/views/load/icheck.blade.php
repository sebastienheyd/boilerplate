@if(!defined('LOAD_ICHECK'))
    @push('css')
        <link rel="stylesheet" href="{!! asset('/mix/plugins/iCheck/square/blue.css') !!}">
    @endpush

    @push('js')
        <script src="{!! asset('/mix/plugins/iCheck/icheck.min.js') !!}"></script>
        <script>
            $(function(){
                $('input[type="checkbox"].icheck, input[type="radio"].icheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue'
                });
            });
        </script>
    @endpush

    <?php define('LOAD_ICHECK', true)  ?>
@endif