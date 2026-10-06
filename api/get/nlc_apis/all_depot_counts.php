<?php
// depot_summary.php  
include("../../config.php");

$access_key = '2170';

$pass = $_GET["key"] ?? '';
$pre = $_GET["pre"] ?? '';
$id = $_GET["user_id"] ?? '';

if (!$pass) {
    echo 'Key is Required';
    exit;
}

if ($pass !== $access_key) {
    echo 'Wrong Key...';
    exit;
}

// Query for total count and total sum of random quantities
$sql_query1 = "SELECT 
    COUNT(*) AS total_depots,
    SUM(FLOOR(RAND() * 20000) + 1) AS total_pmg_quantity,
    SUM(FLOOR(RAND() * 20000) + 1) AS total_hsd_quantity,
    SUM(FLOOR(RAND() * 20000) + 1 + FLOOR(RAND() * 20000) + 1) AS total_combined_quantity
FROM geofenceing 
WHERE geotype = 'depot'";

$result1 = $db->query($sql_query1) or die("Error: " . mysqli_error($db));

$summary = $result1->fetch_assoc();

// Add formatted text
$summary['total_pmg_quantity_display'] = number_format($summary['total_pmg_quantity'], 0) . ' Ltr';
$summary['total_hsd_quantity_display'] = number_format($summary['total_hsd_quantity'], 0) . ' Ltr';
$summary['total_combined_quantity_display'] = number_format($summary['total_combined_quantity'], 0) . ' Ltr';
$summary['as_on_date'] = date('Y-m-d H:i:s');

$thread = [$summary];
$thread = utf8ize($thread);
$json = json_encode($thread, JSON_PRETTY_PRINT);

if ($json === false) {
    echo json_encode(["error" => "JSON encoding failed", "details" => json_last_error_msg()]);
} else {
    echo $json;
}

function utf8ize($data) {
    if (is_array($data)) {
        return array_map('utf8ize', $data);
    } elseif (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    }
    return $data;
}
?>