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
    $tm = isset($_GET['tm']) && $_GET['tm'] != 'all' ? $_GET['tm'] : null;
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
    if ($tm) {
        $extraConditions .= " AND it.created_by = '$tm'";
    }
    if ($site) {
        $extraConditions .= " AND it.dealer_id = '$site'";
    }
    if ($product) {
        $extraConditions .= " AND ds.product_id IN (SELECT id FROM dealers_products WHERE name = '$product')";
    }
    
    // Best Performing Sites with date filter
    $bestSitesQuery = "
        SELECT 
            d.name as site_name,
            AVG(ABS(CAST(ds.variance AS DECIMAL(20,2)))) as avg_variance,
            AVG(
                CASE 
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1 THEN 90
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 2 THEN 70
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5 THEN 50
                    ELSE 30
                END
            ) as health_score,
            'Regular' as uplift_regularity
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL AND ds.variance != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
        GROUP BY it.dealer_id
        ORDER BY avg_variance ASC
        LIMIT 5
    ";
    $bestResult = $db->query($bestSitesQuery);
    $bestSites = [];
    while ($row = $bestResult->fetch_assoc()) {
        $bestSites[] = [
            'site' => $row['site_name'] ?? 'Unknown',
            'health_score' => round($row['health_score']),
            'variance' => round($row['avg_variance'], 2),
            'regularity' => $row['uplift_regularity']
        ];
    }
    
    // Risky Sites with date filter
    $riskySitesQuery = "
        SELECT 
            d.name as site_name,
            AVG(ABS(CAST(ds.variance AS DECIMAL(20,2)))) as avg_variance,
            MAX(it.created_at) as last_visit,
            DATEDIFF(NOW(), MAX(it.created_at)) as days_since_visit
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL AND ds.variance != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
        GROUP BY it.dealer_id
        ORDER BY avg_variance DESC, days_since_visit DESC
        LIMIT 5
    ";
    $riskyResult = $db->query($riskySitesQuery);
    $riskySites = [];
    while ($row = $riskyResult->fetch_assoc()) {
        $healthScore = max(0, 100 - ($row['avg_variance'] * 10));
        $riskySites[] = [
            'site' => $row['site_name'] ?? 'Unknown',
            'health_score' => round($healthScore),
            'variance' => round($row['avg_variance'], 2),
            'last_visit' => $row['days_since_visit'] . ' Days Ago'
        ];
    }
    
    $response['success'] = true;
    $response['data'] = [
        'best_sites' => $bestSites,
        'risky_sites' => $riskySites
    ];
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>