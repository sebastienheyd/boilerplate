@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.profile.title'),
    'subtitle' => $user->name,
    'breadcrumb' => [
        $user->name => 'boilerplate.user.profile',
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.user.profile'])
        <div class="row">
            <div class="col-12 mb-3">
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('boilerplate::users.save')
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-5 col-xxl-5">
                @component('boilerplate::card', ['title' => __('boilerplate::users.profile.title')])
                    <div class="d-flex flex-wrap">
                        <div id="avatar-wrapper" class="mb-3">
                            @include('boilerplate::users.avatar')
                        </div>
                        <div class="pl-3">
                            <span class="info-box-text">
                                <p class="mb-0"><strong class="h3">{{ $user->name  }}</strong></p>
                                <p class="">{{ $user->getRolesList() }}</p>
                            </span>
                            <span class="info-box-more">
                                <p class="text-muted">
                                    <span class="far fa-fw fa-envelope"></span> {{ $user->email }}
                                </p>
                                <p class="mb-0 text-muted">
                                    {{ __('boilerplate::users.profile.subscribedsince', [
                                        'date' => $user->created_at->isoFormat(__('boilerplate::date.lFdY')),
                                        'since' => $user->created_at->diffForHumans()]) }}
                                </p>
                            </span>
                        </div>
                    </div>
                @endcomponent
            </div>
            <div class="col-12 col-xl-7 col-xxl-7">
                @component('boilerplate::card', ['color' => 'teal', 'title' => __('boilerplate::users.informations')])
                    <div class="row">
                        <div class="col-md-6">
                            @component('boilerplate::input', ['name' => 'first_name', 'label' => 'boilerplate::users.firstname', 'value' => $user->first_name, 'autofocus' => true])@endcomponent
                        </div>
                        <div class="col-md-6">
                            @component('boilerplate::input', ['name' => 'last_name', 'label' => 'boilerplate::users.lastname', 'value' => $user->last_name])@endcomponent
                        </div>
                        <div class="col-md-6">
                            @component('boilerplate::password', ['name' => 'password', 'label' => ucfirst(__('boilerplate::auth.fields.password'))])@endcomponent
                        </div>
                        <div class="col-md-6">
                            @component('boilerplate::password', ['name' => 'password_confirmation', 'label' => ucfirst(__('boilerplate::auth.fields.password_confirm')), 'check' => false])@endcomponent
                        </div>
                        {{-- Disconnect other devices toggle: visible only when keepalive + database session driver --}}
                        @if(config('boilerplate.app.keepalive') && config('session.driver') === 'database')
                        <div class="col-12">
                            @component('boilerplate::icheck', ['name' => 'disconnect_devices', 'id' => 'disconnect_devices', 'label' => 'boilerplate::users.profile.disconnect_devices_toggle', 'checked' => false])@endcomponent
                        </div>
                        @endif
                    </div>
                @endcomponent
                {{-- Active sessions card: visible only when keepalive + database session driver --}}
                @if(config('boilerplate.app.keepalive') && config('session.driver') === 'database')
                @component('boilerplate::card', [
                    'color'   => 'warning',
                    'outline' => true,
                    'title'   => 'boilerplate::users.profile.sessions_title',
                    'tools'   => '<button type="button" class="btn btn-sm btn-outline-secondary" id="disconnect-all-btn" style="display:none">
                        <i class="fas fa-fw fa-right-from-bracket"></i> '.e(__('boilerplate::users.profile.disconnect_devices')).'
                    </button>',
                ])
                    <div id="sessions-list" class="text-muted text-center py-2">
                        <i class="fas fa-spinner fa-spin"></i> @lang('boilerplate::users.profile.sessions_loading')
                    </div>
                @endcomponent
                @endif
            </div>
        </div>
    @endcomponent
@endsection

@push('js')
    <script>
        @if(config('boilerplate.app.keepalive') && config('session.driver') === 'database')
        var sessionsLocales = {
            current:          "@lang('boilerplate::users.profile.sessions_current')",
            disconnect:       "@lang('boilerplate::users.profile.sessions_disconnect')",
            disconnectConfirm:"@lang('boilerplate::users.profile.disconnect_devices_confirm')",
            disconnectSuccess:"@lang('boilerplate::users.profile.disconnect_devices_success')",
            disconnectError:  "@lang('boilerplate::users.profile.disconnect_devices_error')",
            noOtherSessions:  "@lang('boilerplate::users.profile.sessions_no_other')",
        };

        // Build one table row for a session
        function renderSession(session) {
            var isCurrent = session.is_current;
            var action = isCurrent
                ? '<span class="badge badge-success">' + sessionsLocales.current + '</span>'
                : '<button type="button" class="btn btn-sm btn-outline-secondary disconnect-session-btn" data-id="' + session.id + '">'
                  + '<i class="fas fa-fw fa-right-from-bracket"></i>'
                  + '</button>';

            return '<tr>'
                + '<td class="text-center text-muted"><i class="fas ' + session.icon + ' fa-fw"></i></td>'
                + '<td>' + session.browser + '</td>'
                + '<td>' + session.os + '</td>'
                + '<td class="text-monospace">' + session.ip_address + '</td>'
                + '<td class="text-nowrap">' + session.last_activity + '</td>'
                + '<td class="text-right">' + action + '</td>'
                + '</tr>';
        }

        // Load sessions list
        function loadSessions() {
            $.ajax({
                url: "{{ route('boilerplate.user.sessions', null, false) }}",
                type: 'get',
                success: function(data) {
                    if (!data.success) return;

                    var hasOthers = data.sessions.filter(function(s) { return !s.is_current; }).length > 0;
                    $('#disconnect-all-btn').toggle(hasOthers);

                    if (data.sessions.length === 0) {
                        $('#sessions-list').html('<p class="text-muted text-center py-3 mb-0">' + sessionsLocales.noOtherSessions + '</p>');
                        return;
                    }

                    var rows = '';
                    data.sessions.forEach(function(session) { rows += renderSession(session); });
                    $('#sessions-list').html(
                        '<div class="table-responsive">'
                        + '<table class="table table-striped table-hover mb-0">'
                        + '<tbody>' + rows + '</tbody>'
                        + '</table>'
                        + '</div>'
                    );
                }
            });
        }

        loadSessions();

        // Disconnect a single session
        $(document).on('click', '.disconnect-session-btn', function() {
            var btn = $(this);
            var sessionId = btn.data('id');
            bootbox.confirm(sessionsLocales.disconnectConfirm, function(res) {
                if (res === false) return;
                btn.prop('disabled', true);
                $.ajax({
                    url: "{{ route('boilerplate.user.session.disconnect', ['sessionId' => '__ID__'], false) }}".replace('__ID__', sessionId),
                    type: 'post',
                    data: {_method: 'DELETE'},
                    success: function(data) {
                        if (data.success) {
                            growl(sessionsLocales.disconnectSuccess, 'success');
                            loadSessions();
                        } else {
                            btn.prop('disabled', false);
                            growl(sessionsLocales.disconnectError, 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false);
                        growl(sessionsLocales.disconnectError, 'error');
                    }
                });
            });
        });

        // Disconnect all other sessions
        $('#disconnect-all-btn').on('click', function() {
            var btn = $(this);
            bootbox.confirm(sessionsLocales.disconnectConfirm, function(res) {
                if (res === false) return;
                btn.prop('disabled', true);
                $.ajax({
                    url: "{{ route('boilerplate.user.disconnect-devices', null, false) }}",
                    type: 'post',
                    success: function(data) {
                        btn.prop('disabled', false);
                        if (data.success) {
                            growl(sessionsLocales.disconnectSuccess, 'success');
                            loadSessions();
                        } else {
                            growl(sessionsLocales.disconnectError, 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false);
                        growl(sessionsLocales.disconnectError, 'error');
                    }
                });
            });
        });
        @endif

        var avatar = {
            url: "{{ route('boilerplate.user.avatar.url', null, false) }}",
            locales: {
                delete: "@lang('boilerplate::avatar.delete')",
                gravatar: {
                    success: "@lang('boilerplate::avatar.gravatar.success')",
                    error: "@lang('boilerplate::avatar.gravatar.error')",
                },
                upload: {
                    success: "@lang('boilerplate::avatar.upload.success')",
                    error: "@lang('boilerplate::avatar.upload.error')",
                }
            }
        }
    </script>
    <script src="{{ mix('/avatar.min.js', '/assets/vendor/boilerplate') }}"></script>
@endpush