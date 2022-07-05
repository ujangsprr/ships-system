<?php
include('data.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ships System</title>
    <link rel="icon" href="https://cdn.icon-icons.com/icons2/865/PNG/512/Citycons_ship_icon-icons.com_67927.png" type="image/x-icon">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

    <script src="https://cdn.leafletjs.com/leaflet/v1.1.0/leaflet-src.js"></script>
    <script src="js/leaflet.rotatedMarker.js"></script>
    
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

<body id="page-top">

    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow">
                <!-- <a class="navbar-brand" href="#"> -->
                    <img src="img/ppns-text.png" alt="" style="height: 50px;">
                <!-- </a> -->
                    <!-- <h1>PPNS</h1> -->
                    <!-- <h6>SISTEM PERINGATAN DINI TABRAKAN KAPAL SECARA REALTIME BERBASIS DATA AUTOMATIC IDENTIFICATION SYSTEM (AIS)</h6> -->
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl mb-4">
                            <div class="card border-left-primary h-100 py-2 mt-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ID Kapal A</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                        echo $ShipsA;
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl mb-4">
                            <div class="card border-left-primary h-100 py-2 mt-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            ID Kapal B</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                        echo $ShipsB;
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl mb-4">
                            <div class="card border-left-primary h-100 py-2 mt-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Location Kapal A</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                        echo $lat1 . "," . $lon1;
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl mb-4">
                            <div class="card border-left-primary h-100 py-2 mt-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Location Kapal B</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                        echo $lat2 . "," . $lon2;
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl mb-4">
                            <div class="card border-left-primary h-100 py-2 mt-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Heading Kapal A</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                        echo $hdgnew1;
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl mb-4">
                            <div class="card border-left-primary h-100 py-2 mt-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Heading Kapal B</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                        echo $hdgnew2;
                                                    }
                                                    else{
                                                        echo "-";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-7">                           

                            <div class="card shadow mb-4" style="height: 520px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card shadow" style="height: 350px;">
                                            <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <h6 class="m-0 font-weight-bold text-primary">Database Kapal</h6>                                    
                                            </div> -->
                                            <div class="card-body">
                                                <div class="table-responsive" style="height:300px;">
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>MMSI</th>
                                                                <th>ShipName</th>
                                                                <th>Lat</th>
                                                                <th>Lon</th>
                                                                <th>SOG</th>
                                                                <th>COG</th>
                                                                <th>HDG</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-center">
                                                        <?php 
                                                            for ($x = 1; $x <= 20; $x++) {
                                                            ?>
                                                                <tr>
                                                                    <td><?= $shipsID[$x] ?></td>
                                                                    <td><?= $shipsName[$x] ?></td>
                                                                    <td><?= $shipsLat[$x] ?></td>
                                                                    <td><?= $shipsLon[$x] ?></td>
                                                                    <td><?= $shipsSog[$x] ?></td>
                                                                    <td><?= $shipsCog[$x] ?></td>
                                                                    <td><?= $shipsHdg[$x] ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-xl-6 col-lg-5">
                                            <div class="card border-primary py-2 mt-4">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Ketinggian Gelombang Air Laut</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $wave_desc; ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-5">
                                            <div class="card border-primary py-2 mt-4">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Kecepatan Angin Laut</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $wind_min; ?> - <?= $wind_max; ?> knots</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4" style="height: 520px;">
                                <div class="card-body">
                                    <form action="" method="post">
                                        <select name="ShipsA" class="form-select">
                                            <option disabled selected>ID Kapal A</option>
                                                <?php
                                                    for ($x = 1; $x <= 20; $x++) {
                                                        echo "<option value='$shipsID[$x]'>$shipsID[$x]</option>";
                                                    }                         
                                                ?>
                                        </select>                                        
                                    
                                        <select name="ShipsB" class="form-select mt-2">
                                            <option disabled selected>ID Kapal B</option>
                                                <?php
                                                    for ($x = 1; $x <= 20; $x++) {                                                       
                                                        echo "<option value='$shipsID[$x]'>$shipsID[$x]</option>";
                                                    }                         
                                                ?>
                                        </select>
                                        <input class="btn btn-primary mt-2" type="submit" name="submit" value="Submit">
                                        <button onclick="location.href='index'" class="btn btn-danger mt-2">Reset</button>
                                    </form>

                                    <div class="card border-bottom-primary py-2 mt-3">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Jarak Kapal A dan B</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php
                                                            if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                                echo $distance['kilometers'];
                                                            }
                                                            else{
                                                                echo "-";
                                                            }
                                                        ?> km
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-water fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-bottom-primary py-2 mt-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Sudut Kapal A dan B</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php
                                                            if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                                echo $hdgnotif;
                                                            }
                                                            else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                <i class="fas fa-compass fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-bottom-primary py-2 mt-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Alarm</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                        if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])){
                                                            echo $disnotif;
                                                        }
                                                        else{
                                                            echo "-";
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-bell fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2022</span>
                    </div>
                </div>
            </footer> -->

        </div>
    </div>

    <div id="map"></div>
    <script type="text/javascript">
        var mymap = L.map('map', { zoomControl: false }).setView([-7.189929611713598, 112.70793909022805], 13);
        var lat1 = <?= $lat1; ?>;
        var lon1 = <?= $lon1; ?>;
        var lat2 = <?= $lat2; ?>;
        var lon2 = <?= $lon2; ?>;
        
        var ang1 = <?= $hdgmap1; ?>;
        var ang2 = <?= $hdgmap2; ?>;
        
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

        L.marker([lat1, lon1], {
            icon: markerkapal,
            rotationAngle: ang1,
            draggable: false
        }).addTo(mymap);

        L.marker([lat2, lon2], {
            icon: markerkapal,
            rotationAngle: ang2,
            draggable: false
        }).addTo(mymap);

    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>