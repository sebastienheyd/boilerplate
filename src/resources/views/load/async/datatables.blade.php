@once
@component('boilerplate::minify')
    @include('boilerplate::load.async.moment')
    <script>
        loadStylesheet('{!! mix('/plugins/datatables/datatables.min.css', '/assets/vendor/boilerplate') !!}');
        whenAssetIsLoaded('momentjs', () => {
            loadScript('{!! mix('/plugins/datatables/datatables.min.js', '/assets/vendor/boilerplate') !!}', () => {
                {{-- Plugins --}}
                @foreach($plugins as $plugin)
                    @if($$plugin ?? false)
                        loadStylesheet('{!! mix('/plugins/datatables/plugins/'.$plugin.'.bootstrap4.min.css', '/assets/vendor/boilerplate') !!}');
                        loadScript('{!! mix('/plugins/datatables/plugins/dataTables.'.$plugin.'.min.js', '/assets/vendor/boilerplate') !!}', () => {
                            loadScript('{!! mix('/plugins/datatables/plugins/'.$plugin.'.bootstrap4.min.js', '/assets/vendor/boilerplate') !!}', () => {
                            @if($plugin === 'buttons')
                                loadScript('{!! mix('/plugins/datatables/buttons.min.js', '/assets/vendor/boilerplate') !!}', () => {
                            @endif
                    @endif
                @endforeach
                registerAsset('datatables', () => {
                    $.extend(true, $.fn.dataTable.defaults, {
                        autoWidth: false,
                        language: {
                            url: "{!! mix('/plugins/datatables/i18n/'.$locale.'.json', '/assets/vendor/boilerplate') !!}"
                        },
                    });
                });
                @foreach($plugins as $plugin)
                    @if($$plugin ?? false)
                        @if($plugin === 'buttons')
                                });
                        @endif
                            });
                        });
                    @endif
                @endforeach
            });
        });
    </script>
@endcomponent
@endonce


