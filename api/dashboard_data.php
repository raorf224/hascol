<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

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

    // Build filter conditions
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

    // 1. Total Sites (all dealers)
    $totalSitesQuery = "SELECT COUNT(*) as total FROM dealers";
    if ($region) {
        $totalSitesQuery .= " WHERE region = '" . $db->real_escape_string($region) . "'";
    }
    if ($territory) {
        $totalSitesQuery .= (strpos($totalSitesQuery, 'WHERE') === false) ? " WHERE area = '" . $db->real_escape_string($territory) . "'" : " AND area = '" . $db->real_escape_string($territory) . "'";
    }
    $totalSitesResult = $db->query($totalSitesQuery);
    $totalSites = $totalSitesResult->fetch_assoc()['total'];

    // 2. Total Recons (ALL - both completed and pending)
    $totalReconsAllQuery = "
        SELECT COUNT(DISTINCT it.id) as total 
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $totalReconsAllResult = $db->query($totalReconsAllQuery);
    $totalReconsAll = $totalReconsAllResult->fetch_assoc()['total'];

    // 3. Total Recons Completed (inspector_task.status = 1)
    $totalReconsQuery = "
        SELECT COUNT(DISTINCT it.id) as total 
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $totalReconsResult = $db->query($totalReconsQuery);
    $totalRecons = $totalReconsResult->fetch_assoc()['total'];

    // 4. Total Recons Pending (inspector_task.status = 0)
    $pendingReconsQuery = "
        SELECT COUNT(DISTINCT it.id) as total 
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '0'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $pendingReconsResult = $db->query($pendingReconsQuery);
    $pendingRecons = $pendingReconsResult->fetch_assoc()['total'];

    // 5. Total Uplift (SUM of total_recipt)
    $totalUpliftQuery = "
    SELECT COALESCE(SUM(ABS(CAST(ds.variance AS DECIMAL(20,2)))), 0) as total 
    FROM dealer_stock_recon_new ds
    INNER JOIN inspector_task it ON ds.task_id = it.id
    LEFT JOIN dealers d ON it.dealer_id = d.id
    WHERE CAST(ds.variance AS DECIMAL(20,2)) < 0
    AND it.status = '1'
    AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
    $extraConditions
";
    $totalUpliftResult = $db->query($totalUpliftQuery);
    $totalUplift = $totalUpliftResult->fetch_assoc()['total'];


    // 6. Total Dumping (SUM of total_sales)
    $totalDumpingQuery = "
    SELECT COALESCE(SUM(CAST(ds.variance AS DECIMAL(20,2))), 0) as total 
    FROM dealer_stock_recon_new ds
    INNER JOIN inspector_task it ON ds.task_id = it.id
    LEFT JOIN dealers d ON it.dealer_id = d.id
    WHERE CAST(ds.variance AS DECIMAL(20,2)) > 0
    AND it.status = '1'
    AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
    $extraConditions
