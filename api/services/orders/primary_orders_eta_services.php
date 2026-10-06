<?php
ini_set('max_execution_time', 0);
set_time_limit(5000);

include("../../config.php");

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");

$access_key = '2170';
$pass = '2170';

echo "<h1>Primary SAP Trip ETA Check Service</h1><br>";

if (!empty($access_key)) {
    if ($pass === $access_key) {

        $sql_query1 = "SELECT 
                oi.*, 
                dc.id AS vehicle_id, 
                dc.name AS vehicle_name 
            FROM 
                primary_movement_sales_orders AS oi
            LEFT JOIN 
                devicesnew AS dc 
            ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles 
            WHERE oi.status = 0 AND oi.created_at >= CURDATE()
            ORDER BY oi.id DESC";

        $result1 = $db->query($sql_query1) or die("Error in SQL query: " . $db->error);

        while ($user = $result1->fetch_assoc()) {
            $id = $user['id'];
            $customer_id = $user['customer_id'];
            $depot_code = $user['depot_code'];
            $vehicle_id = $user['vehicle_id'];
            $is_tracker = ($vehicle_id != '') ? "1" : "0";

            // Get geofences (coordinates + type)
            $depot_geo = getGeofence($db, $depot_code);
            $dealer_geo = getGeofence($db, $customer_id);

            if ($depot_geo && $dealer_geo) {
                // Calculate center points of geofences
                $depot_center = getGeofenceCenter($depot_geo);
                $dealer_center = getGeofenceCenter($dealer_geo);

                if ($depot_center && $dealer_center) {
                    list($geo_lat, $geo_lng) = $depot_center;
                    list($dealers_lat, $dealers_lng) = $dealer_center;

                    // Calculate distance via map API
                    $distance = map_api($geo_lat, $geo_lng, $dealers_lat, $dealers_lng);

                    echo "Distance for Order ID $id: $distance km<br>";

                    if ($distance !== null) {
                        // Calculate ETA based on distance
                        $sql_query2 = "
                            SELECT *, 
                            DATE_ADD(DATE_ADD(created_at, INTERVAL ($distance / 30) HOUR), INTERVAL 20 MINUTE) AS eta_time 
                            FROM primary_movement_sales_orders 
                            WHERE id = '$id'
                        ";

                        $result2 = $db->query($sql_query2) or die("Error in SQL query: " . $db->error);

                        while ($user2 = $result2->fetch_assoc()) {
                            $eta_time = $user2['eta_time'];
                            $created_at = $user2['created_at'];

                            $update = "
                                UPDATE primary_movement_sales_orders SET
                                    status = 1,
                                    start_time = '$created_at',
                                    eta = '$eta_time',
                                    distance = '$distance',
                                    is_tracker = '$is_tracker'
                                WHERE id = '$id'
                            ";

                            if ($db->query($update)) {
                                echo "ETA Updated for ID $id<br>";
                            } else {
                                echo "Error updating ETA for ID $id: " . $db->error . "<br>";
                            }
                        }
                    } else {
                        echo "Error calculating distance for ID $id.<br>";
                    }
                } else {
                    echo "Could not determine centers for geofences for ID $id.<br>";
                }
            } else {
                echo "Geofence data missing for ID $id.<br>";
            }
        }
        firebase_log('HascolBridge', 'primary_orders_eta_services.php', 'Success', "Run successfully.");

    } else {
        echo 'Wrong Key...';
    }
} else {
    echo 'Key is Required';
}

// ---------- Helper Functions ----------

function getGeofence($db, $code) {
    $sql = "SELECT Coordinates, type FROM geofenceing WHERE code = '$code' LIMIT 1";
    $result = mysqli_query($db, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return [
            'coordinates' => $row['Coordinates'],
            'type' => strtolower($row['type'])
        ];
    }
    return null;
}

function getGeofenceCenter($geofence) {
    $coordinates = $geofence['coordinates'];
    $type = $geofence['type'];

    if ($type == 'circle') {
        // Assuming format: "lat,lng,radius" or "lat,lng"
        $parts = explode(',', $coordinates);
        if (count($parts) >= 2) {
            return [floatval(trim($parts[0])), floatval(trim($parts[1]))];
        }
    } elseif ($type == 'polygon'){
        // Coordinates separated by semicolon, each point is "lng,lat"
        // Example: "73.871353,31.738876;73.871225,31.738552;..."
        $points = explode(';', $coordinates);
        $latSum = 0;
        $lngSum = 0;
        $count = 0;

        foreach ($points as $point) {
            $point = trim($point);
            $coords = explode(',', $point);
            if (count($coords) == 2) {
                // In your example lng first, lat second, so swap to lat,lng order:
                $lng = floatval(trim($coords[0]));
                $lat = floatval(trim($coords[1]));

                $latSum += $lat;
                $lngSum += $lng;
                $count++;
            }
        }
        if ($count > 0) {
            return [$latSum / $count, $lngSum / $count];
        }
    } else {
        // fallback, assume lat,lng
        $parts = explode(',', $coordinates);
        if (count($parts) == 2) {
            return [floatval(trim($parts[0])), floatval(trim($parts[1]))];
        }
    }
    return null;
}

function map_api($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
    $url = "http://localhost:8989/route?point=$latitudeFrom,$longitudeFrom&point=$latitudeTo,$longitudeTo&profile=car&locale=en&instructions=false";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['paths'][0]['distance'])) {
        return ($data['paths'][0]['distance'] / 1000); // km
    } else {
        return null;
    }
}

echo "<br><strong>Service Last Run:</strong> " . date('Y-m-d H:i:s');

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
