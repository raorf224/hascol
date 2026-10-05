<?php
// trip_close_service.php
ini_set('max_execution_time', 0);
set_time_limit(5000);
include("../../../config.php");

// Define constants for database connection if not already defined
if (!defined('DB_SERVER')) {
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'Ptoptrack@(!!@');
    define('DB_DATABASE', 'hascolbridge');
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
}

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");

echo "<h1>✅ Primary Orders Trip Close - With Email Notification API</h1><br>";

$sql = "SELECT 
        oi.*, 
        dl.Coordinates AS co, 
        dc.id AS vehicle_id,
        dc.name as vehicle
    FROM 
        primary_movement_sales_orders AS oi 
    JOIN 
        geofenceing AS dl ON dl.code = oi.depot_code 
    LEFT JOIN 
        devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles
    WHERE
        oi.status = 1
        AND oi.is_tracker = 1
        AND oi.created_at >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)";

$result = mysqli_query($db, $sql);

if (!$result) {
    firebase_log('HascolBridge', 'trip_close_service.php', 'Error', '❌ Main query failed:');
    die("❌ Main query failed: " . mysqli_error($db));
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_order_id = $row['id'];
        $v_num = $row['vehicle'];
        $vehicle_id = $row['vehicle_id'];
        $co = $row['co'];

        if (empty($vehicle_id)) {
            echo "⚠️ Vehicle ID not found for TRIP-ID: $sub_order_id<br>";
            continue;
        }

        $vehicle_result = mysqli_query($db, "SELECT * FROM devicesnew WHERE id = '$vehicle_id'");
        if (!$vehicle_result) {
            echo "❌ Vehicle query failed: " . mysqli_error($db);
            continue;
        }

        if ($vehicle_data = mysqli_fetch_assoc($vehicle_result)) {
            $v_lat = floatval($vehicle_data['lat']);
            $v_lng = floatval($vehicle_data['lng']);

            echo "<br/>🚗 Vehicle: $v_num | ID: $vehicle_id | TRIP-ID: $sub_order_id<br/>";
            echo "---------------------------------------------------<br/>";
            process_geofence($v_lat, $v_lng, $v_num, $vehicle_id, $co, $db, $sub_order_id);
        }
    }

    firebase_log('HascolBridge', 'trip_close_service.php', 'Success', "Run successfully.");
} else {
    echo "<h3>No Records Found to Check</h3>";
}

function process_geofence($v_lat, $v_lng, $v_num, $v_id, $co, $db, $sub_order_id) {
    $in_time = date('Y-m-d H:i:s');
    $threshold = 0.155; // 155 meters
    $inside = false;
    $distance = null;

    if (empty($co)) {
        echo "⚠️ No coordinates found.<br/>";
        return;
    }

    if (strpos($co, ';') !== false) {
        // Polygon
        $points = [];
        foreach (explode(';', $co) as $point) {
            $coords = explode(',', $point);
            if (count($coords) === 2) {
                $points[] = [floatval(trim($coords[1])), floatval(trim($coords[0]))];
            }
        }

        if (count($points) >= 3) {
            $inside = is_in_polygon($v_lat, $v_lng, $points);
            echo "🧭 Geofence Type: Polygon<br/>";
            $p_lat = $points[0][0];
            $p_lng = $points[0][1];
            $distance = map_api($v_lat, $v_lng, $p_lat, $p_lng);
            echo "📏 Distance: " . round($distance, 4) . " km | Threshold: $threshold km<br/>";
        } else {
            echo "⚠️ Invalid polygon coordinates<br/>";
        }
    } else {
        // Circle
        $coords = explode(',', $co);
        if (count($coords) == 2) {
            $c_lat = floatval(trim($coords[0]));
            $c_lng = floatval(trim($coords[1]));
            $distance = map_api($v_lat, $v_lng, $c_lat, $c_lng);
            echo "🧭 Geofence Type: Circle<br/>";
            echo "📏 Distance: " . round($distance, 4) . " km | Threshold: $threshold km<br/>";
            $inside = ($distance !== null && $distance <= $threshold);
        } else {
            echo "⚠️ Invalid circle coordinates<br/>";
        }
    }

    if ($inside) {
        $update_sql = "UPDATE primary_movement_sales_orders 
            SET close_time = '$in_time', 
                status = 2, 
                remain_distance = 0, 
                last_check = '$in_time' 
            WHERE id = '$sub_order_id'";
        
        if (mysqli_query($db, $update_sql)) {
            echo "✅ Trip closed successfully at $in_time<br/>";
            
            // Call API with only trip_id
            call_email_api($sub_order_id, $db);
        } else {
            echo "❌ Error closing trip: " . mysqli_error($db) . "<br/>";
        }
    } else {
        $remain_distance = isset($distance) ? round($distance, 4) : 'N/A';
        echo "📌 Remain Distance: $remain_distance km<br/>";
        $update_sql = "UPDATE primary_movement_sales_orders 
            SET last_check = '$in_time', 
                remain_distance = '$remain_distance' 
            WHERE id = '$sub_order_id'";
        
        if (mysqli_query($db, $update_sql)) {
            echo "📌 Trip updated with distance info.<br/>";
        } else {
            echo "❌ Error updating trip: " . mysqli_error($db) . "<br/>";
        }
        echo "🚫 Vehicle not inside geofence.<br/>";
    }
}

function call_email_api($trip_id, $db) {
    // Check if email already sent for this trip
    $check_sql = "SELECT * FROM trip_email_logs WHERE trip_id = '$trip_id' AND email_sent = 1";
    $check_result = mysqli_query($db, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "⚠️ Email already sent for Trip ID: $trip_id<br/>";
        return;
    }
    
    // API URL
    $api_url = "http://151.106.17.246:8080/hascolBridgeApis/emailer/send_trip_close_email.php";
    
    // Prepare data - only send trip_id
    $post_data = json_encode([
        'trip_id' => $trip_id
    ]);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($post_data)
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200) {
        echo "📧 Email API called successfully for Trip ID: $trip_id<br/>";
        $result = json_decode($response, true);
        if ($result && $result['status'] == 'success') {
            echo "✅ " . $result['message'] . "<br/>";
        } else {
            echo "⚠️ " . ($result['message'] ?? 'Unknown error') . "<br/>";
        }
    } else {
        echo "❌ Failed to call email API. HTTP Code: $http_code<br/>";
    }
}

function is_in_polygon($lat, $lng, $polygon) {
    $inside = false;
    $j = count($polygon) - 1;
    for ($i = 0; $i < count($polygon); $i++) {
        $lat_i = $polygon[$i][0];
        $lng_i = $polygon[$i][1];
        $lat_j = $polygon[$j][0];
        $lng_j = $polygon[$j][1];

        if (
            ($lng_i > $lng) != ($lng_j > $lng) &&
            ($lat < ($lat_j - $lat_i) * ($lng - $lng_i) / ($lng_j - $lng_i) + $lat_i)
        ) {
            $inside = !$inside;
        }
        $j = $i;
    }
    return $inside;
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
    return isset($data['paths'][0]['distance']) ? $data['paths'][0]['distance'] / 1000 : null;
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
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
}

mysqli_close($db);
echo "<br/><strong>🕒 Last Run:</strong> " . date('Y-m-d H:i:s');
?>