";
    $totalDumpingResult = $db->query($totalDumpingQuery);
    $totalDumping = $totalDumpingResult->fetch_assoc()['total'];

    // 7. Stock Loss - CORRECTED (Variance = Book Value - Physical Stock)
    // Stock Loss occurs when Book Value > Physical Stock (Positive Variance)
    $stockLossQuery = "
        SELECT COALESCE(SUM(CAST(ds.variance AS DECIMAL(20,2))), 0) as total 
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE CAST(ds.variance AS DECIMAL(20,2)) > 0
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $stockLossResult = $db->query($stockLossQuery);
    $stockLoss = $stockLossResult->fetch_assoc()['total'];

    // 8. Site Coverage (Visited sites / Total sites * 100)
    $visitedSitesQuery = "
        SELECT COUNT(DISTINCT it.dealer_id) as total 
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $visitedSitesResult = $db->query($visitedSitesQuery);
    $visitedSites = $visitedSitesResult->fetch_assoc()['total'];
    $siteCoverage = ($totalSites > 0) ? round(($visitedSites / $totalSites) * 100) : 0;

    // 9. Avg Health Score (based on variance - lower variance = better health)
    $healthScoreQuery = "
        SELECT 
            AVG(
                CASE 
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1000 THEN 90
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5000 THEN 70
                    WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 10000 THEN 50
                    ELSE 30
                END
            ) as avg_score
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL AND ds.variance != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
    ";
    $healthScoreResult = $db->query($healthScoreQuery);
    $avgHealthScore = round($healthScoreResult->fetch_assoc()['avg_score'] ?? 0);

    // Get previous month data for comparison
    $prevMonthStart = date('Y-m-01', strtotime('-1 month', strtotime($dateFrom)));
    $prevMonthEnd = date('Y-m-t', strtotime('-1 month', strtotime($dateFrom)));
    $prevMonthQuery = "
        SELECT 
            COUNT(DISTINCT it.id) as recons,
            COALESCE(SUM(CAST(ds.total_recipt AS DECIMAL(20,2))), 0) as uplift,
            COALESCE(SUM(CAST(ds.total_sales AS DECIMAL(20,2))), 0) as dumping,
            COALESCE(SUM(CAST(ds.variance AS DECIMAL(20,2))), 0) as loss
        FROM inspector_task it
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($prevMonthStart) . " 00:00:00' AND '" . $db->real_escape_string($prevMonthEnd) . " 23:59:59'
        $extraConditions
    ";
    $prevMonthResult = $db->query($prevMonthQuery);
    $prevMonth = $prevMonthResult->fetch_assoc();

    // Calculate percentage changes
    $upliftChange = ($prevMonth['uplift'] > 0) ? round((($totalUplift - $prevMonth['uplift']) / $prevMonth['uplift']) * 100) : 0;
    $dumpingChange = ($prevMonth['dumping'] > 0) ? round((($totalDumping - $prevMonth['dumping']) / $prevMonth['dumping']) * 100) : 0;
    $reconsChange = ($prevMonth['recons'] > 0) ? round((($totalRecons - $prevMonth['recons']) / $prevMonth['recons']) * 100) : 0;
    $lossChange = ($prevMonth['loss'] != 0) ? round((($stockLoss - $prevMonth['loss']) / $prevMonth['loss']) * 100) : 0;

    // Get site health distribution (based on variance)
    $healthDistributionQuery = "
        SELECT 
            COUNT(DISTINCT it.dealer_id) as total,
            CASE 
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 1000 THEN 'healthy'
                WHEN ABS(CAST(ds.variance AS DECIMAL(20,2))) < 5000 THEN 'warning'
                ELSE 'critical'
            END as status
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ds.variance IS NOT NULL AND ds.variance != ''
        AND it.status = '1'
        AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        $extraConditions
        GROUP BY status
    ";
    $healthDistResult = $db->query($healthDistributionQuery);
    $healthDist = ['healthy' => 0, 'warning' => 0, 'critical' => 0];
    while ($row = $healthDistResult->fetch_assoc()) {
        $healthDist[$row['status']] = $row['total'];
    }

    // Not visited sites (last recon > 60 days)
    $notVisitedQuery = "
        SELECT COUNT(DISTINCT it.dealer_id) as total
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.created_at < DATE_SUB(NOW(), INTERVAL 60 DAY)
        AND it.status = '1'
        $extraConditions
    ";
    $notVisitedResult = $db->query($notVisitedQuery);
    $notVisited = $notVisitedResult->fetch_assoc()['total'];

    $response['success'] = true;
    $response['data'] = [
        'total_sites' => (int) $totalSites,
        'site_coverage' => (int) $siteCoverage,
        'total_recons_all' => (int) $totalReconsAll,
        'recons_completed' => (int) $totalRecons,
        'recons_pending' => (int) $pendingRecons,
        'total_uplift' => number_format($totalUplift / 1000, 1) . 'M',
        'total_uplift_raw' => (float) $totalUplift,
        'total_dumping' => number_format($totalDumping / 1000, 1) . 'M',
        'total_dumping_raw' => (float) $totalDumping,
        'stock_loss' => number_format($stockLoss, 0),
        'stock_loss_raw' => (float) $stockLoss,
        'avg_health_score' => (int) $avgHealthScore,
        'changes' => [
            'uplift' => $upliftChange,
            'dumping' => $dumpingChange,
            'recons' => $reconsChange,
            'loss' => $lossChange,
            'coverage' => 8,
            'health' => 4
        ],
        'health_distribution' => [
            'healthy' => (int) ($healthDist['healthy'] ?? 0),
            'warning' => (int) ($healthDist['warning'] ?? 0),
            'critical' => (int) ($healthDist['critical'] ?? 0),
            'not_visited' => (int) $notVisited
        ]
    ];

    $db->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>