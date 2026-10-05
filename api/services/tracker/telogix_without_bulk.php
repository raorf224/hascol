<?php
ini_set('max_execution_time', -1);
date_default_timezone_set("Asia/Karachi");

// Get the current server timestamp for comparison
$current_time_stamp = time();

// Refresh page every 30 seconds
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 70; URL=$url1");

include("../../config.php");
echo date("d-m-Y H:i:s") . "<br>";

function clean($string)
{
    return preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '-', $string));
}

// API call
$tel_link_by = "https://mobile.telogix.com.pk/GetUserInfo.asmx/GetUserData?uname=info@hascol.com&upwd=hpl@1234";
$tel_file_by = file_get_contents($tel_link_by);

if ($tel_file_by === false) {
    api_log('', 'Failed to fetch data from API', $db);
    die("❌ Error fetching data from the API.");
}

$tel_cleaned = str_replace(
    ['<string xmlns="http://tempuri.org/">', '<?xml version="1.0" encoding="utf-8"?>', '</string>'],
    '',
    $tel_file_by
);
$arrayteletix = json_decode($tel_cleaned, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    api_log($tel_cleaned, json_last_error_msg(), $db);
    die("❌ JSON Decode Error: " . json_last_error_msg());
}

api_log($tel_cleaned, null, $db);

// Get existing device times in one query
$device_names = array_map(function ($v) {
    return "'" . mysqli_real_escape_string($GLOBALS['db'], $v['vehicleName']) . "'"; 
}, $arrayteletix);

$device_lookup = [];
if (!empty($device_names)) {
    $res_devices = mysqli_query($db, "SELECT id, name, time FROM devicesnew WHERE name IN (" . implode(",", $device_names) . ")");
    while ($row = mysqli_fetch_assoc($res_devices)) {
        $device_lookup[$row['name']] = $row;
    }
}

// Get existing positions_log entries (vehicle_name + time) - Filtered for future time
$position_keys = [];
foreach ($arrayteletix as $row) {
    $api_time_stamp = strtotime(str_replace("T", " ", $row["gpsTime"]));

    // Skip if API time is greater than current server time
    if ($api_time_stamp > $current_time_stamp) {
        continue;
    }

    // Format time properly for lookup (Y-m-d H:i:s)
    $formatted_time = date('Y-m-d H:i:s', $api_time_stamp);
    $position_keys[] = "'" . mysqli_real_escape_string($db, $row["vehicleName"] . "_" . $formatted_time) . "'";
}

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
$skipped_future_count = 0; // Counter for skipped records

foreach ($arrayteletix as $rowteletix) {
    // Proper time formatting and conversion to timestamp
    $api_time = str_replace("T", " ", $rowteletix["gpsTime"]);
    $api_time_stamp = strtotime($api_time);

    // **<<< ADDED LOGIC: Check if API time is in the future >>>**
    // Check if the API time is greater than the current server time
    if ($api_time_stamp > $current_time_stamp) {
        $skipped_future_count++;
        // Skip this record (no update, no insert)
        continue;
    }
    // **<<< END ADDED LOGIC >>>**

    $VRN = mysqli_real_escape_string($db, $rowteletix["vehicleName"]);
    $time = date('Y-m-d H:i:s', $api_time_stamp); // Use the calculated timestamp
    $key = $VRN . "_" . $time;
    $imei = "teletix" . clean($VRN);
    // if($VRN=='JQ-0671'){

    
    // Cast numeric values explicitly
    $lat = floatval($rowteletix['lat']);
    $lng = floatval($rowteletix['lng']);
    $angle = floatval($rowteletix['Direction']);
    $speed = floatval($rowteletix['speed']);
    $odometer = floatval($rowteletix['mileage']);
    $location = mysqli_real_escape_string($db, $rowteletix['location']);
    $ignition = ($speed > 0) ? 'ON' : 'OFF';

    $device = $device_lookup[$VRN] ?? null;
    $device_id = $device['id'] ?? null;
    $lasttime = $device['time'] ?? '2020-01-01 00:00:00';

    // echo $VRN .'<br>';
    // echo $time .'<br>';
    // Only proceed if API time is newer than the last recorded time in DB
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
                trackername='telogix'
                WHERE name='$VRN'";
        } else {
            $insert_devices[] = "INSERT INTO devicesnew 
                (name,organisation, trackername, tracker, speed, speedlimit, lat, lng, location, time, angle, imei, odometer, ignition, lasttime, activedate)
                VALUES 
                ('$VRN','$VRN', 'teletix', 'teletix', '$speed', '60', '$lat', '$lng', '$location', '$time', '$angle', '$imei', '$odometer', '$ignition', NOW(), NOW())";
        }

        if (!isset($existing_positions[$key])) {
            // If device_id is null, insert SQL NULL without quotes
            $device_id_value = $device_id ? "'$device_id'" : "NULL";

            $insert_positions[] = "(
                '$VRN', 
                $lat, 
                $lng, 
                '$location', 
                $speed, 
                '$ignition', 
                $odometer, 
                $angle, 
                'teletix', 
                '$time', 
                $device_id_value
            )";
        }
    }
// }
}

// Execute update queries
echo "ℹ️ Updating " . count($update_devices) . " devices.<br>";
foreach ($update_devices as $q) {
    // echo $q;
    mysqli_query($db, $q);
}

// Execute insert device queries
echo "ℹ️ Inserting " . count($insert_devices) . " new devices.<br>";
foreach ($insert_devices as $q) {
    mysqli_query($db, $q);
    $new_id = mysqli_insert_id($db);
    if ($new_id) {
        mysqli_query($db, "INSERT INTO users_devices_new (users_id, devices_id, subacc_id, show_authority) VALUES 
            ('1', '$new_id', '0', '0'),
            ('121', '$new_id', '2', '1')");
    }
}

// Insert into positions_log with error check
if (!empty($insert_positions)) {
    $q = "INSERT INTO positions_log (vehicle_name, latitude, longitude, address, speed, power, odometer, course, tracker, time, device_id) 
        VALUES " . implode(",", $insert_positions);
    // echo $q . "<br><br>";  // Debug print query

    if (mysqli_query($db, $q)) {
        echo "✅ Inserted " . count($insert_positions) . " positions.<br>";
    } else {
        echo "❌ Insert Error: " . mysqli_error($db) . "<br>";
    }
} else {
    echo "ℹ️ No new positions to insert.<br>";
}

if ($skipped_future_count > 0) {
    echo "⚠️ Skipped **$skipped_future_count** records (API time was in the future).<br>";
}

echo "Process Completed.<br>";
echo date("d-m-Y H:i:s") . "<br>";

mysqli_close($db);

function api_log($response_teletix, $error_teletix, $db)
{
    $api = $db->real_escape_string('Telogix');
    $created_at = date("Y-m-d H:i:s");
    $result = $error_teletix ? 'error' : 'success';
    $response_log = $db->real_escape_string($error_teletix ?: "Run successfully.");

    firebase_log('HascolBridge', 'telogix_without_bulk.php', $result, $response_log);


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