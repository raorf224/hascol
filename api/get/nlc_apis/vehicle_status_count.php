<?php
// vehicle_counts.php  
include("../../config.php");

$access_key = '03201232927';

$pass = $_GET["key"] ?? '';

if (!$pass) {
    echo 'Key is Required';
    exit;
}

if ($pass !== $access_key) {
    echo 'Wrong Key...';
    exit;
}

// Query for all counts in one go
$sql_query = "SELECT 
    COUNT(*) AS total_vehicles,
    SUM(CASE WHEN is_on_trip = 1 THEN 1 ELSE 0 END) AS loaded_vehicles,
    SUM(CASE WHEN is_on_trip = 0 OR is_on_trip IS NULL THEN 1 ELSE 0 END) AS empty_vehicles
FROM devicesnew";

$result = $db->query($sql_query) or die("Error: " . mysqli_error($db));

$counts = $result->fetch_assoc();

// Add percentage calculations
$counts['loaded_percentage'] = ($counts['total_vehicles'] > 0) ? 
    round(($counts['loaded_vehicles'] / $counts['total_vehicles']) * 100, 2) : 0;
    
$counts['empty_percentage'] = ($counts['total_vehicles'] > 0) ? 
    round(($counts['empty_vehicles'] / $counts['total_vehicles']) * 100, 2) : 0;

// Add timestamp
$counts['as_on_date'] = date('Y-m-d H:i:s');

$json = json_encode($counts, JSON_PRETTY_PRINT);

if ($json === false) {
    echo json_encode(["error" => "JSON encoding failed", "details" => json_last_error_msg()]);
} else {
    echo $json;
}

$db->close();
?>