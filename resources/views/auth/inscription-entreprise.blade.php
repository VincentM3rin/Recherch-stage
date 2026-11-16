@extends('layouts.app')

@section('content')
    <div style="max-width: 400px; margin: 0 auto;">
        <h1>Espace Entreprise - Inscription</h1>

        <form action="{{ route('entreprise.register') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
            @csrf

            <x-alerte type="info">
                Créez votre compte et enregistrez votre entreprise.
            </x-alerte>

            <h3 style="margin-top: 15px;">Vos identifiants de connexion</h3>

            <x-input name="nomUser" label="Nom d'utilisateur" type="text" placeholder="ex: dupont_rh" :value="old('nomUser')" />

            <x-input name="mdpUser" label="Mot de passe (6 caractères min.)" type="password" />

            <hr style="margin: 25px 0;">

            <h3 style="margin-top: 15px;">Informations de l'entreprise</h3>

            <x-input name="nomEntreprise" label="Nom de l'entreprise" type="text" placeholder="ex: Tech Corp" :value="old('nomEntreprise')" />

            <x-input name="villeEntreprise" label="Ville" type="text" placeholder="ex: Paris" :value="old('villeEntreprise')" />

            <div style="margin-bottom: 15px;">
                <label for="idType" style="display: block; margin-bottom: 5px; font-weight: bold;">Secteur d'activité</label>
                <select name="idType" id="idType" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Sélectionnez un secteur --</option>
                    @foreach($types as $type)
                        <option value="{{ $type->idType }}" {{ old('idType') == $type->idType ? 'selected' : '' }}>
                            {{ $type->libelType }}
                        </option>
                    @endforeach
                </select>
                @error('idType')
                    <div style="color: red; margin-top: 5px; font-size: 0.9em;">{{ $message }}</div>
                @enderror
            </div>

            @if ($errors->has('error'))
                <div style="color: red; margin-bottom: 10px; font-size: 0.9em;">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <button type="submit" style="padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 10px;">
                Créer mon compte
            </button>

            <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
                Déjà inscrit ? <a href="{{ route('entreprise.connexion') }}">Se connecter</a>
            </p>
        </form>
    </div>
@endsection