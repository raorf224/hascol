<?php
include("../config.php");

set_time_limit(500);
ini_set('max_execution_time', -1);
date_default_timezone_set("Asia/Karachi");

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 30; URL=$url1");

echo 'Renew Sales order start time => ' . date('Y-m-d H:i:s') . '<br>';

$access_key = '2170';
$pass = $_GET["key"] ?? '';
$date = date('Y-m-d H:i:s');

if (!empty($pass)) {
    if ($pass === $access_key) {

        $sql_query1 = "SELECT * FROM users WHERE privilege = 'Cartraige'";
        $result1 = $db->query($sql_query1) or die("Error: " . mysqli_error($db));

        while ($user = $result1->fetch_assoc()) {
            $user_id = $user['id'];

            $sql_device = "SELECT dc.organisation AS vehicle_name, dc.id AS vehicle_id 
                FROM users_devices_new AS ud 
                JOIN devicesnew AS dc ON dc.id = ud.devices_id 
                WHERE ud.users_id = '$user_id'";

            $result_device = $db->query($sql_device) or die("Error: " . mysqli_error($db));

            while ($device = $result_device->fetch_assoc()) {
                $vehicle_name = $device['vehicle_name'];
                $vehicle_id = $device['vehicle_id'];

                $current_time = date('Y-m-d H:i:s');

                // ---------------- CHECK PRIMARY TRIP ----------------
                $sql_status_primary = "SELECT status 
                    FROM primary_movement_sales_orders 
                    WHERE is_tracker = 1 
                    AND vehicles = '$vehicle_name'
                    AND created_at >= NOW() - INTERVAL 10 DAY";

                $result_status_primary = $db->query($sql_status_primary) or die("Error: " . mysqli_error($db));

                $has_primary_trip = false;
                while ($row = $result_status_primary->fetch_assoc()) {
                    if ($row['status'] == 1) {
                        $has_primary_trip = true;
                        break;
                    }
                }

                // ---------------- CHECK SECONDARY TRIP ----------------
                $sql_status_secondary = "SELECT status 
                    FROM order_info 
                    WHERE is_tracker = 1 
                    AND vehicle = '$vehicle_name'
                    AND created_at >= NOW() - INTERVAL 10 DAY";

                $result_status_secondary = $db->query($sql_status_secondary) or die("Error: " . mysqli_error($db));

                $has_secondary_trip = false;
                while ($row = $result_status_secondary->fetch_assoc()) {
                    if ($row['status'] == 1) {
                        $has_secondary_trip = true;
                        break;
                    }
                }

                // ---------------- DECIDE WHAT TO UPDATE ----------------
                if ($has_primary_trip) {
                    $update = "UPDATE devicesnew 
                        SET is_on_trip = 1,
                            last_trip_time = '$current_time',
                            trip_type = 'Primary' 
                        WHERE id = '$vehicle_id'";
                    $type = 'Primary';
                } elseif ($has_secondary_trip) {
                    $update = "UPDATE devicesnew 
                        SET is_on_trip = 1,
                            last_trip_time = '$current_time',
                            trip_type = 'Secondary' 
                        WHERE id = '$vehicle_id'";
                    $type = 'Secondary';
                } else {
                    $update = "UPDATE devicesnew 
                        SET is_on_trip = 0,
                            trip_type = NULL 
                        WHERE id = '$vehicle_id'";
                    $type = 'None';
                }

                if (mysqli_query($db, $update)) {
                    echo "✅ [$type] Updated is_on_trip for: $vehicle_name (ID: $vehicle_id)<br>";
                    // firebase_log('HascolBridge', 'in_out_bound_vehicles.php', 'Success', "[$type] $vehicle_name updated successfully.");
                } else {
                    echo "❌ [$type] Update error for: $vehicle_name → " . mysqli_error($db) . "<br>";
                    // firebase_log('HascolBridge', 'in_out_bound_vehicles.php', 'Error', "[$type] $vehicle_name update failed: " . mysqli_error($db));
                }
            }
        }
        firebase_log('HascolBridge', 'in_out_bound_vehicles.php', 'Success', "Run successfully.");


    } else {
        echo '❌ Wrong Key...';
        firebase_log('HascolBridge', 'in_out_bound_vehicles.php', 'Error', 'Wrong access key.');
    }
} else {
    echo '⚠️ Key is Required';
    firebase_log('HascolBridge', 'in_out_bound_vehicles.php', 'Error', 'Key missing in request.');
}

// ---------------- FIREBASE LOG FUNCTION ----------------
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