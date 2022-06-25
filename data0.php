<?php

// $ThetaBearing = atan2((-sin(112.778480 - 112.777775) * cos(-7.208559)), (cos(-7.208234) * sin(7.208559) - sin(-7.208234) * cos(-7.208559) * cos(112.778480 - 112.777775)));
// $ThetaBearing = rad2deg($ThetaBearing);

// echo rad2deg($ThetaBearing);

$IDContent = file_get_contents("https://ais-socket.ppns.ac.id/AIS/coba1.php");

// print_r($IDContent);

$DOM = new DOMDocument();
@$DOM->loadHTML($IDContent);

$IDDetail = $DOM->getElementsByTagName('td');
foreach($IDDetail as $NodeIDDetail) {
    $DataTableIDDetailHTML[] = trim($NodeIDDetail->textContent);
}

// print_r($DataTableIDDetailHTML);

$count = 1;
for ($x = 1; $x <= 20; $x++) {
    $shipsID[$x] = $DataTableIDDetailHTML[$count];
    $shipsName[$x] = $DataTableIDDetailHTML[$count+2];
    $shipsLat[$x] = $DataTableIDDetailHTML[$count+5];
    $shipsLon[$x] = $DataTableIDDetailHTML[$count+6];
    $shipsSog[$x] = $DataTableIDDetailHTML[$count+7];
    $shipsCog[$x] = $DataTableIDDetailHTML[$count+8];
    $shipsHdg[$x] = $DataTableIDDetailHTML[$count+9];
    $count += 18; // count = count + 18
}

$bmkgdata = file_get_contents("https://peta-maritim.bmkg.go.id/public_api/pelabuhan/0007_Tanjung%20Perak.json");
$result = json_decode($bmkgdata, true);

// print_r($result);

$wind_min = $result['data'][0]['wind_speed_min'];
$wind_max = $result['data'][0]['wind_speed_max'];
$wave_desc = $result['data'][0]['wave_desc'];

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) { // radius in meters
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $latFromBear = $latitudeFrom;
    $lonFromBear = $longitudeFrom;
    $latToBear = $latitudeTo;
    $lonToBear = $longitudeTo;

    // $latFrom = -7.208234;
    // $lonFrom = 112.778480;
    // $latTo = -7.208559;
    // $lonTo = 112.777775;

    $latDeltaBear = $latTo - $latFrom;
    $lonDeltaBear = $lonTo - $lonFrom;
  
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    $meters = $angle * $earthRadius;
    $kilometers = $meters / 1000.0;

    $meters = round($meters, 3);
    $kilometers = round($kilometers, 3);

    // $ThetaBearing = atan2(-(sin($lonDelta) * cos($lonTo)), (cos($latFrom) * sin($lonTo)) - (sin($latFrom) * cos($latTo) * cos($lonDelta)));
    // $ThetaBearing = atan2(((-sin(112.778480 - 112.777775)) * cos(-7.208559)), cos(-7.208234) * sin(-7.208559) - sin(-7.208234) * cos(-7.208559) * cos(112.778480 - 112.777775));
    // $ThetaBearing = rad2deg($ThetaBearing);
    // $ThetaBearing = round($ThetaBearing, 5);
    // $ThetaBearing = rad2deg($ThetaBearing);

    $y = sin($lonDeltaBear) * cos($lonToBear);
    $x = cos($latFromBear)*sin($lonToBear) - sin($latFromBear)*cos($latToBear)*cos($lonDeltaBear);
    $θ = atan2($y, $x);
    $brng = ($θ*180/(pi()) + 360) % 360; // in degrees
    // $brng = rad2deg($θ);
    $ThetaBearing = $brng;
    // $ThetaBearing = $θ;

    return compact('angle', 'kilometers', 'meters', 'ThetaBearing');
}


if(isset($_POST['submit'])){
    if(!empty($_POST['ShipsA']) && !empty($_POST['ShipsB'])) {
        $ShipsA = $_POST['ShipsA'];
        $ShipsB = $_POST['ShipsB'];

        $htmlContent = file_get_contents("https://ais-socket.ppns.ac.id/AIS/AIS_RT_TA3.php?MMSI1=$ShipsA&MMSI2=$ShipsB");
        $DOM = new DOMDocument();
        @$DOM->loadHTML($htmlContent);
        $Detail = $DOM->getElementsByTagName('td');

        foreach($Detail as $NodeDetail) {
            $DataTableDetailHTML[] = trim($NodeDetail->textContent);
        }

        $id1 = $DataTableDetailHTML[1];
        $lat1 = $DataTableDetailHTML[4];
        $lon1 = $DataTableDetailHTML[5];
        $hdg1 = $DataTableDetailHTML[9];

        $id2 = $DataTableDetailHTML[14];
        $lat2 = $DataTableDetailHTML[17];
        $lon2 = $DataTableDetailHTML[18];
        $hdg2 = $DataTableDetailHTML[22];

        if($hdg1 == 511){
            $hdgnew1 = $hdg1 - 360;
        }
        else{
            $hdgnew1 = $hdg1;
        }

        if($hdg2 == 511){
            $hdgnew2 = $hdg2 - 360;
        }
        else{
            $hdgnew2 = $hdg2;
        }

        if($hdgnew1 >= 0 && $hdgnew1 <= 90){
            $kudhdg1 = 1;
        }
        else if($hdgnew1 >= 90 && $hdgnew1 <= 180){
            $kudhdg1 = 2;
        }
        else if($hdgnew1 >= 180 && $hdgnew1 <= 270){
            $kudhdg1 = 3;
        }
        else if($hdgnew1 >= 270 && $hdgnew1 <= 360){
            $kudhdg1 = 4;
        }

        if($hdgnew2 >= 0 && $hdgnew2 <= 90){
            $kudhdg2 = 1;
        }
        else if($hdgnew2 >= 90 && $hdgnew2 <= 180){
            $kudhdg2 = 2;
        }
        else if($hdgnew2 >= 180 && $hdgnew2 <= 270){
            $kudhdg2 = 3;
        }
        else if($hdgnew2 >= 270 && $hdgnew2 <= 360){
            $kudhdg2 = 4;
        }

        if(abs($kudhdg1 - $kudhdg2) == 1 || abs($kudhdg1 - $kudhdg2) == 3){
            $hdgnotif = 'Bahaya';
        }
        else{
            $hdgnotif = 'Aman';
        }

        // $lat1 = -7.1847067;
        // $lon1 = 112.7270617;

        // $lat2 = -7.1864517;
        // $lon2 = 112.7331133;

        $distance =  haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2);
    }
}

// // $htmlContent = file_get_contents("https://ais-socket.ppns.ac.id/AIS/AIS_RT_TA2.php?MMSI=525014087");

	
// print_r($htmlContent);

// $Header = $DOM->getElementsByTagName('th');


// //#Get header name of the table
// foreach($Header as $NodeHeader) {
//     $DataTableHeaderHTML[] = trim($NodeHeader->textContent);
// }

// print_r($DataTableHeaderHTML);
// print_r($DataTableDetailHTML);

// echo "$id1 <br> $lat1 <br> $lon1 <br> $id2 <br> $lat2 <br> $lon2 <br>";

// print_r($distance['meters']);

// die();

?>