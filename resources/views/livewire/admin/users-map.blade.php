<div class="p-6">
    <h1 class="text-2xl font-bold text-center text-green-700 mb-4">🗺️ Carte des utilisateurs géolocalisés</h1>

    <div id="map" class="rounded-lg shadow-md border"></div>

    <style>
        #map { height: 600px; }
    </style>

    <!-- Leaflet JS & CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>





    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([46.603354, 1.888334], 6); // 🇫🇷 France center

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            const users = @json($usersWithCoordinates);

            users.forEach(user => {
                const marker = L.marker([user.latitude, user.longitude]).addTo(map);
                marker.bindPopup(`<b>${user.name}</b>`);
            });
        });
    </script>
</div>
