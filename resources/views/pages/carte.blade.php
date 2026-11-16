@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/carte.css') }}">
    <style>
        .entreprise-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        .points-dropdown {
            display: none;
            list-style: none;
            padding: 8px 0 0 0;
            margin: 10px 0 0 0;
            border-top: 1px solid #e0e0e0;
        }
        .points-dropdown.open {
            display: block;
        }
        .point-subitem {
            padding: 8px 10px;
            margin-top: 5px;
            background: #f8f9fa;
            border-radius: 4px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background 0.2s;
        }
        .point-subitem:hover {
            background: #e3f2fd;
            color: #0d47a1;
        }
    </style>
@endpush

@section('content')
    <h1>Carte des stages</h1>

    @if(session('success'))
        <x-alerte type="success">
            {{ session('success') }}
        </x-alerte>
    @endif

    <div class="carte-container">
        <!-- 1. La carte à gauche -->
        <div id="map"
             data-locations="{{ json_encode($locations) }}"
             data-is-etudiant="{{ Auth::check() && Auth::user()->role === 'etudiant' ? '1' : '0' }}"
             data-postuler-url="{{ url('/etudiant/postuler') }}">
        </div>

        <!-- 2. La liste des entreprises avec menu déroulant à droite -->
        <div class="entreprises-sidebar">
            <h2>Entreprises ({{ count($locations) }})</h2>
            @if(count($locations) > 0)
                <ul class="entreprise-list">
                    @foreach($locations as $eIndex => $entreprise)
                        <li class="entreprise-item" style="cursor: default;">
                            <div class="entreprise-header" data-e-index="{{ $eIndex }}" onclick="toggleDropdown(this.dataset.eIndex)">
                                <strong>{{ $entreprise['name'] }}</strong>
                                <span id="arrow-{{ $eIndex }}" style="font-size: 0.85em; color: #555;">
                                    ({{ count($entreprise['points']) }}) ▼
                                </span>
                            </div>

                            <ul id="dropdown-{{ $eIndex }}" class="points-dropdown">
                                @foreach($entreprise['points'] as $pIndex => $pt)
                                    <li class="point-subitem"
                                        data-e-index="{{ $eIndex }}"
                                        data-p-index="{{ $pIndex }}"
                                        data-lat="{{ $pt['lat'] }}"
                                        data-lng="{{ $pt['lng'] }}"
                                        onclick="focusPoint(this.dataset.eIndex, this.dataset.pIndex)">
                                        <strong>Emplacement #{{ $pIndex + 1 }}</strong>
                                        <br><small class="city-name" style="color: #555;">Chargement de la ville...</small>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="aucune-entreprise">Aucune entreprise affichée sur la carte.</p>
            @endif
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map;
        var markersByEntreprise = [];

        document.addEventListener('DOMContentLoaded', function() {
            var mapElement = document.getElementById('map');
            var isEtudiant = mapElement.getAttribute('data-is-etudiant') === '1';
            var postulerBaseUrl = mapElement.getAttribute('data-postuler-url');

            map = L.map('map').setView([46.603354, 1.888334], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var entreprises = JSON.parse(mapElement.getAttribute('data-locations') || '[]');

            entreprises.forEach(function(entreprise) {
                var entrepriseMarkers = [];
                entreprise.points.forEach(function(pt, idx) {
                    var btnPostuler = '';
                    if (isEtudiant) {
                        btnPostuler = '<br><a href="' + postulerBaseUrl + '/' + entreprise.id + '" ' +
                            'style="display: inline-block; margin-top: 8px; padding: 6px 12px; background: #28a745; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">' +
                            'Postuler</a>';
                    }

                    var label = "<b>" + entreprise.name + "</b><br><small>Emplacement #" + (idx + 1) + "</small><span class='popup-city'></span>" + btnPostuler;

                    var marker = L.marker([pt.lat, pt.lng])
                        .addTo(map)
                        .bindPopup(label);

                    entrepriseMarkers.push(marker);
                });
                markersByEntreprise.push(entrepriseMarkers);
            });
        });

        function toggleDropdown(eIndex) {
            var dropdown = document.getElementById('dropdown-' + eIndex);
            var arrow = document.getElementById('arrow-' + eIndex);
            var count = markersByEntreprise[eIndex] ? markersByEntreprise[eIndex].length : 0;

            if (dropdown.classList.contains('open')) {
                dropdown.classList.remove('open');
                arrow.textContent = '(' + count + ') ▼';
            } else {
                dropdown.classList.add('open');
                arrow.textContent = '(' + count + ') ▲';
                loadCitiesForDropdown(dropdown);
            }
        }

        function loadCitiesForDropdown(dropdown) {
            var items = dropdown.querySelectorAll('.point-subitem');
            items.forEach(function(item, index) {
                if (item.dataset.cityLoaded === '1') return;
                item.dataset.cityLoaded = '1';

                var lat = item.dataset.lat;
                var lng = item.dataset.lng;
                var cityLabel = item.querySelector('.city-name');
                var eIndex = item.dataset.eIndex;
                var pIndex = item.dataset.pIndex;

                setTimeout(function() {
                    fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng + '&accept-language=fr')
                        .then(function(response) { return response.json(); })
                        .then(function(data) {
                            var addr = data.address || {};
                            var city = addr.city || addr.town || addr.village || addr.municipality || 'Lieu inconnu';
                            var postcode = addr.postcode ? ' (' + addr.postcode + ')' : '';
                            cityLabel.textContent = city + postcode;

                            var marker = markersByEntreprise[eIndex] ? markersByEntreprise[eIndex][pIndex] : null;
                            if (marker) {
                                var currentPopup = marker.getPopup().getContent();
                                var updatedPopup = currentPopup.replace("<span class='popup-city'></span>", "<br>" + city + postcode);
                                marker.setPopupContent(updatedPopup);
                            }
                        })
                        .catch(function() {
                            cityLabel.textContent = 'Ville non disponible';
                        });
                }, index * 400);
            });
        }

        function focusPoint(eIndex, pIndex) {
            var marker = markersByEntreprise[eIndex] ? markersByEntreprise[eIndex][pIndex] : null;
            if (marker) {
                map.setView(marker.getLatLng(), 14);
                marker.openPopup();
            }
        }
    </script>
@endsection