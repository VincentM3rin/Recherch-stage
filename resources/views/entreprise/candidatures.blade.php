@extends('layouts.app')

@section('content')
    <div style="max-width: 1000px; margin: 0 auto;">
        <h1>Candidatures reçues ({{ $candidatures->count() }})</h1>

        @if($candidatures->isEmpty())
            <x-alerte type="info">
                Vous n'avez reçu aucune candidature pour le moment.
            </x-alerte>
        @else
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="background: #333; color: white; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd;">Étudiant</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Ville</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Période souhaitée</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Date d'envoi</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">CV</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Lettre de motivation</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidatures as $candidature)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <strong>{{ $candidature->etudiant->nomEtudiant ?? 'Étudiant inconnu' }}</strong>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                {{ $candidature->etudiant->villeEtudiant ?? '-' }}
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                Du {{ $candidature->dateDebutStage }} au {{ $candidature->dateFinStage }}
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                {{ $candidature->dateEnvoi }}
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                @if($candidature->cvEtudiant)
                                    <a href="{{ asset('storage/' . $candidature->cvEtudiant) }}" target="_blank"
                                       style="padding: 5px 10px; background: #0066cc; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9em;">
                                        Voir le CV
                                    </a>
                                @else
                                    Non fourni
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                {{-- Si demandeStage est un fichier PDF/DOC, affiche un lien, sinon affiche le texte --}}
                                @if(\Illuminate\Support\Str::endsWith($candidature->demandeStage, ['.pdf', '.doc', '.docx']))
                                    <a href="{{ asset('storage/' . $candidature->demandeStage) }}" target="_blank"
                                       style="padding: 5px 10px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-size: 0.9em;">
                                        Voir la lettre
                                    </a>
                                @else
                                    <div style="max-width: 250px; white-space: pre-line; font-size: 0.9em;">
                                        {{ $candidature->demandeStage }}
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                {{ $candidature->statut ?? 'En attente' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection