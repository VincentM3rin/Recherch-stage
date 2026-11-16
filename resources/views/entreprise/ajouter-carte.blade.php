@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <h1>Ajouter un emplacement sur la carte</h1>
        <p>Entreprise : <strong>{{ $entreprise->nomEntreprise }}</strong> ({{ $entreprise->villeEntreprise }})</p>

        <x-alerte type="info">
            Cliquez sur la carte pour positionner un nouveau marqueur (vos emplacements déjà enregistrés s'affichent également).
        </x-alerte>

        <div id="map-picker"
             data-existing-points="{{ json_encode($entreprise->points) }}"
             style="height: 350px; width: 100%; border-radius: 6px; border: 1px solid #ccc; margin-bottom: 20px;">
        </div>

        <form action="{{ route('entreprise.carte.store') }}" method="POST" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px;">
            @csrf

            <div style="display: flex; gap: 15px;">
                <div style="flex: 1;">
                    <x-input name="latEntreprise" label="Latitude" type="text" :value="old('latEntreprise')" required />
                </div>
                <div style="flex: 1;">
                    <x-input name="longEntreprise" label="Longitude" type="text" :value="old('longEntreprise')" required />
                </div>
            </div>

            <button type="submit" style="padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Enregistrer ce point
            </button>
            <a href="{{ route('entreprise.dashboard') }}" style="margin-left: 10px; color: #555;">Retour au tableau de bord</a>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var mapElement = document.getElementById('map-picker');
            var existingPoints = JSON.parse(mapElement.dataset.existingPoints || '[]');

            var map = L.map('map-picker').setView([46.603354, 1.888334], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Affichage des points déjà enregistrés
            existingPoints.forEach(function (pt, index) {
                L.marker([pt.latEntreprise, pt.longEntreprise])
                    .addTo(map)
                    .bindPopup("Emplacement déjà enregistré #" + (index + 1));
            });

            // Marqueur temporaire pour le nouveau point
            var newMarker = null;

            map.on('click', function (e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);

                document.getElementById('latEntreprise').value = lat;
                document.getElementById('longEntreprise').value = lng;

                if (newMarker) {
                    newMarker.setLatLng(e.latlng);
                } else {
                    newMarker = L.marker(e.latlng).addTo(map).bindPopup("Nouveau point").openPopup();
                }
            });
        });
    </script>
@endsection