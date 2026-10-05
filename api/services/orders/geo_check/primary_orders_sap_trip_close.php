<?php
ini_set('max_execution_time', 0);
set_time_limit(5000);

include("../../../config.php");

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");

echo "<h1>Primary Orders SAP Trip Close Check-IN Service</h1><br>";

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
        AND oi.created_at >= DATE_SUB(CURDATE(), INTERVAL 3 DAY) and oi.invoice_no=51509215;
";

$result = mysqli_query($db, $sql);

if (!$result) {
    die("Main query failed: " . mysqli_error($db));
}

$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sub_order_id = $row['id'];
        $v_num = $row['vehicle'];
        $vehicle_id = $row['vehicle_id'];
        $co = $row['co'];

        if (empty($vehicle_id)) {
            echo "⚠️ Vehicle ID not found for TRIP-ID: $sub_order_id<br>";
            continue;
        }

        $vehicle_query = "SELECT * FROM devicesnew WHERE id = '$vehicle_id'";
        $vehicle_result = mysqli_query($db, $vehicle_query);

        if (!$vehicle_result) {
            echo "Vehicle query failed: " . mysqli_error($db);
            continue;
        }

        if ($vehicle_data = mysqli_fetch_assoc($vehicle_result)) {
            $v_lat = $vehicle_data['lat'];
            $v_lng = $vehicle_data['lng'];

            echo "<br/>🚗 Vehicle: $v_num | ID: $vehicle_id | TRIP-ID: $sub_order_id<br/>";
            echo "---------------------------------------------------<br/>";

            get_geo($v_lat, $v_lng, $v_num, $vehicle_id, $co, $db, $sub_order_id);
        }
    }
} else {
    echo "<h3>No Records Found to Check</h3>";
}

function get_geo($v_lat, $v_lng, $v_num, $v_id, $co, $db, $sub_order_id)
{
    if (empty($co) || strpos($co, ',') === false) {
        echo "⚠️ Invalid coordinates for depot.<br/>";
        return;
    }

    list($c_lat, $c_lng) = array_map('floatval', explode(', ', $co));
    $km_threshold = 0.155;

    // Haversine-based flat-earth approximation
    // $ky = 40000 / 360;
    // $kx = cos(deg2rad($c_lat)) * $ky;
    // $dx = abs($c_lng - $v_lng) * $kx;
    // $dy = abs($c_lat - $v_lat) * $ky;
    // $distance = sqrt($dx * $dx + $dy * $dy);

    $distance = map_api($v_lat, $v_lng, $c_lat, $c_lng);


    echo "📏 Distance: " . round($distance, 4) . " km | Threshold: $km_threshold km<br/>";

    $in_time = date('Y-m-d H:i:s');

    if ($distance <= $km_threshold) {
        $update_sql = "UPDATE primary_movement_sales_orders 
            SET 
                close_time = '$in_time', 
                status = 2, 
                remain_distance = 0, 
                last_check = '$in_time' 
            WHERE id = '$sub_order_id'
        ";
        echo "🕒 IN TIME: $in_time<br/>";

        if (mysqli_query($db, $update_sql)) {
            echo "✅ Trip closed successfully!<br/>";
        } else {
            echo "❌ Error closing trip: " . mysqli_error($db) . "<br/>";
        }
    } else {
        $update_sql = "UPDATE primary_movement_sales_orders 
            SET 
                last_check = '$in_time', 
                remain_distance = '$distance' 
            WHERE id = '$sub_order_id'
        ";

        if (mysqli_query($db, $update_sql)) {
            echo "📌 Trip updated with distance info.<br/>";
        } else {
            echo "❌ Error updating trip: " . mysqli_error($db) . "<br/>";
        }

        echo "🚫 Not IN Range<br/>";
    }
}
function map_api($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
{
    $url = "http://localhost:8989/route?point=$latitudeFrom,$longitudeFrom&point=$latitudeTo,$longitudeTo&profile=car&locale=en&instructions=false";

    // Initialize cURL
    $ch = curl_init();

    // Set options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        curl_close($ch);
        return null; // or false to indicate failure
    }

    curl_close($ch);

    // Decode JSON response
    $data = json_decode($response, true);

    // Extract distance
    if (isset($data['paths'][0]['distance'])) {
        return ($data['paths'][0]['distance']/1000); // distance in meters
    } else {
        return null; // or false
    }
}
mysqli_close($db);
echo "<br/><strong>🕒 Last Run:</strong> " . date('Y-m-d H:i:s');
?>
