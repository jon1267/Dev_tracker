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
    <h1>Location Tracker</h1>
</body>
</html>