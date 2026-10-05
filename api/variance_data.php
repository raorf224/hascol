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
        $extraConditions .= " AND d.region = '" . $db->real_escape_string($region) . "'";
    }
    if ($territory) {
        $extraConditions .= " AND d.area = '" . $db->real_escape_string($territory) . "'";
    }
    if ($tm) {
        $extraConditions .= " AND it.created_by = '" . $db->real_escape_string($tm) . "'";
    }
    if ($site) {
        $extraConditions .= " AND it.dealer_id = '" . $db->real_escape_string($site) . "'";
    }
    if ($product) {
        $extraConditions .= " AND ds.product_id IN (SELECT id FROM dealers_products WHERE name = '" . $db->real_escape_string($product) . "')";
    }
    
    // Variance distribution - CORRECTED (based on variance value)
    $varianceDistQuery = "
        SELECT 
            COUNT(DISTINCT it.dealer_id) as total,
            CASE 
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1000 THEN '0-1K'
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5000 THEN '1K-5K'
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 10000 THEN '5K-10K'
                ELSE '>10K'
            END as variance_range
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL AND ds.variance != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
        GROUP BY variance_range
    ";
    $varianceDistResult = $db->query($varianceDistQuery);
    $varianceDist = [0, 0, 0, 0];
    while ($row = $varianceDistResult->fetch_assoc()) {
        if ($row['variance_range'] == '0-1K') $varianceDist[0] = (int)$row['total'];
        elseif ($row['variance_range'] == '1K-5K') $varianceDist[1] = (int)$row['total'];
        elseif ($row['variance_range'] == '5K-10K') $varianceDist[2] = (int)$row['total'];
        elseif ($row['variance_range'] == '>10K') $varianceDist[3] = (int)$row['total'];
    }
    
    // Top 5 High Variance Sites (Positive Variance = Stock Loss)
    $topVarianceQuery = "
        SELECT 
            d.name as site_name,
            ds.variance,
            CAST(ds.variance AS DECIMAL(20,2)) as variance_value,
            ABS(CAST(ds.variance AS DECIMAL(20,2))) as stock_loss
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL 
        AND ds.variance != ''
        AND ds.variance REGEXP '^-?[0-9]+\.?[0-9]*$'
        AND CAST(ds.variance AS DECIMAL(20,2)) != 0
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
        ORDER BY ABS(CAST(ds.variance AS DECIMAL(20,2))) DESC
        LIMIT 5
    ";
    $topVarianceResult = $db->query($topVarianceQuery);
    $topSites = [];
    if ($topVarianceResult) {
        while ($row = $topVarianceResult->fetch_assoc()) {
            $topSites[] = [
                'site' => $row['site_name'] ?? 'Unknown',
                'variance' => round(abs(floatval($row['variance_value'])), 2),
                'stock_loss' => round(abs(floatval($row['stock_loss'])), 1)
            ];
        }
    }
    
    // Total stock loss (Positive Variance)
    $stockLossQuery = "
        SELECT COALESCE(SUM(CAST(ds.variance AS DECIMAL(20,2))), 0) as total
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL 
        AND ds.variance != ''
        AND ds.variance REGEXP '^-?[0-9]+\.?[0-9]*$'
        AND CAST(ds.variance AS DECIMAL(20,2)) > 0
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $stockLossResult = $db->query($stockLossQuery);
    $totalStockLoss = 0;
    if ($stockLossResult) {
        $totalStockLoss = $stockLossResult->fetch_assoc()['total'];
    }
    
    // Variance sites count (ABS variance > 1000)
    $varianceSitesQuery = "
        SELECT COUNT(DISTINCT it.dealer_id) as total
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL 
        AND ds.variance != ''
        AND ds.variance REGEXP '^-?[0-9]+\.?[0-9]*$'
        AND ABS(CAST(ds.variance AS DECIMAL(20,2))) > 1000
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $varianceSitesResult = $db->query($varianceSitesQuery);
    $varianceSites = 0;
    if ($varianceSitesResult) {
        $varianceSites = $varianceSitesResult->fetch_assoc()['total'];
    }
    
    // Critical sites (ABS variance > 10000)
    $criticalSitesQuery = "
        SELECT COUNT(DISTINCT it.dealer_id) as total
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL 
        AND ds.variance != ''
        AND ds.variance REGEXP '^-?[0-9]+\.?[0-9]*$'
        AND ABS(CAST(ds.variance AS DECIMAL(20,2))) > 10000
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $criticalSitesResult = $db->query($criticalSitesQuery);
    $criticalSites = 0;
    if ($criticalSitesResult) {
        $criticalSites = $criticalSitesResult->fetch_assoc()['total'];
    }
    
    $response['success'] = true;
    $response['data'] = [
        'distribution' => $varianceDist,
        'top_sites' => $topSites,
        'total_stock_loss' => round($totalStockLoss, 1),
        'variance_sites' => (int)$varianceSites,
        'critical_sites' => (int)$criticalSites
    ];
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>