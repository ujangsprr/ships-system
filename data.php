<?php

include 'connect.php';

// Mengambil Konten dari AIS
$IDContent = file_get_contents("http://ais-socket.ppns.ac.id/AIS/coba1.php");

// Mengambil file konten html
$DOM = new DOMDocument();
@$DOM->loadHTML($IDContent);

// Mengambil data dati html dengan tag td/tabel
$IDDetail = $DOM->getElementsByTagName('td');

// Looping untuk mengambil data yang ada di td disimpan di DataTable dalam bentuk array
foreach($IDDetail as $NodeIDDetail) {
    $DataTableIDDetailHTML[] = trim($NodeIDDetail->textContent);
}

// Definisi variabel count
$count = 1;

// Looping untuk mengambil data kapal sebanyak 20
for ($x = 1; $x <= 20; $x++) {
    $shipsID[$x] = $DataTableIDDetailHTML[$count]; // ID Kapal
    $shipsName[$x] = $DataTableIDDetailHTML[$count+2]; // Nama Kapal
    $shipsLat[$x] = $DataTableIDDetailHTML[$count+5]; // Latitude
    $shipsLon[$x] = $DataTableIDDetailHTML[$count+6]; // Longitude
    $shipsSog[$x] = $DataTableIDDetailHTML[$count+7]; // SOG
    $shipsCog[$x] = $DataTableIDDetailHTML[$count+8]; // COG
    $shipsHdg[$x] = $DataTableIDDetailHTML[$count+9]; // Heading
    $count += 18; // Jarak antar data 18 index
}

// Mengambil data dari bmkg
$bmkgdata = file_get_contents("https://peta-maritim.bmkg.go.id/public_api/pelabuhan/0007_Tanjung%20Perak.json");
// Decode json data to array
$result = json_decode($bmkgdata, true);

// Mengambil spesifik data (wind min, wind max, wave)
$wind_min = $result['data'][0]['wind_speed_min'];
$wind_max = $result['data'][0]['wind_speed_max'];
$wave_desc = $result['data'][0]['wave_desc'];

// Membagi nilai wave minimal dan maksimal
$wave_split = explode(" ",$wave_desc);
foreach($wave_split as $item) {
    $wave_data[] = $item;
}
// Menyimpan data wave maks ke dalam variabel wave_maks
$wave_maks = $wave_data[2];

// Fungsi Haversine mencari jarak dari 2 titik
function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) { // radius in meters
    // konversi degree to radian
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    // Lat and Lon Delta
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
  
    // rumus haversine mencari angle
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    // angle dikali dengan radius bumi dalam meter
    $meters = $angle * $earthRadius;
    // konversi meter ke kilometer
    $kilometers = $meters / 1000.0;

    // mengambil data 3 dibelakang koma
    $meters = round($meters, 3);
    $kilometers = round($kilometers, 3);

    // mengembalikan data ketika fungsi dipanggil
    return compact('angle', 'kilometers', 'meters');
}

