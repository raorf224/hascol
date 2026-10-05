<?php
// primary_vehicle_checkout_service.php
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

echo "<h1>✅ Primary Vehicle Check-Out Service - Track Vehicle Exit From Site</h1><br>";

// Unn trips ko select karein jo:
// 1. Status closed hai (status = 2)
// 2. is_site_out = 0 (abhi site se bahar nahi nikli)
// 3. close_time set hai
$sql = "SELECT 
    oi.id,
    oi.order_no,
    oi.vehicles,
    oi.close_time,
    oi.is_site_out,
    oi.site_out_time,
    oi.status,
    dc.id AS vehicle_id,
    dl.Coordinates AS co
FROM 
    primary_movement_sales_orders AS oi 
JOIN 
    geofenceing AS dl ON dl.code = oi.depot_code 
LEFT JOIN 
    devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles 
WHERE 
    oi.status = 2 
    AND oi.is_site_out = 0
    AND oi.close_time IS NOT NULL
    AND oi.close_time != '' and oi.is_tracker=1
    AND oi.close_time >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)";

$result = mysqli_query($db, $sql);

if (!$result) {
    firebase_log('HascolBridge', 'primary_vehicle_checkout_service.php', 'Error', '❌ Main query failed:');
    die("❌ Main query failed: " . mysqli_error($db));
}

if (mysqli_num_rows($result) > 0) {
    echo "Found " . mysqli_num_rows($result) . " trips to check for vehicle exit<br/><br/>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        $order_id = $row['id'];
        $order_no = $row['order_no'];
        $vehicle_no = $row['vehicles'];
        $vehicle_id = $row['vehicle_id'];
        $close_time = $row['close_time'];
        $co = trim($row['co']);
        
        if (!$vehicle_id) {
            echo "⚠️ Vehicle ID not found for Order: $order_no (ID: $order_id)<br>";
            continue;
        }
        
        // Get vehicle current location
        $vehicle_query = "SELECT lat, lng FROM devicesnew WHERE id = '$vehicle_id'";
        $vehicle_result = mysqli_query($db, $vehicle_query);
        
        if (!$vehicle_result || mysqli_num_rows($vehicle_result) == 0) {
            echo "⚠️ Vehicle location not found for: $vehicle_no<br>";
            continue;
        }
        
        $vehicle_loc = mysqli_fetch_assoc($vehicle_result);
        $v_lat = floatval($vehicle_loc['lat']);
        $v_lng = floatval($vehicle_loc['lng']);
        
        echo "<br/>🚗 Vehicle: $vehicle_no | Order: $order_no | Trip ID: $order_id<br/>";
        echo "---------------------------------------------------<br/>";
        echo "📍 Current Location: $v_lat, $v_lng<br/>";
        echo "📅 Trip Closed At: $close_time<br/>";
        
        // Check if vehicle is inside site geofence
        $inside_geofence = false;
        $distance = null;
        
        if (!empty($co)) {
            if (strpos($co, ';') !== false) {
                // Polygon check
                $points = [];
                foreach (explode(';', $co) as $point) {
                    $coords = explode(',', $point);
                    if (count($coords) === 2) {
                        // Fix: longitude, latitude → converted to [lat, lng]
                        $points[] = [floatval(trim($coords[1])), floatval(trim($coords[0]))];
                    }
                }
                
                if (count($points) >= 3) {
                    $inside_geofence = is_in_polygon($v_lat, $v_lng, $points);
                    echo "🧭 Polygon Check: " . ($inside_geofence ? "INSIDE" : "OUTSIDE") . "<br/>";
                    
                    if (!$inside_geofence) {
                        $p_lat = $points[0][0];
                        $p_lng = $points[0][1];
                        $distance = map_api($v_lat, $v_lng, $p_lat, $p_lng);
                        echo "📏 Distance from site: " . round($distance, 4) . " km<br/>";
                    }
                } else {
                    echo "⚠️ Invalid polygon coordinates<br/>";
                }
            } else {
                // Circle check
                $coords = explode(',', $co);
                if (count($coords) == 2) {
                    $c_lat = floatval(trim($coords[0]));
                    $c_lng = floatval(trim($coords[1]));
                    $distance = map_api($v_lat, $v_lng, $c_lat, $c_lng);
                    $inside_geofence = ($distance !== null && $distance <= 0.155); // 155 meters threshold
                    echo "🧭 Circle Check: " . ($inside_geofence ? "INSIDE" : "OUTSIDE") . "<br/>";
                    if ($distance !== null) {
                        echo "📏 Distance from site: " . round($distance, 4) . " km<br/>";
                    }
                } else {
                    echo "⚠️ Invalid circle coordinates<br/>";
                }
            }
        } else {
            echo "⚠️ No geofence coordinates found<br/>";
        }
        
        // If vehicle is outside geofence, update checkout time
        if (!$inside_geofence && !empty($co)) {
            $checkout_time = date('Y-m-d H:i:s');
            
            $update_sql = "UPDATE primary_movement_sales_orders 
                SET is_site_out = 1, 
                    site_out_time = '$checkout_time' 
                WHERE id = '$order_id'";
            
            if (mysqli_query($db, $update_sql)) {
                echo "✅ VEHICLE CHECKED OUT at $checkout_time<br/>";
                echo "📝 Vehicle has left the customer site after delivery<br/>";
                
                // Log to firebase
                firebase_log('HascolBridge', 'Primary Vehicle Checkout', 'Success', "Vehicle $vehicle_no left site for Order #$order_no at $checkout_time");
            } else {
                echo "❌ Error updating checkout: " . mysqli_error($db) . "<br/>";
            }
        } elseif ($inside_geofence) {
            echo "⏳ Vehicle still inside site geofence. Waiting for exit...<br/>";
        } else {
            echo "⚠️ Cannot determine geofence status. No valid coordinates.<br/>";
        }
    }
    
    firebase_log('HascolBridge', 'primary_vehicle_checkout_service.php', 'Success', "Run successfully.");
} else {
    echo "<h3>No trips found for vehicle checkout monitoring</h3>";
    echo "<p><strong>Criteria:</strong><br/>
    - Status = 2 (Closed)<br/>
    - is_site_out = 0 (Not yet checked out)<br/>
    - close_time is set<br/>
    - Created in last 10 days<br/>
    </p>";
    
    // Show some sample data for debugging
    $sample_sql = "SELECT id, order_no, vehicles, status, close_time, is_site_out 
                   FROM primary_movement_sales_orders 
                   WHERE status = 2 
                   LIMIT 5";
    $sample_result = mysqli_query($db, $sample_sql);
    
    if (mysqli_num_rows($sample_result) > 0) {
        echo "<br/><strong>Sample closed trips:</strong><br/>";
        while ($sample = mysqli_fetch_assoc($sample_result)) {
            echo "- Order: {$sample['order_no']}, Vehicle: {$sample['vehicles']}, is_site_out: {$sample['is_site_out']}, close_time: {$sample['close_time']}<br/>";
        }
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