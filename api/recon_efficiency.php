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
    
    // Total recons with date filter (status = 1 means completed)
    $totalReconsQuery = "
        SELECT COUNT(DISTINCT it.id) as total 
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $totalReconsResult = $db->query($totalReconsQuery);
    $totalRecons = $totalReconsResult->fetch_assoc()['total'];
    
    // Completed recons with date filter
    $completedQuery = "
        SELECT COUNT(DISTINCT it.id) as total 
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $completedResult = $db->query($completedQuery);
    $completed = $completedResult->fetch_assoc()['total'];
    
    // Same day completion with date filter
    $sameDayQuery = "
        SELECT COUNT(DISTINCT it.id) as total
        FROM inspector_task it
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND DATE(it.created_at) = DATE(ds.created_at)
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $sameDayResult = $db->query($sameDayQuery);
    $sameDay = $sameDayResult->fetch_assoc()['total'];
    
    // Overdue recons with date filter (status = 0 means pending)
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
    
    // Avg cycle duration with date filter
    $avgDurationQuery = "
        SELECT AVG(DATEDIFF(it.created_at, ds.created_at)) as avg_days
        FROM inspector_task it
        LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.status = '1'
        AND it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $avgDurationResult = $db->query($avgDurationQuery);
    $avgDuration = round($avgDurationResult->fetch_assoc()['avg_days'] ?? 0, 1);
    
    // Recon pipeline status with date filter
    $pipelineQuery = "
        SELECT 
            SUM(CASE WHEN it.status = '0' AND it.created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as initiated,
            SUM(CASE WHEN it.status = '0' AND it.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 14 DAY) AND DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) as under_review,
            SUM(CASE WHEN it.status = '1' AND it.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND DATE_SUB(NOW(), INTERVAL 14 DAY) THEN 1 ELSE 0 END) as rm_approved,
            SUM(CASE WHEN it.status = '1' AND it.created_at < DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 ELSE 0 END) as completed
        FROM inspector_task it
        LEFT JOIN dealers d ON it.dealer_id = d.id
        WHERE it.created_at BETWEEN '$dateFrom 00:00:00' AND '$dateTo 23:59:59'
        $extraConditions
    ";
    $pipelineResult = $db->query($pipelineQuery);
    $pipeline = $pipelineResult->fetch_assoc();
    
    // Backlog trend with date filter (last 4 months from date_from)
    $backlogTrend = [];
    for ($i = 3; $i >= 0; $i--) {
        $month = date('M y', strtotime("-$i months", strtotime($dateFrom)));
        $monthStart = date('Y-m-01', strtotime("-$i months", strtotime($dateFrom)));
        $monthEnd = date('Y-m-t', strtotime("-$i months", strtotime($dateFrom)));
        
        $backlogQuery = "
            SELECT COUNT(DISTINCT it.id) as total
            FROM inspector_task it
            LEFT JOIN dealers d ON it.dealer_id = d.id
            WHERE it.status = '0'
            AND it.created_at BETWEEN '$monthStart 00:00:00' AND '$monthEnd 23:59:59'
            AND it.created_at < DATE_SUB(NOW(), INTERVAL 30 DAY)
            $extraConditions
        ";
        $backlogResult = $db->query($backlogQuery);
        $backlogTrend[] = (int)$backlogResult->fetch_assoc()['total'];
    }
    
    $response['success'] = true;
    $response['data'] = [
        'avg_duration' => $avgDuration,
        'overdue' => (int)$overdue,
        'completion_rate' => ($totalRecons > 0) ? round(($completed / $totalRecons) * 100) : 0,
        'same_day_completion' => ($totalRecons > 0) ? round(($sameDay / $totalRecons) * 100) : 0,
        'pipeline' => [
            'initiated' => (int)($pipeline['initiated'] ?? 0),
            'under_review' => (int)($pipeline['under_review'] ?? 0),
            'rm_approved' => (int)($pipeline['rm_approved'] ?? 0),
            'completed' => (int)($pipeline['completed'] ?? 0)
        ],
        'backlog_trend' => $backlogTrend,
        'total_recons' => (int)$totalRecons
    ];
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>