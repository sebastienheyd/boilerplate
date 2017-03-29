@extends('auth.layout', ['title' => 'Erreur 404'])

@section('content')
    @component('auth.loginbox')
        <div class="text-center">
            <h2 class="mtn">Erreur 403</h2>
            <p>Vous n'êtes pas autorisé à accéder à cette page.</p>
            <p><a href="{{ URL::previous() }}" class="btn btn-primary">Revenir à la page précédente</a></p>
        </div>
    @endcomponent
@endsection