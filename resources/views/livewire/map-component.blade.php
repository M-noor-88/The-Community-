<div>
    <!-- Map container, ignored by Livewire -->
    <div wire:ignore>
        <div id="map" style="height: 250px; width: 100%; border-radius: 10px;"></div>
    </div>

    <!-- Leaflet CSS/JS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    />
    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    ></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const locations = @json($locations);
            const center = locations.length > 0
                ? [locations[0].lat, locations[0].lng]
                : [33.5138, 36.2765];

            const map = L.map("map").setView(center, 13);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '© OpenStreetMap',
                maxZoom: 18,
            }).addTo(map);

            const customIcon = L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/252/252025.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            locations.forEach((loc, index) => {
                const marker = L.marker([loc.lat, loc.lng], {
                    icon: customIcon
                }).addTo(map);

                const popupContent = `
                    <div style="font-family: sans-serif;">
                        <strong>${loc.name}</strong><br/>
                        <small>${loc.description}</small>
                    </div>
                `;
                marker.bindPopup(popupContent);
            });
        });
    </script>
</div>
