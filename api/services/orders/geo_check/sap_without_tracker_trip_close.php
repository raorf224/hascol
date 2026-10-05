<?php
ini_set('max_execution_time', '0');
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");
// error_reporting(0);

include ("../../../config.php");
set_time_limit(5000);

echo "<h1>Sap With-out Tracker Trip Close service .</h1><br>";

$sql = "SELECT oi.*,dl.`co-ordinates` as co,dc.id as vehicle_id FROM order_info as oi 
join dealers as dl on dl.sap_no=oi.customer_id
left join devicesnew as dc on dc.organisation=oi.vehicle 
where oi.status=1 and oi.is_tracker=0 and  oi.created_at>='2024-05-22 00:00:00' order by oi.eta desc";

$result = mysqli_query($db, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

$count = mysqli_num_rows($result);
firebase_log('HascolBridge', 'sap_without_tracker_trip_close.php', 'Success', "Run successfully.");

if ($count > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $co = $row['co'];
        $sub_order_id = $row['id'];
        $v_num = $row['vehicle'];
        $vehicle_id = $row['vehicle_id'];
        $eta = $row['eta'];

        $sql_update = "UPDATE order_info SET close_time='$eta', status=2 WHERE id='$sub_order_id'";
        if (mysqli_query($db, $sql_update)) {
            echo "Trip Closed successfully !";
        } else {
            echo "Error: " . $sql_update . " " . mysqli_error($db);
        }
    }
} else {
    echo '<h1>No Records Found to send Msg</h1>';
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