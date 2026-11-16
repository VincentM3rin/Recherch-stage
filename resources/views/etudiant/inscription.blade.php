@extends('layouts.app')

@section('content')
    <div style="max-width: 400px; margin: 0 auto;">
        <h2>Inscription - Espace Étudiant</h2>

        <form action="{{ route('etudiant.inscription') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
            @csrf

            <x-alerte type="info">
                Créez votre compte et enregistrez vos informations étudiantes.
            </x-alerte>

            <h3 style="margin-top: 15px;">Vos identifiants de connexion</h3>

            <x-input name="nomUser" label="Nom d'utilisateur" type="text" placeholder="ex: jean_dupont" :value="old('nomUser')" />

            <x-input name="mdpUser" label="Mot de passe (6 caractères min.)" type="password" />

            <hr style="margin: 25px 0;">

            <h3 style="margin-top: 15px;">Informations de l'étudiant</h3>

            <x-input name="nomEtudiant" label="Nom complet (Étudiant)" type="text" placeholder="ex: Jean Dupont" :value="old('nomEtudiant')" />

            <x-input name="villeEtudiant" label="Ville" type="text" placeholder="ex: Paris" :value="old('villeEtudiant')" />

            @if ($errors->has('error'))
                <div style="color: red; margin-bottom: 10px; font-size: 0.9em;">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <button type="submit" style="padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 10px;">
                Créer mon compte
            </button>

            <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
                Déjà inscrit ? <a href="{{ route('etudiant.connexion') }}">Se connecter</a>
            </p>
        </form>
    </div>
@endsection