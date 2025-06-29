<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Our Garage</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .map-container {
            position: relative;
            max-width: 90%;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
            margin-bottom: 5px;
        }

        #map {
            width: 100%;
            height: 500px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }

        .map-sidebar {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }

        button {
            display: block;
            width: 100%;
            margin: 5px 0;
            padding: 8px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        /* Responsive Design */
        @media screen and (max-width: 900px) {
            #map {
                height: 400px;
            }

            .map-sidebar {
                position: static;
                margin-bottom: 10px;
            }
        }
    </style>

</head>
<body>

<div class="map-container">
    <h2>Find Our Garages</h2>
    <p>Click the buttons to switch between Light, Dark, and Satellite View.</p>

    <div class="map-sidebar">
        <button onclick="setMapLayer('light')">Light Mode</button>
        <button onclick="setMapLayer('dark')">Dark Mode</button>
        <button onclick="setMapLayer('satellite')">Satellite View</button>
    </div>

    <div id="map"></div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    // Initialize the map
    var map = L.map('map').setView([18.5204, 73.8567], 12); // Pune Coordinates

    // Define tile layers
    var lightLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    });

    var darkLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© CartoDB'
    });

    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '© Esri & OpenStreetMap'
    });

    // Default map layer
    lightLayer.addTo(map);

    // Function to change layers
    function setMapLayer(type) {
        map.eachLayer(function(layer) {
            map.removeLayer(layer);
        });

        if (type === 'light') {
            lightLayer.addTo(map);
        } else if (type === 'dark') {
            darkLayer.addTo(map);
        } else if (type === 'satellite') {
            satelliteLayer.addTo(map);
        }

        // Re-add the marker
        L.marker([18.5204, 73.8567]).addTo(map)
            .bindPopup("<b>RMC&B Garage - Pune</b><br>Best car & bike services in Pune.").openPopup();
    }

    // Add a marker
    L.marker([18.5204, 73.8567]).addTo(map)
        .bindPopup("<b>RMC&B Garage - Pune</b><br>Best car & bike services in Pune.").openPopup();

</script>

</body>
</html>
