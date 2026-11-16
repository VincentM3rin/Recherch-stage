@extends('layouts.app')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <h1>Postuler chez {{ $entreprise->nomEntreprise }}</h1>

        <x-alerte type="info">
            Candidature envoyée par <strong>{{ $etudiant->nomEtudiant }}</strong> ({{ $etudiant->villeEtudiant }})
            à destination de <strong>{{ $entreprise->nomEntreprise }}</strong> ({{ $entreprise->villeEntreprise }}).
        </x-alerte>

        <form action="{{ route('etudiant.postuler.store', $entreprise->idEntreprise) }}"
              method="POST"
              enctype="multipart/form-data"
              style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
            @csrf

            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <x-input name="dateDebutStage" label="Date de début du stage" type="date" :value="old('dateDebutStage')" required />
                </div>
                <div style="flex: 1;">
                    <x-input name="dateFinStage" label="Date de fin du stage" type="date" :value="old('dateFinStage')" required />
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="cvEtudiant" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Votre CV (PDF, DOC ou DOCX - 2 Mo max.)
                </label>
                <input type="file"
                       name="cvEtudiant"
                       id="cvEtudiant"
                       accept=".pdf,.doc,.docx"
                       required
                       style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                @error('cvEtudiant')
                    <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label for="demandeStage" style="display: block; font-weight: bold; margin-bottom: 5px;">
                    Lettre de motivation / Demande de stage
                </label>
                <textarea name="demandeStage"
                          id="demandeStage"
                          rows="6"
                          required
                          placeholder="Présentez-vous et expliquez votre recherche de stage..."
                          style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">{{ old('demandeStage') }}</textarea>
                @error('demandeStage')
                    <span style="color: red; font-size: 0.9em;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; align-items: center; gap: 15px; margin-top: 15px;">
                <button type="submit"
                        style="padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Envoyer ma demande de stage
                </button>
                <a href="{{ route('carte') }}" style="color: #555; text-decoration: none;">Annuler et retourner à la carte</a>
            </div>
        </form>
    </div>
@endsection