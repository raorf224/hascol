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
    
    // Get monthly trends for last 6 months based on date range
    $months = [];
    $upliftData = [];
    $dumpingData = [];
    
    // Determine the start month (6 months back from date_to)
    $startDate = new DateTime($dateTo);
    $startDate->modify('-5 months');
    $startMonth = $startDate->format('Y-m');
    $endMonth = date('Y-m', strtotime($dateTo));
    
    // Get all months between start and end
    $current = new DateTime($startMonth . '-01');
    $end = new DateTime($endMonth . '-01');
    $end->modify('+1 month');
    
    while ($current < $end) {
        $month = $current->format('Y-m');
        $monthName = $current->format('M y');
        $months[] = $monthName;
        
        $monthStart = $current->format('Y-m-01');
        $monthEnd = $current->format('Y-m-t');
        
        // ============================================
        // CORRECTED: Uplift & Dumping based on conditions
        // ============================================
        // Upliftment: physical_stock > book_value (Negative Variance = Stock Gain)
        // Dumping: book_value > physical_stock (Positive Variance = Stock Loss)
        $query = "
            SELECT 
                COALESCE(SUM(
                    CASE 
                        WHEN CAST(ds.variance AS DECIMAL(20,2)) < 0 THEN ABS(CAST(ds.variance AS DECIMAL(20,2)))
                        ELSE 0
                    END
                ), 0) as uplift,
                COALESCE(SUM(
                    CASE 
                        WHEN CAST(ds.variance AS DECIMAL(20,2)) > 0 THEN CAST(ds.variance AS DECIMAL(20,2))
                        ELSE 0
                    END
                ), 0) as dumping
            FROM dealer_stock_recon_new ds
            INNER JOIN inspector_task it ON ds.task_id = it.id
            LEFT JOIN dealers d ON it.dealer_id = d.id
            WHERE it.status = '1'
            AND it.created_at BETWEEN '" . $db->real_escape_string($monthStart) . " 00:00:00' AND '" . $db->real_escape_string($monthEnd) . " 23:59:59'
            AND ds.variance IS NOT NULL 
            AND ds.variance != ''
            AND ds.variance REGEXP '^-?[0-9]+\.?[0-9]*$'
            $extraConditions
        ";
        
        $result = $db->query($query);
        $row = $result->fetch_assoc();
        
        // Convert to thousands (KL)
        $upliftData[] = round($row['uplift'] / 1000, 2);
        $dumpingData[] = round($row['dumping'] / 1000, 2);
        
        $current->modify('+1 month');
    }
    
    $response['success'] = true;
    $response['data'] = [
        'months' => $months,
        'uplift' => $upliftData,
        'dumping' => $dumpingData,
        'total_uplift' => array_sum($upliftData),
        'total_dumping' => array_sum($dumpingData)
    ];
    
    $db->close();
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>