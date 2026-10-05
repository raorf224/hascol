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
    
    $alerts = [];
    
    // 1. High Variance Sites (> 2%) with date filter
    $highVarianceQuery = "
        SELECT COUNT(DISTINCT it.dealer_id) as total
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE ABS(CAST(ds.variance AS DECIMAL(20,2))) > 2
        AND it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $highVarianceResult = $db->query($highVarianceQuery);
    $highVariance = $highVarianceResult->fetch_assoc()['total'];
    
    $alerts[] = [
        'id' => 'high_variance',
        'title' => 'High Variance Sites',
        'description' => 'Variance more than 2%',
        'count' => (int)$highVariance,
        'severity' => 'critical',
        'icon' => 'fa-triangle-exclamation'
    ];
    
    // 2. Overdue Recons (status = 0 means pending)
    $overdueQuery = "
        SELECT COUNT(DISTINCT it.id) as total
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '0'
        AND it.created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $overdueResult = $db->query($overdueQuery);
    $overdue = $overdueResult->fetch_assoc()['total'];
    
    $alerts[] = [
        'id' => 'overdue_recons',
        'title' => 'Overdue Recons',
        'description' => 'Recons past due date',
        'count' => (int)$overdue,
        'severity' => 'warning',
        'icon' => 'fa-clock-rotate-left'
    ];
    
    // 3. Sites Not Visited (status = 0 means pending)
    $notVisitedQuery = "
        SELECT COUNT(DISTINCT it.dealer_id) as total
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '0'
        AND it.created_at < DATE_SUB(NOW(), INTERVAL 60 DAY)
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $notVisitedResult = $db->query($notVisitedQuery);
    $notVisited = $notVisitedResult->fetch_assoc()['total'];
    
    $alerts[] = [
        'id' => 'sites_not_visited',
        'title' => 'Sites Not Visited',
        'description' => 'Not visited in last 60 days',
        'count' => (int)$notVisited,
        'severity' => 'warning',
        'icon' => 'fa-eye-slash'
    ];
    
    // 4. TM Inactive with date filter
    $tmInactiveQuery = "
        SELECT COUNT(DISTINCT it.created_by) as total
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.created_at < DATE_SUB(NOW(), INTERVAL 7 DAY)
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $tmInactiveResult = $db->query($tmInactiveQuery);
    $tmInactive = $tmInactiveResult->fetch_assoc()['total'];
    
    $alerts[] = [
        'id' => 'tm_inactive',
        'title' => 'TM Inactive',
        'description' => 'No activity in last 7 days',
        'count' => (int)$tmInactive,
        'severity' => 'orange',
        'icon' => 'fa-user-xmark'
    ];
    
    // 5. Possible Pilferage with date filter
    $pilferageQuery = "
        SELECT COUNT(DISTINCT it.id) as total
        FROM dealer_stock_recon_new ds
        INNER JOIN inspector_task it ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE CAST(ds.total_recipt AS DECIMAL(20,2)) > CAST(ds.total_sales AS DECIMAL(20,2))
        AND (CAST(ds.total_recipt AS DECIMAL(20,2)) - CAST(ds.total_sales AS DECIMAL(20,2))) > 100
        AND it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $pilferageResult = $db->query($pilferageQuery);
    $pilferage = $pilferageResult->fetch_assoc()['total'];
    
    $alerts[] = [
        'id' => 'possible_pilferage',
        'title' => 'Possible Pilferage',
        'description' => 'Uplift > Dumping (High Gap)',
        'count' => (int)$pilferage,
        'severity' => 'critical',
        'icon' => 'fa-receipt'
    ];
    
    $response['success'] = true;
    $response['data'] = $alerts;
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>