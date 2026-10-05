<?php
ini_set('max_execution_time', '0');
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");
// error_reporting(0);

include("../../../config.php");
set_time_limit(5000);

echo "<h1>Sap Trip Close older then last 3 days .</h1><br>";

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
AND oi.created_at <= DATE_SUB(CURDATE(), INTERVAL 3 DAY);";

$result = mysqli_query($db, $sql);
if (!$result) {
    firebase_log('HascolBridge', 'close_3_day_old_service.php Sec Orders', 'Error', "Query failed:");

    die("Query failed: " . mysqli_error($db));
}

$count = mysqli_num_rows($result);

if ($count > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $co = $row['co'];
        $sub_order_id = $row['id'];
        $v_num = $row['vehicle'];
        $vehicle_id = $row['vehicle_id'];

        $get_vehicle_data_query = "SELECT * FROM devicesnew WHERE id = '$vehicle_id'";
        $vehicle_data_result = mysqli_query($db, $get_vehicle_data_query);

        if (!$vehicle_data_result) {
            die("Query failed: " . mysqli_error($db));
        }

        if ($vehicle_row = mysqli_fetch_array($vehicle_data_result)) {
            $v_lat = $vehicle_row['lat'];
            $v_lng = $vehicle_row['lng'];
            $v_id = $vehicle_row['id'];

            echo '<br/>';
            echo 'Car name = ' . $v_num . ' | ID = ' . $vehicle_id . ' | TRIP-ID = ' . $sub_order_id;
            echo '<br/>';
            echo '---------------------------------------------------';
            echo '<br/>';

            get_geo($v_lat, $v_lng, $v_num, $v_id, $co, $db, $sub_order_id);
        }
    }
    firebase_log('HascolBridge', 'close_3_day_old_service.php Sec Orders', 'Success', "Run successfully.");

} else {
    firebase_log('HascolBridge', 'close_3_day_old_service.php Sec Orders', 'Success', "Run successfully.");

    echo '<h1>No Records Found to send Msg</h1>';
}

function get_geo($v_lat, $v_lng, $v_num, $v_id, $co, $db, $sub_order_id)
{
    $mychars = explode(', ', $co);
    $c_lat = floatval($mychars[0]);
    $c_lng = floatval($mychars[1]);
    $km = 0.155;

    $ky = 40000 / 360;
    $kx = cos(pi() * $c_lat / 180.0) * $ky;
    $dx = abs($c_lng - $v_lng) * $kx;
    $dy = abs($c_lat - $v_lat) * $ky;
    $distance = sqrt(($dx * $dx) + ($dy * $dy));

    echo $distance . '<=' . $km . '<br>';
    echo $km . '<br>';

    $in_time = date('Y-m-d H:i:s');
    echo 'IN TIME: ' . $in_time . '<br>';
    echo $distance . '<=' . $km . '<br>';

    $sql_update = "UPDATE order_info SET close_time='$in_time', status=2 WHERE id='$sub_order_id'";
    if (mysqli_query($db, $sql_update)) {
        echo "Trip Closed successfully !";
    } else {
        echo "Error: " . $sql_update . " " . mysqli_error($db);
    }
}

mysqli_close($db);
echo "Last Run " . date('Y-m-d H:i:s');
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