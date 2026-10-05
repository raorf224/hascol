<?php
// total_stats.php  
include("../../config.php");

$access_key = '03201232927';

$pass = $_GET["key"] ?? '';
$from_date = $_GET["from_date"] ?? '2026-01-01 00:00:00';
$to_date = $_GET["to_date"] ?? date('Y-m-d 23:59:59');

if (!$pass) {
    echo 'Key is Required';
    exit;
}

if ($pass !== $access_key) {
    echo 'Wrong Key...';
    exit;
}

// Query with date range filter
$sql_query = "SELECT 
    COUNT(DISTINCT dl.id) AS total_dealers,
    COALESCE(SUM(dsr.total_sales), 0) AS total_sales,
    FLOOR(RAND() * 30000) + 1 AS total_available_quantity
FROM dealers AS dl
LEFT JOIN dealer_stock_recon_new AS dsr ON dsr.dealer_id = dl.id 
    AND dsr.created_at BETWEEN '$from_date' AND '$to_date'
WHERE dl.privilege = 'Dealer' AND dl.indent_price = 1";

$result = $db->query($sql_query) or die("Error: " . mysqli_error($db));

$stats = $result->fetch_assoc();

// Add filter details to response
$stats['filter_from_date'] = $from_date;
$stats['filter_to_date'] = $to_date;

$stats = utf8ize($stats);
$json = json_encode($stats, JSON_PRETTY_PRINT);

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