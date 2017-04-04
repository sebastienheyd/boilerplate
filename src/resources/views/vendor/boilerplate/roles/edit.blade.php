@extends('boilerplate::layout.index', [
    'title' => 'Gestion des rôles',
    'subtitle' => "Édition d'un rôle",
    'breadcrumb' => ['Gestion des rôles' => 'roles.index', "Édition d'un rôle"]
])

@include('boilerplate::load.icheck')

@section('content')
    {{ Form::open(['route' => ['roles.update', $role->id], 'method' => 'put', 'autocomplete' => 'off']) }}
        <div class="row">
            <div class="col-sm-12 mbl">
                <a href="{{ route("roles.index") }}" class="btn btn-default">Liste des rôles</a>
                <span class="btn-group pull-right">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Paramètres</h3>
                    </div>
                    <div class="box-body">
                        {!! $errors->first('name','<p class="text-danger"><strong>:message</strong></p>') !!}
                        <div class="form-group {{ $errors->has('display_name') ? 'has-error' : '' }}">
                            {{ Form::label('display_name', 'Display name') }}
                            {{ Form::text('display_name', old('display_name', __($role->display_name)), ['class' => 'form-control']) }}
                            {!! $errors->first('display_name','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::text('description', old('description', __($role->description)), ['class' => 'form-control']) }}
                            {!! $errors->first('description','<p class="text-danger"><strong>:message</strong></p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            @if(count($permissions) > 0)
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Permissions</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td style="width:25px;">
                                        @if($role->id == 1)
                                            <input type="checkbox" checked disabled class="icheck"/>
                                        @else
                                            {{ Form::checkbox('permission['.$permission->id.']', 1, old('permission['.$permission->id.']', $role->permissions()->where(['id' => $permission->id])->count()), ['id' => 'permission_'.$permission->id, 'class' => 'icheck']) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ Form::label('permission_'.$permission->id, __($permission->display_name), ['class' => 'mbn']) }}<br />
                                        <small>{{ __($permission->description) }}</small>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
    {{ Form::close() }}
@endsection