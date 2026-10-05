<?php
ini_set('max_execution_time', -1);
date_default_timezone_set("Asia/Karachi");
include("../../config.php");

// Get the current server timestamp for comparison
$current_time_stamp = time();

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 70; URL=$url1");

echo date("d-m-Y H:i:s") . "<br>";

function clean($string) {
    return preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '-', $string));
}

function convert_ms_to_datetime($ms) {
    return date("Y-m-d H:i:s", $ms / 1000);
}

// Fetch API response
$api_url = "https://tw.portalxs.com/twpxapis/TrackingServices.asmx/TWPXCC_GetVData?secret_key=6kbbUSSMK2WvMSXG1JHSZ80EHSsnUuRSrKX1206WeIKqnW";
$response = file_get_contents($api_url);

if ($response === false) {
    api_log('', 'Failed to fetch data from API', $db);
    die("❌ Error fetching data from the API.");
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    api_log($response, json_last_error_msg(), $db);
    die("❌ JSON Decode Error: " . json_last_error_msg());
}

// Check if _vehicleData exists and is an array
if (!isset($data['_vehicleData']) || !is_array($data['_vehicleData'])) {
    api_log($response, 'Vehicle Data Not Found', $db);
    die("⚠️ Error: _vehicleData missing in response.");
}

// Log success if everything is fine so far
api_log($response, null, $db);

$vehicles = $data['_vehicleData'];

// Get device lookup (Optimized for all vehicles, including future-time ones)
$device_names = array_map(function ($v) {
    return "'" . mysqli_real_escape_string($GLOBALS['db'], $v['RegistrationNumber']) . "'";
}, $vehicles);

$device_lookup = [];
if (!empty($device_names)) {
    $res_devices = mysqli_query($db, "SELECT id, name, time FROM devicesnew WHERE name IN (" . implode(",", $device_names) . ")");
    while ($row = mysqli_fetch_assoc($res_devices)) {
        $device_lookup[$row['name']] = $row;
    }
}

// Prepare position keys (Only for records not in the future)
$position_keys = [];
foreach ($vehicles as $v) {
    // New check: Skip if API time is greater than current server time
    $api_record_ms = preg_replace("/[^0-9]/", "", $v['RecordDateTime']);
    
    // Check if the API time (in seconds) is greater than the current server time (in seconds)
    if (($api_record_ms / 1000) > $current_time_stamp) {
        // Skip this record as it is from the future
        continue; 
    }

    $vrn = $v['RegistrationNumber'];
    $time = convert_ms_to_datetime($api_record_ms);
    $position_keys[] = "'" . mysqli_real_escape_string($db, $vrn . "_" . $time) . "'";
}

