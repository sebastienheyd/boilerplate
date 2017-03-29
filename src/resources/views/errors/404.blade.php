@extends('auth.layout', ['title' => 'Erreur 404'])

@section('content')
    @component('auth.loginbox')
        <div class="text-center">
            <h2 class="mtn">Erreur 404</h2>
            <p>Page introuvable</p>
            <p><a href="{{ URL::previous() }}" class="btn btn-primary">Revenir à la page précédente</a></p>
        </div>
    @endcomponent
@endsection