@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.profile.title'),
    'subtitle' => $user->name,
    'breadcrumb' => [
        $user->name => 'boilerplate.user.profile',
    ]
])

@section('content')
    {{ Form::open(['route' => ['boilerplate.user.profile'], 'method' => 'post', 'autocomplete' => 'off', 'files' => true]) }}
        <div class="row">
            <div class="col-12 mb-3">
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::users.save') }}
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                @component('boilerplate::card', ['title' => __('boilerplate::users.profile.title')])
                    <div class="d-flex">
                        <div id="avatar-wrapper">
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
            <div class="col-md-7">
                @component('boilerplate::card', ['color' => 'teal', 'title' => __('boilerplate::users.informations')])
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                {{ Form::label('first_name', __('boilerplate::users.firstname')) }}
                                {{ Form::text('first_name', old('first_name', $user->first_name), ['class' => 'form-control'.$errors->first('first_name', ' is-invalid')]) }}
                                {!! $errors->first('first_name','<div class="error-bubble"><div>:message</div></div>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                {{ Form::label('last_name', __('boilerplate::users.lastname')) }}
                                {{ Form::text('last_name', old('last_name', $user->last_name), ['class' => 'form-control'.$errors->first('last_name', ' is-invalid'), 'autofocus']) }}
                                {!! $errors->first('last_name','<div class="error-bubble"><div>:message</div></div>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                {{ Form::label('password', ucfirst(__('boilerplate::auth.fields.password'))) }}
                                {{ Form::password('password', ['class' => 'form-control'.$errors->first('password', ' is-invalid')]) }}
                                {!! $errors->first('password','<div class="error-bubble"><div>:message</div></div>') !!}
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                {{ Form::label('password_confirmation', ucfirst(__('boilerplate::auth.fields.password_confirm'))) }}
                                {{ Form::password('password_confirmation', ['class' => 'form-control'.$errors->first('password_confirmation', ' is-invalid')]) }}
                                {!! $errors->first('password_confirmation','<div class="error-bubble"><div>:message</div></div>') !!}
                            </div>
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
    {{ Form::close() }}
@endsection

@push('js')
    <script>
        var avatar = {
            url: "{{ route('boilerplate.user.avatar.url', null, false) }}",
            locales: {
                delete: "{{ __('boilerplate::avatar.delete') }}",
                gravatar: {
                    success: "{{ __('boilerplate::avatar.gravatar.success') }}",
                    error: "{{ __('boilerplate::avatar.gravatar.error') }}",
                },
                upload: {
                    success: "{{ __('boilerplate::avatar.upload.success') }}",
                    error: "{{ __('boilerplate::avatar.upload.error') }}",
                }
            }
        }
    </script>
    <script src="{{ mix('/avatar.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script>

    </script>
@endpush