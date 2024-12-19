<?php
$latitude = 8.0639;
$longitude = 123.7483;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Display</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoltFeieAhlFQ_Y7R_aNeJlug7KNfCNNc&callback=initMap">
    </script>
    <style>
    #map {
        height: 500px;
        width: 100%;
    }
    </style>
</head>

<body>
    <h1>Location Map</h1>
    <div id="map"></div>
    <script>
    var map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map)
        .bindPopup("Northwestern Mindanao State College")
        .openPopup();
    </script>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>

</body>

</html>