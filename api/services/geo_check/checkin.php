<?php
ini_set('max_execution_time', '0');
error_reporting(0);
include("../../config.php");

$url = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url");

echo "<h1>Fence Check IN Service</h1><br>";

$sql = "SELECT * FROM devicesnew WHERE speed > 0";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $v_lat = $row['lat'];
        $v_lng = $row['lng'];
        $v_num = $row['organisation'];
        $v_id  = $row['id'];
        $is_load = ''; // Optional flag, adjust if needed

        echo "<br/>Vehicle = $v_num | ID = $v_id<br/>";
        echo "---------------------------------------------------<br/>";

        checkGeofences($v_lat, $v_lng, $v_num, $v_id, $is_load);
    }
} else {
    echo "<h3>No moving vehicles found.</h3>";
}

function checkGeofences($v_lat, $v_lng, $v_num, $v_id, $is_load) {
    $dbs = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
    $sql_geo = "SELECT id, consignee_name, Coordinates, geotype FROM geofenceing 
                WHERE type = 'circle' AND geotype IN ('depot', 'black Spote') 
                ORDER BY id DESC";
    $result_geo = mysqli_query($dbs, $sql_geo);

    while ($row = mysqli_fetch_array($result_geo)) {
        [$c_lat, $c_lng] = explode(',', $row['Coordinates']);
        $c_lat = floatval($c_lat);
        $c_lng = floatval($c_lng);
        $geotype = $row['geotype'];
        $geo_id = $row['id'];
        $radius_km = ($geotype == 'depot') ? 5 : 0.155;

        // Haversine simplified check
        $ky = 40000 / 360;
        $kx = cos(pi() * $c_lat / 180.0) * $ky;
        $dx = abs($c_lng - $v_lng) * $kx;
        $dy = abs($c_lat - $v_lat) * $ky;
        $distance = sqrt(($dx * $dx) + ($dy * $dy));

        if ($distance <= $radius_km) {
            $in_time = date('Y-m-d H:i:s');
            echo "IN TIME => $in_time<br/>";
            echo "Distance $distance <= $radius_km (Geofence)<br/>";

            logGeofenceEntry($v_id, $geo_id, $in_time, $is_load);
        }
    }
}

function logGeofenceEntry($v_id, $geo_id, $in_time, $is_load) {
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $check_sql = "SELECT * FROM geo_check 
                  WHERE veh_id = '$v_id' AND geo_id = '$geo_id' AND log = '0'";
    $exists = mysqli_num_rows(mysqli_query($db, $check_sql)) > 0;

    if ($exists) {
        echo "Already IN<br/>";
    } else {
        $insert_sql = "INSERT INTO geo_check (veh_id, geo_id, in_time, log, depot_status) 
                       VALUES ('$v_id', '$geo_id', '$in_time', '0', '$is_load')";
        if (mysqli_query($db, $insert_sql)) {
            echo "✅ Geofence log created<br/>";
        } else {
            echo "❌ Error: " . mysqli_error($db) . "<br/>";
        }
    }
}

mysqli_close($db);
?>
