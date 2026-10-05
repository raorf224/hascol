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
    
    // Get filter parameters
    $dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-01');
    $dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
    
    // Get overall site health stats
    $statsQuery = "
        SELECT 
            COUNT(DISTINCT it.dealer_id) as total_sites,
            COUNT(DISTINCT it.dealer_id) as visited_sites,
            AVG(
                CASE 
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1 THEN 90
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 2 THEN 70
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5 THEN 50
                    ELSE 30
                END
            ) as avg_health_score
        FROM inspector_task it
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
    ";
    $statsResult = $db->query($statsQuery);
    $stats = $statsResult->fetch_assoc();
    
    // Sites by health category
    $healthQuery = "
        SELECT 
            CASE 
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1 THEN 'Excellent'
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 2 THEN 'Good'
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5 THEN 'Warning'
                ELSE 'Critical'
            END as status,
            COUNT(DISTINCT it.dealer_id) as count
        FROM inspector_task it
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        WHERE ds.variance IS NOT NULL AND ds.variance != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        GROUP BY status
    ";
    $healthResult = $db->query($healthQuery);
    $healthDetails = [];
    while ($row = $healthResult->fetch_assoc()) {
        $healthDetails[] = $row;
    }
    
    $response['success'] = true;
    $response['data'] = [
        'total_sites' => (int)($stats['total_sites'] ?? 0),
        'visited_sites' => (int)($stats['visited_sites'] ?? 0),
        'avg_health_score' => round($stats['avg_health_score'] ?? 0),
        'health_distribution' => $healthDetails,
        'recent_visits' => getRecentVisits($db, $dateFrom, $dateTo)
    ];
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

function getRecentVisits($db, $dateFrom, $dateTo) {
    $query = "
        SELECT 
            d.name as site_name,
            it.created_at,
            ds.variance,
            u.name as tm_name
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        LEFT JOIN users u ON it.created_by = u.id
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        ORDER BY it.created_at DESC
        LIMIT 10
    ";
    $result = $db->query($query);
    $visits = [];
    while ($row = $result->fetch_assoc()) {
        $visits[] = [
            'site' => $row['site_name'] ?? 'Unknown',
            'date' => $row['created_at'],
            'variance' => round(floatval($row['variance']), 2),
            'tm' => $row['tm_name'] ?? 'Unknown'
        ];
    }
    return $visits;
}

echo json_encode($response);
?>