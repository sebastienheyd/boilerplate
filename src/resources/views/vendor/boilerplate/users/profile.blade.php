@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::users.profile.title'),
    'subtitle' => $user->name,
    'breadcrumb' => [
        $user->name => 'user.profile',
    ]
])

@section('content')
    {{ Form::open(['route' => ['user.profile'], 'method' => 'post', 'autocomplete' => 'off', 'files' => true]) }}
        <div class="row">
            <div class="col-sm-12 mbl">
                <span class="btn-group pull-right">
                    <button type="submit" class="btn btn-primary">
                        {{ __('boilerplate::users.save') }}
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                <div class="info-box">
                    <span class="info-box-icon" style="line-height: normal">
                        <img src="{{ $user->avatar_url }}" class="avatar" alt="avatar"/>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">
                            <p class="mbn"><strong class="h3">{{ $user->name  }}</strong></p>
                            <p class="">{{ $user->getRolesList() }}</p>
                        </span>
                        <span class="info-box-more">
                            <p class="mbn text-muted">
                                {{ __('boilerplate::users.profile.subscribedsince', [
                                    'date' => $user->created_at->format(__('boilerplate::date.lFdY')),
                                    'since' => $user->created_at->ago()]) }}
                            </p>
                        </span>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header">
                        @if(is_file($user->avatar_path))
                        <span class="pull-right">
                            <button class="btn btn-xs btn-default" id="remove_avatar">
                                {{ __('boilerplate::users.profile.delavatar') }}
                            </button>
                        </span>
                        @endif
                        <h3 class="box-title">{{ __('boilerplate::users.profile.avatar') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                            {!! Form::file('avatar', ['id' => 'avatar']) !!}
                            {!! $errors->first('avatar','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('boilerplate::users.informations') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    {{ Form::label('last_name', __('boilerplate::users.lastname')) }}
                                    {{ Form::text('last_name', old('last_name', $user->last_name), ['class' => 'form-control', 'autofocus']) }}
                                    {!! $errors->first('last_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    {{ Form::label('first_name', __('boilerplate::users.firstname')) }}
                                    {{ Form::text('first_name', old('first_name', $user->first_name), ['class' => 'form-control']) }}
                                    {!! $errors->first('first_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    {{ Form::label('password', ucfirst(__('validation.attributes.password'))) }}
                                    {{ Form::password('password', ['class' => 'form-control']) }}
                                    {!! $errors->first('password','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                    {{ Form::label('password_confirmation', ucfirst(__('validation.attributes.password_confirmation'))) }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                    {!! $errors->first('password_confirmation','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@include('boilerplate::load.fileinput')

@push('js')
<script>
    $('#avatar').fileinput({
        showUpload: false,
        uploadAsync: false
    });

    $('#remove_avatar').on('click', function(e){
        e.preventDefault();

        bootbox.confirm("{{ __('boilerplate::users.profile.confirmdelavatar') }}", function(e){
            if(e === false) return;

            $.ajax({
                url: '{{ route('user.avatardelete') }}',
                type: 'post',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                cache: false,
                success: function(res) {
                    $('.avatar').attr('src', "{{ asset('/images/default_user.png') }}");
                    growl("{{ __('boilerplate::users.profile.successdelavatar') }}", "success");
                    $('#remove_avatar').remove();
                }
            });
        })
    });

</script>
@endpush