// Ketika tombol submit ditekan maka akan menjalankan program
if(isset($_POST['submit'])){
    // mengecek apakah input ShipsA dan ShipsB kosong atau tidak
    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])) {
        // mengambil data ID Kapal yang dipilih
        $ShipsA = $_POST['ShipsA'];
        $ShipsB = $_POST['ShipsB'];

        // mengambil data kapal berdasarkan 2 ID kapal yang dipilih
        $htmlContent = file_get_contents("http://ais-socket.ppns.ac.id/AIS/AIS_RT_TA3.php?MMSI1=$ShipsA&MMSI2=$ShipsB");
        // Mengambil file konten html
        $DOM = new DOMDocument();
        @$DOM->loadHTML($htmlContent);
        // Mengambil data dati html dengan tag td/tabel
        $Detail = $DOM->getElementsByTagName('td');

        // Looping untuk mengambil data yang ada di td disimpan di DataTable dalam bentuk array
        foreach($Detail as $NodeDetail) {
            $DataTableDetailHTML[] = trim($NodeDetail->textContent);
        }

        // menyimpan data kapal A yang lebih spesifik
        $id1 = $DataTableDetailHTML[1];
        $lat1 = $DataTableDetailHTML[4];
        $lon1 = $DataTableDetailHTML[5];
        $hdg1 = $DataTableDetailHTML[9];

        // menyimpan data kapal B yang lebih spesifik
        $id2 = $DataTableDetailHTML[14];
        $lat2 = $DataTableDetailHTML[17];
        $lon2 = $DataTableDetailHTML[18];
        $hdg2 = $DataTableDetailHTML[22];

        // jika heading kapal A 511 maka dikurangi 360
        if($hdg1 == 511){ $hdgnew1 = $hdg1 - 360; }
        // jika tidak maka nilai heading akan tetap
        else{ $hdgnew1 = $hdg1; }

        // jika heading kapal B 511 maka dikurangi 360
        if($hdg2 == 511){ $hdgnew2 = $hdg2 - 360; }
        // jika tidak maka nilai heading akan tetap
        else{ $hdgnew2 = $hdg2; }

        // mengklasifikasi kapal A ke dalam 4 kuadran
        if($hdgnew1 >= 0 && $hdgnew1 < 90){ $kudhdg1 = 1; } // 0 - 90 masuk kuadran 1
        else if($hdgnew1 >= 90 && $hdgnew1 < 180){ $kudhdg1 = 2; } // 91 - 180 masuk kuadran 2
        else if($hdgnew1 >= 180 && $hdgnew1 < 270){ $kudhdg1 = 3; } // 181 - 270 masuk kuadran 3
        else if($hdgnew1 >= 270 && $hdgnew1 < 360){ $kudhdg1 = 4; } // 271 - 360 masuk kuadran 4

        // mengklasifikasi kapal B ke dalam 4 kuadran
        if($hdgnew2 >= 0 && $hdgnew2 < 90){ $kudhdg2 = 1; } // 0 - 90 masuk kuadran 1
        else if($hdgnew2 >= 90 && $hdgnew2 < 180){ $kudhdg2 = 2; } // 91 - 180 masuk kuadran 2
        else if($hdgnew2 >= 180 && $hdgnew2 < 270){ $kudhdg2 = 3; } // 181 - 270 masuk kuadran 3
        else if($hdgnew2 >= 270 && $hdgnew2 < 360){ $kudhdg2 = 4; } // 271 - 360 masuk kuadran 4

        if($hdgnew1 >= 0 && $hdgnew1 < 270){ $hdgmap1 = $hdgnew1 + 90; }
        else if($hdgnew1 >= 270 && $hdgnew1 < 360){ $hdgmap1 = $hdgnew1 - 270; }

        if($hdgnew2 >= 0 && $hdgnew2 < 270){ $hdgmap2 = $hdgnew2 + 90; }
        else if($hdgnew2 >= 270 && $hdgnew2 < 360){ $hdgmap2 = $hdgnew2 - 270; }

        // menghitung jarak dari 2 kapal dengan memanggil fungsi haversine dan disimpan di variabel distance
        $distance =  haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2);

        // jika kuadran kapal bersebelahan maka bahaya
        if(abs($kudhdg1 - $kudhdg2) == 1 || abs($kudhdg1 - $kudhdg2) == 3 || $distance['kilometers'] <= "2"){
            $hdgnotif = 'Bahaya';
        }
        // jika tidak bersebelahan maka aman
        else{
            $hdgnotif = 'Aman';
        }

        // jika jarak kurang dari 2 meter atau ketinggian air laut lebih dari 2.5 atau kecepatan angin lebih dari 15 maka notif bahaya
        if($distance['kilometers'] <= "2" || $wave_maks >= "2.5" || $wind_max >= "15" || (abs($kudhdg1 - $kudhdg2) == 1) || (abs($kudhdg1 - $kudhdg2) == 3)){
            $disnotif = 'Bahaya';
            $condition = 1;
        }
        // sebaliknya jika tidak maka aman
        else{
            $disnotif = 'Aman';
            $condition = 0;
        }

        // kirim data kondisi ke database
        $query = "UPDATE `alarm` SET `state` = '$condition' WHERE `alarm`.`id` = 1";
        $connection->query($query);
    }
}

?>