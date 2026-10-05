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
    $region = isset($_GET['region']) && $_GET['region'] != 'all' ? $_GET['region'] : null;
    $territory = isset($_GET['territory']) && $_GET['territory'] != 'all' ? $_GET['territory'] : null;
    $tmFilter = isset($_GET['tm']) && $_GET['tm'] != 'all' ? $_GET['tm'] : null;
    $site = isset($_GET['site']) && $_GET['site'] != 'all' ? $_GET['site'] : null;
    $product = isset($_GET['product']) && $_GET['product'] != 'all' ? $_GET['product'] : null;
    
    // Build additional filters
    $extraConditions = "";
    if ($region) {
        $extraConditions .= " AND d.region = '$region'";
    }
    if ($territory) {
        $extraConditions .= " AND d.area = '$territory'";
    }
    if ($tmFilter) {
        $extraConditions .= " AND it.created_by = '$tmFilter'";
    }
    if ($site) {
        $extraConditions .= " AND it.dealer_id = '$site'";
    }
    if ($product) {
        $extraConditions .= " AND ds.product_id IN (SELECT id FROM dealers_products WHERE name = '$product')";
    }
    
    // TM Performance Query with date filter (status = 1 means completed)
    $query = "
        SELECT 
            it.created_by,
            u.name as tm_name,
            COUNT(DISTINCT it.dealer_id) as sites_visited,
            COUNT(DISTINCT it.id) as total_recons,
            SUM(CASE WHEN CAST(ds.variance AS DECIMAL(20,2)) < -1 THEN 1 ELSE 0 END) as variance_caught,
            AVG(
                CASE 
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1 THEN 95
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 2 THEN 75
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5 THEN 55
                    ELSE 25
                END
            ) as avg_score
        FROM inspector_task it
        LEFT JOIN users u ON it.created_by = u.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        WHERE it.created_by IS NOT NULL AND it.created_by != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
        GROUP BY it.created_by
        ORDER BY avg_score DESC
        LIMIT 5
    ";
    
    $result = $db->query($query);
    $tms = [];
    $rank = 1;
    
    while ($row = $result->fetch_assoc()) {
        // Calculate coverage % (sites_visited / total_sites * 100)
        $totalSitesQuery = "SELECT COUNT(*) as total FROM dealers";
        if ($region) {
            $totalSitesQuery .= " WHERE region = '$region'";
        }
        if ($territory) {
            $totalSitesQuery .= (strpos($totalSitesQuery, 'WHERE') === false) ? " WHERE area = '$territory'" : " AND area = '$territory'";
        }
        $totalSitesResult = $db->query($totalSitesQuery);
        $totalSites = $totalSitesResult->fetch_assoc()['total'];
        $coverage = ($totalSites > 0) ? round(($row['sites_visited'] / $totalSites) * 100) : 0;
        
        $tms[] = [
            'rank' => $rank,
            'name' => $row['tm_name'] ?? 'Unknown',
            'coverage' => (int)$coverage,
            'recons' => (int)$row['total_recons'],
            'variance_caught' => (int)$row['variance_caught'],
            'score' => round($row['avg_score'] ?? 0)
        ];
        $rank++;
    }
    
    $response['success'] = true;
    $response['data'] = $tms;
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>