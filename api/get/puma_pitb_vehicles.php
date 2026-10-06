<?php
//fetch.php  
include("../config.php");

// Set JSON header
header('Content-Type: application/json');

$access_key = '2170';
$pass = isset($_GET["key"]) ? $_GET["key"] : '';

// OPTIMIZATION: Enable caching
$cache_file = 'vehicle_cache.json';
$cache_time = 3600; // 1 hour cache

if ($pass != '' && $pass == $access_key) {
    // Check if cache exists and is valid
    if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
        // Serve from cache
        echo file_get_contents($cache_file);
        exit;
    }
    
    // If no cache, fetch from databasep
    $sql_query1 = "SELECT 
        `TL Number`,
        `Carriage Contractor`,
        `Total Capacity`,
        `No of Chambers` as `Chambers`,
        `U_IsActive`
    FROM `hascolbridge`.`pumapitbvehicles`";
    
    $result1 = $db->query($sql_query1);
    
    if ($result1) {
        $thread = array();
        while ($row = $result1->fetch_assoc()) {
            $thread[] = array_map('trim', $row);
        }
        $result1->free();
        
        $response = array(
            "status" => "success",
            "data" => $thread
        );
        
        $json_output = json_encode($response);
        
        // Save to cache
        file_put_contents($cache_file, $json_output);
        
        echo $json_output;
    } else {
        echo json_encode(array(
            "status" => "error",
            "message" => "Database query failed"
        ));
    }
    
} else if ($pass == '') {
    echo json_encode(array(
        "status" => "error", 
        "message" => "Key is Required"
    ));
} else {
    echo json_encode(array(
        "status" => "error", 
        "message" => "Wrong Key..."
    ));
}

mysqli_close($db);
?>