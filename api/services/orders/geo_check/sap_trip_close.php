<?php
ini_set('max_execution_time', 0);
set_time_limit(5000);

include("../../../config.php");

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");

echo "<h1>SAP Trip Close Check-IN Service</h1><br>";

$sql = "SELECT 
    oi.*, 
    dl.`co-ordinates` AS co,
    dc.id AS vehicle_id 
FROM order_info AS oi 
JOIN dealers AS dl ON dl.sap_no = oi.customer_id 
LEFT JOIN devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicle 
WHERE 
    oi.status = 1 
    AND oi.is_tracker = 1 
    AND oi.created_at >= DATE_SUB(CURDATE(), INTERVAL 3 DAY);
";

$result = mysqli_query($db, $sql);
if (!$result) {
    die("Main query failed: " . mysqli_error($db));
}

$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $co = $row['co'];
        $sub_order_id = $row['id'];
        $v_num = $row['vehicle'];
        $vehicle_id = $row['vehicle_id'];

        if (!$vehicle_id) {
            echo "Vehicle ID not found for TRIP-ID: $sub_order_id<br>";
            continue;
        }

        $vehicle_data_query = "SELECT * FROM devicesnew WHERE id = '$vehicle_id'";
        $vehicle_data_result = mysqli_query($db, $vehicle_data_query);

        if (!$vehicle_data_result) {
            echo "Vehicle query failed: " . mysqli_error($db);
            continue;
        }

        if ($vehicle_row = mysqli_fetch_assoc($vehicle_data_result)) {
            $v_lat = $vehicle_row['lat'];
            $v_lng = $vehicle_row['lng'];
            $v_id = $vehicle_row['id'];

            echo "<br/>Car name = $v_num | ID = $vehicle_id | TRIP-ID = $sub_order_id<br/>";
            echo "---------------------------------------------------<br/>";

            get_geo($v_lat, $v_lng, $v_num, $v_id, $co, $db, $sub_order_id);
        }
    }
} else {
    echo "<h1>No Records Found to Check</h1>";
}

function get_geo($v_lat, $v_lng, $v_num, $v_id, $co, $db, $sub_order_id) {
    if (!$co || strpos($co, ',') === false) {
        echo "Invalid coordinates for dealer.<br/>";
        return;
    }

    list($c_lat, $c_lng) = array_map('floatval', explode(', ', $co));
    $km_threshold = 0.355;

    // Distance calculation (Haversine approximation)
    // $ky = 40000 / 360;
    // $kx = cos(pi() * $c_lat / 180.0) * $ky;
    // $dx = abs($c_lng - $v_lng) * $kx;
    // $dy = abs($c_lat - $v_lat) * $ky;
    // $distance = sqrt(($dx * $dx) + ($dy * $dy));
    $distance = map_api($v_lat, $v_lng, $c_lat, $c_lng);

    echo "Distance = $distance km | Threshold = $km_threshold km<br/>";

    $in_time = date('Y-m-d H:i:s');

    if ($distance <= $km_threshold) {
        $update_sql = "UPDATE order_info SET close_time='$in_time', status=2,remain_distance='0',last_check='$in_time' WHERE id='$sub_order_id'";
        echo "IN TIME: $in_time<br/>";

        if (mysqli_query($db, $update_sql)) {
            echo "✅ Trip Closed successfully!<br/>";
        } else {
            echo "❌ Error closing trip: " . mysqli_error($db) . "<br/>";
        }
    } else {
        $update_sql = "UPDATE order_info SET last_check='$in_time', remain_distance='$distance' WHERE id='$sub_order_id'";

        if (mysqli_query($db, $update_sql)) {
            echo "📌 Trip updated with last check and distance.<br/>";
        } else {
            echo "❌ Error updating trip: " . mysqli_error($db) . "<br/>";
        }
        echo "Not IN<br/>";
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
echo "<br/><strong>Last Run:</strong> " . date('Y-m-d H:i:s');
?>
