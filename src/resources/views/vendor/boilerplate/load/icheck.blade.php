@if(!defined('LOAD_ICHECK'))
    @push('css')
        <link rel="stylesheet" href="{!! asset('/js/plugins/iCheck/all.css') !!}">
    @endpush

    @push('js')
        <script src="{!! asset('/js/plugins/iCheck/icheck.min.js') !!}"></script>
        <script>
            $(function(){
                $('input[type="checkbox"].icheck, input[type="radio"].icheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue'
                });

                var skins = ['minimal', 'square', 'flat']
                var colors = ['black', 'red', 'green', 'blue', 'aero', 'grey', 'orange', 'yellow', 'pink', 'purple'];

                $(skins).each(function(i, skin){
                    $(colors).each(function(ii,color){
                        $('input[type="checkbox"].icheck.'+skin+'.'+color+', input[type="radio"].icheck.'+skin+'.'+color).iCheck({
                            checkboxClass: 'icheckbox_'+skin+'-'+color,
                            radioClass: 'iradio_'+skin+'-'+color
                        });
                    });
                });
            });
        </script>
    @endpush

    @php define('LOAD_ICHECK', true) @endphp
@endif