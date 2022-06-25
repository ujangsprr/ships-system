<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Marker LeafletJS</title>
    <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        #map {
            width: 600px;
            height: 400px;
        }

        body {
            padding: 0; margin: 0;
        }

        #map {
            height: 100%; width: 100vw;
        }
	</style>
</head>
<body>
    <div id="map"></div>
    <script type="text/javascript">

        var mymap = L.map('map', { zoomControl: false }).setView([-7.189929611713598, 112.70793909022805], 13);
        

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data © OpenStreetMap contributors.',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

        var markerkapal = L.icon({
   			iconUrl: 'img/markkapal.png',
    		iconSize: [50, 35], // size of the icon
		});

        L.marker([-7.1881333, 112.6978667], {icon: markerkapal}).addTo(mymap);
        L.marker([-7.1906317, 112.7035483], {icon: markerkapal}).addTo(mymap);
    </script>
</body>
</html>