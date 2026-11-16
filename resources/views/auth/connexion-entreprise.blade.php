@extends('layouts.app')

@section('content')
    <div style="max-width: 400px; margin: 0 auto;">
        <h1>Espace Entreprise - Connexion</h1>

        <form action="{{ route('entreprise.login') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
            @csrf

            <x-alerte type="info">
                Veuillez saisir vos identifiants professionnels.
            </x-alerte>

            <x-input name="nomUser" label="Nom d'utilisateur" type="text" placeholder="ex: dupont_rh" :value="old('nomUser')" />

            <x-input name="mdpUser" label="Mot de passe" type="password" />

            <button type="submit" style="padding: 10px 15px; background: #0066cc; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%;">
                Se connecter
            </button>

            <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
                Pas encore de compte ? <a href="{{ route('entreprise.inscription') }}">Créer une entreprise</a>
            </p>
        </form>
    </div>
@endsection