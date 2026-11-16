@extends('layouts.app')

@section('content')
    <div style="max-width: 900px; margin: 0 auto;">
        <h1>Tableau de bord Entreprise</h1>

        @if(session('success'))
            <x-alerte type="success">
                {{ session('success') }}
            </x-alerte>
        @else
            <x-alerte type="success">
                Connexion réussie ! Bienvenue sur votre espace professionnel, <strong>{{ $entreprise->nomEntreprise }}</strong>.
            </x-alerte>
        @endif

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; margin-bottom: 15px;">
            <h2 style="margin: 0;">Mes emplacements sur la carte ({{ $points->count() }})</h2>
            <a href="{{ route('entreprise.carte') }}"
               style="padding: 10px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">
                + Ajouter un point
            </a>
        </div>

        @if($points->isEmpty())
            <x-alerte type="info">
                Vous n'avez encore placé aucun point sur la carte. Cliquez sur « + Ajouter un point » pour référencer votre entreprise.
            </x-alerte>
        @else
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr style="background: #333; color: white; text-align: left;">
                        <th style="padding: 10px; border: 1px solid #ddd;">#</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Latitude</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Longitude</th>
                        <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($points as $index => $point)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;">Point {{ $index + 1 }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $point->latEntreprise }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd;">{{ $point->longEntreprise }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                                <form action="{{ route('entreprise.carte.destroy', $point->idPoint) }}" method="POST"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer ce point de la carte ?');"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="padding: 6px 12px; background: #d32f2f; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection