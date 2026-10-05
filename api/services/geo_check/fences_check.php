<?php
ini_set('max_execution_time', '0');
include("../../config.php");
$url = $_SERVER['REQUEST_URI'];
header("Refresh: 60; URL=$url");
echo "<h1>✅ Optimized Fence IN/OUT Service</h1><br>";
echo "Start: " . date("Y-m-d H:i:s") . "<br><br>";

// Step 1: Fetch all vehicles once
$vehicles = mysqli_query($db, "
    SELECT id, lat, lng, organisation 
    FROM devicesnew 
    WHERE lat IS NOT NULL AND lng IS NOT NULL AND lat != 0 AND lng != 0
");

if (mysqli_num_rows($vehicles) == 0) {
    echo "<h3>No active vehicles found</h3>";
    exit;
}

// Step 2: Fetch all geofences once
$fences_result = mysqli_query($db, "
    SELECT id, geotype, type, Coordinates 
    FROM geofenceing 
    WHERE geotype IN ('depot', 'black Spote', 'base', 'hpl_parking')
");
$fences = mysqli_fetch_all($fences_result, MYSQLI_ASSOC);

// Preload existing active check-ins for faster lookup
$checkins_result = mysqli_query($db, "SELECT id, veh_id, geo_id, in_time FROM geo_check WHERE log = 0");
$active_checkins = [];
while ($row = mysqli_fetch_assoc($checkins_result)) {
    $active_checkins[$row['veh_id']][$row['geo_id']] = $row;
}

// Step 3: Process each vehicle in memory
foreach ($vehicles as $vehicle) {
    $v_id = (int)$vehicle['id'];
    $v_lat = (float)$vehicle['lat'];
    $v_lng = (float)$vehicle['lng'];
    $v_name = $vehicle['organisation'];

    foreach ($fences as $fence) {
        $geo_id = (int)$fence['id'];
        $coords = $fence['Coordinates'];
        $inside = false;

        // Detect polygon or circle
        if (strpos($coords, ';') !== false) {
            $polygon = [];
            foreach (explode(';', $coords) as $pt) {
                $c = explode(',', $pt);
                if (count($c) == 2) $polygon[] = [floatval($c[1]), floatval($c[0])];
            }
            if (count($polygon) >= 3) $inside = is_in_polygon($v_lat, $v_lng, $polygon);
        } else {
            $c = explode(',', $coords);
            if (count($c) == 2) {
                $distance = haversine($v_lat, $v_lng, (float)$c[0], (float)$c[1]);
                $inside = $distance <= 0.155; // ~150m radius
            }
        }

        $already_in = isset($active_checkins[$v_id][$geo_id]);

        // Check-IN
        if ($inside && !$already_in) {
            $in_time = date('Y-m-d H:i:s');
            mysqli_query($db, "
                INSERT INTO geo_check (veh_id, geo_id, in_time, log, depot_status)
                VALUES ('$v_id', '$geo_id', '$in_time', 0, '')
            ");
            $active_checkins[$v_id][$geo_id] = ['in_time' => $in_time];
            echo "✅ [$v_name] Check-IN at $in_time (Geo ID: $geo_id)<br>";
        }

        // Check-OUT
        if (!$inside && $already_in) {
            $in_time = $active_checkins[$v_id][$geo_id]['in_time'];
            $out_time = date('Y-m-d H:i:s');
            $duration = round((strtotime($out_time) - strtotime($in_time)) / 60, 2);

            mysqli_query($db, "
                UPDATE geo_check 
                SET out_time = '$out_time', log = 1, in_duration = '$duration' 
                WHERE veh_id = '$v_id' AND geo_id = '$geo_id' AND log = 0
            ");

            mysqli_query($db, "
                INSERT INTO geo_check_audit (veh_id, geo_id, in_time, out_time, in_duration)
                VALUES ('$v_id', '$geo_id', '$in_time', '$out_time', '$duration')
            ");

            unset($active_checkins[$v_id][$geo_id]);
            echo "🚪 [$v_name] Check-OUT at $out_time (Geo ID: $geo_id, Duration: $duration mins)<br>";
        }
    }
}

echo "<br>✅ Completed: " . date("Y-m-d H:i:s");

// Firebase log (optional)
firebase_log('HascolBridge', 'fences_check.php', 'Success', 'Run successfully.');

mysqli_close($db);

function haversine($lat1, $lon1, $lat2, $lon2) {
    $R = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) ** 2;
    return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
}

function is_in_polygon($lat, $lng, $polygon) {
    $inside = false;
    $j = count($polygon) - 1;
    for ($i = 0; $i < count($polygon); $i++) {
        if (
            ($polygon[$i][1] > $lng) != ($polygon[$j][1] > $lng) &&
            ($lat < ($polygon[$j][0] - $polygon[$i][0]) * ($lng - $polygon[$i][1]) / ($polygon[$j][1] - $polygon[$i][1]) + $polygon[$i][0])
        ) $inside = !$inside;
        $j = $i;
    }
    return $inside;
}

function firebase_log($company, $service, $status, $message) {
    $payload = json_encode(compact('company', 'service', 'status', 'message'));
    $ch = curl_init('http://151.106.17.246:8080/firebase_systems_logs/firebase_bridge.php');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    ]);
    curl_exec($ch);
    curl_close($ch);
}
?>
