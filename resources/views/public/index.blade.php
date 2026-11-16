<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte Interactive Laravel</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 600px; width: 100%; border-radius: 8px; }
    </style>
</head>
<body>

    <h2>Nos Points de Vente</h2>
    
    <!-- Les données PHP sont injectées ici, dans l'attribut HTML data-locations -->
    <div id="map" data-locations="{{ json_encode($locations) }}"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var mapElement = document.getElementById('map');
        var map = L.map('map').setView([46.603354, 1.888334], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // On lit les données depuis l'attribut HTML (JavaScript 100% valide)
        var locations = JSON.parse(mapElement.getAttribute('data-locations'));

        locations.forEach(function(location) {
            L.marker([location.lat, location.lng])
             .addTo(map)
             .bindPopup("<b>" + location.name + "</b>");
        });
    </script>
</body>
</html>