@extends('boilerplate::layout.index', [
    'title' => 'Gestion des utilisateurs',
    'subtitle' => "Création d'un utilisateur",
    'breadcrumb' => ['Gestion des utilisateurs' => 'users.index', "Ajout d'un utilisateur" ]
])

@include('boilerplate::load.icheck')

@section('content')
    {{ Form::open(['route' => 'users.store', 'autocomplete' => 'off']) }}
        <div class="row">
            <div class="col-sm-12 mbl">
                <a href="{{ route("users.index") }}" class="btn btn-default">Liste des utilisateurs</a>
                <span class="btn-group pull-right">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Informations</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                            {{ Form::label('active', 'Statut') }}
                            {{ Form::select("active", ['0' => 'Désactivé', '1' => 'Activé'], old('active', 1), ['class' => 'form-control']) }}
                            {!! $errors->first('active','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                    {{ Form::label('last_name', 'Nom') }}
                                    {{ Form::input('text', 'last_name', old('last_name'), ['class' => 'form-control', 'autofocus']) }}
                                    {!! $errors->first('last_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    {{ Form::label('last_name', 'Prénom') }}
                                    {{ Form::input('text', 'first_name', old('first_name'), ['class' => 'form-control']) }}
                                    {!! $errors->first('first_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {{ Form::label('email', 'E-mail') }}
                            {{ Form::input('text', 'email', old('email'), ['class' => 'form-control']) }}
                            {!! $errors->first('email','<p class="text-danger"><strong>:message</strong></p>') !!}
                            <small class="text-muted">
                                L'utilisateur recevra un e-mail d'invitation à se connecter qui lui permettra de saisir son nouveau mot de passe.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Rôle(s)</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed table-hover">
                            @foreach($roles as $role)
                                <tr>
                                    <td style="width:25px">
                                        {{ Form::checkbox('roles['.$role->id.']', null, null, ['id' => 'role_'.$role->id, 'class' => 'icheck']) }}
                                    </td>
                                    <td>
                                        {{ Form::label('role_'.$role->id, $role->display_name, ['class' => 'mbn']) }}<br />
                                        <span class="small">{{ $role->description }}</span><br />
                                        <span class="small text-muted">{{ $role->permissions->implode('display_name', ', ') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection