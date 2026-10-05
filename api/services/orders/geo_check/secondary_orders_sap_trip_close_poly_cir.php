<?php
// secondary_trip_close_service.php
ini_set('max_execution_time', 0);
set_time_limit(5000);

include("../../../config.php");

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");

echo "<h1>✅ Secondary Orders Trip Close - Circle & Polygon Support</h1><br>";

$sql = "SELECT 
    oi.*, 
    dl.`co-ordinates` AS co, 
    dl.`form_status` AS polygone_points, 
    dc.id AS vehicle_id, 
    dc.name as vehicle 
FROM 
    order_info AS oi 
JOIN 
    dealers AS dl ON dl.sap_no = oi.customer_id 
LEFT JOIN 
    devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicle 
WHERE 
    oi.status = 1 
    AND oi.is_tracker = 1 
    AND oi.created_at >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)";

$result = mysqli_query($db, $sql);

if (!$result) {
    firebase_log('HascolBridge', 'secondary_trip_close_service.php', 'Error', '❌ Main query failed:');
    die("Main query failed: " . mysqli_error($db));
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $co = trim($row['co']);
        $polygon_str = trim($row['polygone_points']);
        $sub_order_id = $row['id'];
        $v_num = $row['vehicle'];
        $vehicle_id = $row['vehicle_id'];

        if (!$vehicle_id) {
            echo "⚠️ Vehicle ID not found for TRIP-ID: $sub_order_id<br>";
            continue;
        }

        $vehicle_data_query = "SELECT * FROM devicesnew WHERE id = '$vehicle_id'";
        $vehicle_data_result = mysqli_query($db, $vehicle_data_query);

        if (!$vehicle_data_result) {
            echo "Vehicle query failed: " . mysqli_error($db) . "<br>";
            continue;
        }

        if ($vehicle_row = mysqli_fetch_assoc($vehicle_data_result)) {
            $v_lat = floatval($vehicle_row['lat']);
            $v_lng = floatval($vehicle_row['lng']);

            echo "<br/>🚗 Vehicle: $v_num | ID: $vehicle_id | TRIP-ID: $sub_order_id<br/>";
            echo "---------------------------------------------------<br/>";

            process_geofence($v_lat, $v_lng, $v_num, $vehicle_id, $co, $polygon_str, $db, $sub_order_id);
        }
    }

    firebase_log('HascolBridge', 'secondary_trip_close_service.php', 'Success', "Run successfully.");
} else {
    echo "<h3>No Records Found to Check</h3>";
}

function process_geofence($v_lat, $v_lng, $v_num, $v_id, $co, $polygon_str, $db, $sub_order_id) {
    $in_time = date('Y-m-d H:i:s');
    $threshold = 0.155;
    $inside_polygon = false;
    $inside_circle = false;
    $distance_polygon = null;
    $distance_circle = null;

    // 1. Polygon check
    if (!empty($polygon_str) && strpos($polygon_str, ';') !== false) {
        $points = [];
        foreach (explode(';', $polygon_str) as $point) {
            $coords = explode(',', trim($point));
            if (count($coords) === 2) {
                $points[] = [floatval(trim($coords[0])), floatval(trim($coords[1]))];
            }
        }

        if (count($points) >= 3) {
            $inside_polygon = is_in_polygon($v_lat, $v_lng, $points);
            echo "🧭 Polygon Geofence: " . ($inside_polygon ? "INSIDE" : "OUTSIDE") . "<br/>";
            if (!$inside_polygon) {
                $distance_polygon = map_api($v_lat, $v_lng, $points[0][0], $points[0][1]);
                echo "📏 Distance from polygon: " . round($distance_polygon, 4) . " km<br/>";
            }
        } else {
            echo "⚠️ Invalid polygon points<br/>";
        }
    }

    // 2. Circle check
    if (!empty($co) && strpos($co, ',') !== false) {
        $coords = explode(',', $co);
        if (count($coords) == 2) {
            $c_lat = floatval(trim($coords[0]));
            $c_lng = floatval(trim($coords[1]));
            $distance_circle = map_api($v_lat, $v_lng, $c_lat, $c_lng);
            $inside_circle = ($distance_circle !== null && $distance_circle <= $threshold);
            echo "🧭 Circle Geofence: " . ($inside_circle ? "INSIDE" : "OUTSIDE") . "<br/>";
            echo "📏 Distance from circle: " . round($distance_circle, 4) . " km<br/>";
        }
    }

    // 3. Close trip if inside
    if ($inside_polygon || $inside_circle) {
        $update_sql = "UPDATE order_info 
            SET close_time='$in_time', 
                status=2, 
                remain_distance=0, 
                last_check='$in_time' 
            WHERE id='$sub_order_id'";
        
        if (mysqli_query($db, $update_sql)) {
            echo "✅ Trip Closed at $in_time<br/>";
            call_secondary_email_api($sub_order_id, $db);
        } else {
            echo "❌ Error closing trip: " . mysqli_error($db) . "<br/>";
        }
    } else {
        $remain_distance = null;
        if ($distance_circle !== null && $distance_polygon !== null) {
            $remain_distance = min($distance_circle, $distance_polygon);
        } elseif ($distance_circle !== null) {
            $remain_distance = $distance_circle;
        } elseif ($distance_polygon !== null) {
            $remain_distance = $distance_polygon;
        } else {
            $remain_distance = 'N/A';
        }

        $update_sql = "UPDATE order_info 
            SET last_check='$in_time', 
                remain_distance='$remain_distance' 
            WHERE id='$sub_order_id'";
        
        if (mysqli_query($db, $update_sql)) {
            echo "📌 Trip updated with distance: $remain_distance km<br/>";
        } else {
            echo "❌ Error updating trip: " . mysqli_error($db) . "<br/>";
        }
        echo "🚫 Vehicle not inside geofence.<br/>";
    }
}

function call_secondary_email_api($trip_id, $db) {
    // Check if email already sent
    $check_sql = "SELECT * FROM secondary_trip_email_logs WHERE trip_id = '$trip_id' AND email_sent = 1";
    $check_result = mysqli_query($db, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "⚠️ Email already sent for Trip ID: $trip_id<br/>";
        return;
    }
    
    // API URL
    $api_url = "http://151.106.17.246:8080/hascolBridgeApis/emailer/send_secondary_trip_close_email.php";
    
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo "❌ cURL Error: " . curl_error($ch) . "<br/>";
    }
    
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
        if (
            ($polygon[$i][1] > $lng) != ($polygon[$j][1] > $lng) &&
            ($lat < ($polygon[$j][0] - $polygon[$i][0]) * ($lng - $polygon[$i][1]) / ($polygon[$j][1] - $polygon[$i][1]) + $polygon[$i][0])
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

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