// Check existing logs
$existing_positions = [];
if (!empty($position_keys)) {
    $res_positions = mysqli_query($db, "
        SELECT CONCAT(vehicle_name, '_', time) AS keyval FROM positions_log 
        WHERE CONCAT(vehicle_name, '_', time) IN (" . implode(",", $position_keys) . ")
    ");
    while ($row = mysqli_fetch_assoc($res_positions)) {
        $existing_positions[$row['keyval']] = true;
    }
}

$insert_positions = [];
$update_devices = [];
$insert_devices = [];
$skipped_future_count = 0;

foreach ($vehicles as $v) {
    $api_record_ms = preg_replace("/[^0-9]/", "", $v['RecordDateTime']);
    
    // **<<< THE ADDED LOGIC STARTS HERE >>>**
    // Check if the API time (in seconds) is greater than the current server time (in seconds)
    if (($api_record_ms / 1000) > $current_time_stamp) {
        $skipped_future_count++;
        // Skip this record as it is from the future
        continue;
    }
    // **<<< THE ADDED LOGIC ENDS HERE >>>**

    $vrn = mysqli_real_escape_string($db, $v['RegistrationNumber']);
    $time = convert_ms_to_datetime($api_record_ms);
    // echo $vrn .'<br>';
    // echo $time .'<br>';
    $key = $vrn . "_" . $time;

    $lat = $v['Latitude'];
    $lng = $v['Longitude'];
    $speed = $v['Speed'];
    $angle = $v['DirectionDegree'];
    $odometer = $v['Odometer'];
    $location = mysqli_real_escape_string($db, $v['Address']);
    $ignition = ($v['LastIgnitionStatus'] === "True") ? 'ON' : 'OFF';
    $imei = "teletix" . clean($vrn);

    $device = $device_lookup[$vrn] ?? null;
    $device_id = $device['id'] ?? null;
    $lasttime = $device['time'] ?? '2000-01-01 00:00:00';

    if (strtotime($time) > strtotime($lasttime)) {
        if ($device_id) {
            $update_devices[] = "UPDATE devicesnew SET 
                latestPosition_id='$time',
                time='$time',
                lat='$lat',
                lng='$lng',
                angle='$angle',
                ignition='$ignition',
                speed='$speed',
                odometer='$odometer',
                lasttime=NOW(),
                location='$location',
                trackername='teletix'
                WHERE name='$vrn'";
        } else {
            $insert_devices[] = "INSERT INTO devicesnew 
                (name,organisation, trackername, tracker, speed, speedlimit, lat, lng, location, time, angle, imei, odometer, ignition, lasttime, activedate)
                VALUES 
                ('$vrn','$vrn', 'teletix', 'teletix', '$speed', '60', '$lat', '$lng', '$location', '$time', '$angle', '$imei', '$odometer', '$ignition', NOW(), NOW())";
        }

        if (!isset($existing_positions[$key])) {
            $insert_positions[] = "('$vrn', '$lat', '$lng', '$location', '$speed', '$ignition', '$odometer', '$angle', 'teletix', '$time', '$device_id')";
        }
    }
}

// Execute updates
foreach ($update_devices as $q) {
    mysqli_query($db, $q);
}

foreach ($insert_devices as $q) {
    mysqli_query($db, $q);
    $new_id = mysqli_insert_id($db);
    if ($new_id) {
        mysqli_query($db, "INSERT INTO users_devices_new (users_id, devices_id, subacc_id, show_authority) VALUES 
            ('1', '$new_id', '0', '0'),
            ('121', '$new_id', '2', '1')");
    }
}

if (!empty($insert_positions)) {
    $q = "INSERT INTO positions_log 
        (vehicle_name, latitude, longitude, address, speed, power, odometer, course, tracker, time, device_id) 
        VALUES " . implode(",", $insert_positions);
    mysqli_query($db, $q);
    echo "✅ Inserted " . count($insert_positions) . " positions.<br>";
} else {
    echo "ℹ️ No new positions to insert.<br>";
}

if ($skipped_future_count > 0) {
    echo "⚠️ Skipped **$skipped_future_count** records (API time was in the future).<br>";
}

echo "Process Completed.<br>";
echo date("d-m-Y H:i:s") . "<br>";
mysqli_close($db);

// API log helper
function api_log($response_teletix, $error_teletix, $db) {
    $api = $db->real_escape_string('Tracking World');
    $created_at = date("Y-m-d H:i:s");
    $result = $error_teletix ? 'error' : 'success';
    $response_log = $db->real_escape_string($error_teletix ?: 'Run successfully.');
    firebase_log('HascolBridge', 'tw_portalxs.php', $result, $response_log);

    $query = "INSERT INTO apis_log (api, result, response, created_at)
              VALUES ('$api', '$result', '$response_log', '$created_at')";
    $db->query($query);
}

function firebase_log($company, $service, $status, $message) {

    $payload = json_encode([
        'company' => $company,
        'service' => $service,
        'status' => $status,
        'message' => $message
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://151.106.17.246:8080/firebase_systems_logs/firebase_bridge.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $payload, // Data ko JSON string ke roop mein bhejein
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json', // Yeh header ab data format se match karega
        'Content-Length: ' . strlen($payload)
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
}
?>