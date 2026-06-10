<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" integrity="sha512-Zcn6bjR/8RZbLEpLIeOwNtzREBAJnUKESxces60Mpoj+2okopSAcSUIUOseddDm0cxnGQzxIR7vJgsLZbdLE3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Location Tracker</title>
    <style>
        #map {
            height: calc(100% - 60px);
        }
        header {
            padding : 15px;
            background : #f0f0f0;
            font-size : 1.2rem;
        }
        .info {
            position: absolute;
            top: 70px;
            right: 10px;
            background : #ffffff;
            padding : 10px;
            border-radius : 6px;
        }
    </style>
</head>
<body>
    <header>Real Time Location Tracker</header>
    <div id="error"></div>
    <div id="map"></div>

    <div class="info">
        <strong>Active</strong><span id="active-users">0</span><br>
        <strong>You</strong><span id="your-location">0</span><br>
        <strong>Status</strong><span id="status">0</span><br>
    </div>

    <div class="loading">
        <div class="spinner"></div>
        <div>Initializing Map...</div>
    </div>
    <h1>Location Tracker</h1>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js" integrity="sha512-BwHfrr4c9kmRkLw6iXFdzcdWV/PGkVgiIyIWLLlTSXzWQzxuSg4DiQUCpauz/EWjgk5TYQqX/kvn9pG1NpYfqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        window.REVERB_KEY = '{{ env('VITE_REVERB_APP_KEY', env('REVERB_APP_KEY')) }}';
        window.REVERB_HOST = '{{ env('VITE_REVERB_HOST', env('REVERB_HOST')) }}';
        window.REVERB_PORT = '{{ env('VITE_REVERB_PORT', env('REVERB_PORT', 443)) }}';
        window.REVERB_SCHEME = '{{ env('VITE_REVERB_SCHEME', env('REVERB_SCHEME', 'https')) }}';
        window.sessionId = '{{ session()->getId() }}';
    </script>

    @vite(['resources/js/app.js'])

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const map = L.map('map').setView([0, 0], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            const markers = {};

            const updateMarker = (id, lat, lng) => {
                const isMe = id === window.sessionId;
                if (!markers[id]) {
                    const icon = L.divIcon({
                        html: `<div style="background: ${isMe ? '#667eea' : '#10b981'};
                        width: 18px;height: 18px;border-radius: 50%;border: 2px solid #fff;box-shadow: 0 1px 4px #000;"></div>`,
                        iconSize: [18, 18], iconAnchor: [9, 9]
                    });

                    markers[id] = L.marker([lat, lng], { icon }).addTo(map)
                    .bindPopup(`${isMe ? 'You' : 'User'}<br>${lat.toFixed(4)}, ${lng.toFixed(4)}`);
                } else {
                    markers[id].setLatLng([lat, lng]);
                }

                document.getElementById('active-users').textContent = Object.keys(markers).length;

                if (isMe) {
                    map.setView([lat, lng], 16);
                    document.getElementById('your-location').textContent = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                }
            }

            const showError = (msg) => {
                const e = document.getElementById('error');
                e.textContent = msg;
                e.classList.add('show');
                setTimeout(() => e.classList.remove('show'), 5000);
            };

            const sendLocation = (lat, lng) => {
                fetch('{{ route('location.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').content
                    },
                    body: JSON.stringify({latitude: lat, longitude: lng })
                }).catch( () => showError('Send location failed'));
            };

            if (navigator.geolocation) {
                document.getElementById('status').textContent = 'Getting location...';
            }
        });
    </script>

</body>
</html>