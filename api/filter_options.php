<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config.php';

$response = [
    'success' => false,
    'data' => [],
    'message' => ''
];

try {
    $db = getDBConnection();
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Get Regions
    $regionsQuery = "SELECT DISTINCT region FROM dealers WHERE region IS NOT NULL AND region != '' ORDER BY region";
    $regionsResult = $db->query($regionsQuery);
    $regions = [];
    while ($row = $regionsResult->fetch_assoc()) {
        $regions[] = $row['region'];
    }
    
    // Get Territories (using area)
    $territoriesQuery = "SELECT DISTINCT area FROM dealers WHERE area IS NOT NULL AND area != '' ORDER BY area";
    $territoriesResult = $db->query($territoriesQuery);
    $territories = [];
    while ($row = $territoriesResult->fetch_assoc()) {
        $territories[] = $row['area'];
    }
    
    // If no areas, use district
    if (empty($territories)) {
        $territoriesQuery = "SELECT DISTINCT district FROM dealers WHERE district IS NOT NULL AND district != '' ORDER BY district";
        $territoriesResult = $db->query($territoriesQuery);
        while ($row = $territoriesResult->fetch_assoc()) {
            $territories[] = $row['district'];
        }
    }
    
    // Get TMs (users)
    $tmsQuery = "SELECT id, name FROM users WHERE name IS NOT NULL AND name != '' ORDER BY name";
    $tmsResult = $db->query($tmsQuery);
    $tms = [];
    while ($row = $tmsResult->fetch_assoc()) {
        $tms[] = ['id' => $row['id'], 'name' => $row['name']];
    }
    
    // Get Sites
    $sitesQuery = "SELECT id, name FROM dealers WHERE name IS NOT NULL AND name != '' ORDER BY name";
    $sitesResult = $db->query($sitesQuery);
    $sites = [];
    while ($row = $sitesResult->fetch_assoc()) {
        $sites[] = ['id' => $row['id'], 'name' => $row['name']];
    }
    
    // Get Products
    $productsQuery = "SELECT DISTINCT name FROM dealers_products WHERE name IS NOT NULL AND name != '' ORDER BY name";
    $productsResult = $db->query($productsQuery);
    $products = [];
    while ($row = $productsResult->fetch_assoc()) {
        $products[] = $row['name'];
    }
    
    $response['success'] = true;
    $response['data'] = [
        'regions' => $regions,
        'territories' => $territories,
        'tms' => $tms,
        'sites' => $sites,
        'products' => $products
    ];
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>