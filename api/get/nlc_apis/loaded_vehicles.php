<?php
// fetch_loaded_vehicles.php  
include("../../config.php");

$access_key = '2170';

$pass = $_GET["key"] ?? '';

if (!$pass) {
    die('Key is Required');
}

if ($pass !== $access_key) {
    die('Wrong Key...');
}

header('Content-Type: application/json');

// Query 1: Get all loaded vehicles
$sql_vehicles = "SELECT * FROM devicesnew WHERE is_on_trip = 1 ORDER BY id DESC";
$result_vehicles = $db->query($sql_vehicles);

if (!$result_vehicles) {
    echo json_encode(["error" => mysqli_error($db)]);
    $db->close();
    exit;
}

$vehicles = [];
while ($row = $result_vehicles->fetch_assoc()) {
    $vehicles[$row['name']] = $row; // Store by vehicle number
}

if (empty($vehicles)) {
    echo json_encode([]);
    $db->close();
    exit;
}

// Get all vehicle numbers for IN clause
$vehicle_numbers = array_keys($vehicles);
$vehicle_list = "'" . implode("','", array_map([$db, 'real_escape_string'], $vehicle_numbers)) . "'";

// Query 2: Get latest receipt for all vehicles in one query
$sql_receipts = "SELECT rd1.* 
    FROM receipt_data rd1
    INNER JOIN (
        SELECT im_truck_no, MAX(id) as max_id
        FROM receipt_data
        WHERE im_truck_no IN ($vehicle_list) AND status = 1
        GROUP BY im_truck_no
    ) rd2 ON rd1.im_truck_no = rd2.im_truck_no AND rd1.id = rd2.max_id";

$result_receipts = $db->query($sql_receipts);

// Merge receipt data with vehicles
while ($receipt = $result_receipts->fetch_assoc()) {
    $vehicle_no = $receipt['im_truck_no'];
    if (isset($vehicles[$vehicle_no])) {
        foreach ($receipt as $key => $value) {
            $vehicles[$vehicle_no]['receipt_' . $key] = $value;
        }
    }
}

// Convert to indexed array
$final_result = array_values($vehicles);

echo json_encode($final_result);

$db->close();
?>