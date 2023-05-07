<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @stack('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/fontawesome/fontawesome.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    @stack('css')
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    @component('boilerplate::minify')
        <script>
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
            bootbox.setLocale('{{ App::getLocale() }}');
            var session={
                keepalive:"{{ route('boilerplate.keepalive', null, false) }}",
                expire:{{ time() +  config('session.lifetime') * 60 }},
                lifetime:{{ config('session.lifetime') * 60 }},
                id:"{{ session()->getId() }}"
            };
        </script>
        <style>
            #disable {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1000;
                background: rgba(0,0,0,.8);
            }

            #loading {
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1001;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        </style>
    @endcomponent
    @stack('plugin-js')
</head>
<body class="sidebar-mini{{ setting('darkmode', false) && config('boilerplate.theme.darkmode') ? ' dark-mode accent-light' : '' }}">
    <div id="disable" style="display: none"></div>
    <div id="loading" style="display: none">
        <div class="text-center">
            <span class="fa fa-4x fa-cog fa-spin mb-2"></span>
            <p>@lang('boilerplate::gpt.generation')</p>
        </div>
    </div>
    @component('boilerplate::form', ['route' => 'boilerplate.gpt.process'])
    <div class="container-fluid pt-2">
        <div id="gpt-form">
            @include('boilerplate::gpt.form')
        </div>
        <div class="row">
            <div class="col-12 pt-2 text-center">
                <button type="submit" class="btn btn-primary">@lang('boilerplate::gpt.form.submit')</button>
            </div>
        </div>
    </div>
    @endcomponent
    @component('boilerplate::minify')
    <script>
        $(function() {
            $('[name="topic"]').focus();

            $(document).on('click', 'button[type="submit"]', function(e) {
                e.preventDefault();

                $('#gpterror').remove();
                $('#disable, #loading').show();

                $.ajax({
                    url: '{{ route('boilerplate.gpt.process') }}',
                    type: 'post',
                    data: $('form').serialize(),
                    success: function(json){
                        if(json.success === false) {
                            $('#disable, #loading').hide();
                            $('#gpt-form').html(json.html);
                            $('[name="topic"]').focus();
                        } else {
                            $('#disable, #loading').hide();
                            window.parent.postMessage({
                                mceAction: 'confirmGPTContent',
                                content: json.content
                            }, '*');
                        }
                    },
                    error: function() {
                        $('#disable, #loading').hide();
                        $('#gpt-form').append('<div class="alert alert-danger" id="gpterror">@lang('boilerplate::gpt.error')</div>');
                    }
                });
            })
        });
    </script>
    @endcomponent
@stack('js')
</body>