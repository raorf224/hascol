<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
ini_set('max_execution_time', -1);
date_default_timezone_set("Asia/Karachi");
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 30; URL=$url1");
// Database connection details
include("../config.php");

if (isset($_GET['accesskey'])) {
    $access_key_received = $_GET['accesskey'];
    $access_key = "12345";

    if ($access_key_received !== $access_key) {
        die('Invalid access key.');
    }
    echo 'Night Voilation Service Start time ' . date('Y-m-d H:i:s') . "<br>";

    $current_time = date('d M Y H:i:s');
    $current_hour = date('H', strtotime($current_time));

    if ($current_hour >= 0 && $current_hour <= 6) {
        $night_time = date('Y-m-d');

        $userQuery = "SELECT * FROM users WHERE privilege IN ('admin', 'Cartraige')";
        $userResult = $db->query($userQuery);

        if (!$userResult) {
        firebase_log('HascolBridge', 'system_alert_night_voilation.php', 'Error', "Error fetching user data.");

            die('Error fetching user data: ' . mysqli_error($db));
        }

        while ($user_row = $userResult->fetch_assoc()) {
            $user_id = $user_row['id'];
            $user_name = $user_row['name'];
            echo "------------------------- {$user_name} ----------------------<br>";

            $currentDate = date("Y-m-d H:i:s");

            // Query for overspeeding vehicles
            $overspeedQuery = "SELECT dc.latestPosition_id as pos_id, dc.name as vehicle_name, dc.location as address, 
                       dc.speed, dc.time, dc.id as vehicle_id, dc.ignition,dc.lat,dc.lng
                FROM devicesnew as dc
                JOIN users_devices_new ud ON dc.id = ud.devices_id
                WHERE dc.time >= '{$night_time} 00:00:00'
                  AND dc.time <= '{$night_time} 05:59:59'
                  AND ud.users_id = '$user_id'";
            $overspeedResult = $db->query($overspeedQuery);

            if (!$overspeedResult) {
                die('Error fetching overspeed data: ' . mysqli_error($db));
            }

            while ($vehicle = $overspeedResult->fetch_assoc()) {
                $pos_id = $vehicle['pos_id'];
                $vehicle_name = $vehicle['vehicle_name'];
                $address = $vehicle['address'];
                $speed = $vehicle['speed'];
                $time = $vehicle['time'];
                $ignition = $vehicle['ignition'];
                $vehicle_id = $vehicle['vehicle_id'];
                $lat = $vehicle['lat'] ?? 'N/A';
                $lng = $vehicle['lng'] ?? 'N/A';
                $coordinates = $lat . ', ' . $lng;

                $alertQuery = "SELECT * 
                    FROM driving_alerts_new 
                    WHERE type = 'Night time violations' 
                      AND device_id = '$vehicle_id'
                      AND created_by = '$user_id'
                      AND created_at >= CURDATE()
                      AND log = 0 
                      AND in_time != '' 
                    ORDER BY id DESC LIMIT 1";
                $alertResult = $db->query($alertQuery);

                if (!$alertResult) {
                    die('Error fetching alert data: ' . mysqli_error($db));
                }

                if ($ignition === 'ON' && $speed != '0') {
                    if ($alertResult->num_rows === 0) {
                        $message = "{$vehicle_name} Violate Night time violations";
                        $in_time = date('Y-m-d H:i:s');

                        $insertAlert = "INSERT INTO driving_alerts_new 
                            (pos_id, type, message, device_id, created_at, created_by, lat, lng, speed, in_time, time, location,start_co) 
                            VALUES ('$pos_id', 'Night time violations', '$message', '$vehicle_id', '$currentDate', '$user_id', '', '', '$speed', '$in_time', '$time', '$address','$coordinates')";
                        $db->query($insertAlert);
                    }
                } else if ($alertResult->num_rows > 0) {
                    $alertRow = $alertResult->fetch_assoc();
                    $alert_id = $alertRow['id'];
                    $in_time = $alertRow['in_time'];
                    $start_co = $alertRow['start_co'];
                    $out_time = date('Y-m-d H:i:s');
                    $last_alert_time = $in_time;
                    $cur_time = $out_time;


                    $cleanedString = str_replace(". ", " ", $start_co); 
                    $co_data = explode(" ", $cleanedString);

                    $s_lat = $co_data[0] ?? '0, 0';
                    $s_lng = $co_data[1] ?? '0, 0';

                    $total_kms = distancePythagorean($s_lat, $s_lng, $lat, $lng);

                    $to_time = strtotime($cur_time);
                    $from_time = strtotime($last_alert_time);
                    $diff = round(abs($to_time - $from_time) / 60, 2);

                    $updateAlert = "UPDATE driving_alerts_new 
                            SET out_time = '$out_time',
                                log = 1, 
                                end_co = '$coordinates', 
                                total_km = '$total_kms', 
                                duration = '$diff' 
                            WHERE id = '$alert_id'";
                    $db->query($updateAlert);

                }
            }
        }

        firebase_log('HascolBridge', 'system_alert_night_voilation.php', 'Success', "Run successfully.");

    }
} else {
    die('Access key is required.');
}

function distancePythagorean($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Radius of Earth in kilometers

    // Convert degrees to radians
    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    // Calculate differences
    $delta_x = ($lon2 - $lon1) * cos(($lat1 + $lat2) / 2);
    $delta_y = ($lat2 - $lat1);

    // Apply Pythagorean theorem
    $distance = sqrt(pow($delta_x, 2) + pow($delta_y, 2)) * $earth_radius;

    return $distance; // Distance in KM
}

mysqli_close($db);
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

