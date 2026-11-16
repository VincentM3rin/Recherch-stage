@extends('layouts.app')

@section('content')
    <h1>Tableau de bord Étudiant</h1>

    <x-alerte type="success">
        Connexion réussie ! Bienvenue sur votre espace Étudiant, {{ Auth::user()->etudiant->nomEtudiant ?? Auth::user()->nomUser }}.
    </x-alerte>
@endsection