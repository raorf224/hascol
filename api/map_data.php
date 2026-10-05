<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config.php';

// No time limits for PHP
set_time_limit(0);
ini_set('max_execution_time', 0);

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

    // Build dealer filter conditions
    $dealerConditions = "";
    if ($region) {
        $dealerConditions .= " AND d.region = '" . $db->real_escape_string($region) . "'";
    }
    if ($territory) {
        $dealerConditions .= " AND d.area = '" . $db->real_escape_string($territory) . "'";
    }
    if ($site) {
        $dealerConditions .= " AND d.id = '" . $db->real_escape_string($site) . "'";
    }

    // ============================================
    // SINGLE QUERY - Get all data at once
    // ============================================
    $query = "
        SELECT 
            d.id,
            d.name,
            d.`co-ordinates`,
            d.city,
            d.region,
            d.area,
            latest.variance,
            latest.last_visit
        FROM dealers d
        LEFT JOIN (
            SELECT 
                it.dealer_id,
                ds.variance,
                it.created_at as last_visit,
                ROW_NUMBER() OVER (PARTITION BY it.dealer_id ORDER BY it.created_at DESC) as rn
            FROM inspector_task it
            INNER JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
            WHERE it.status = '1'
            AND it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59'
        ) latest ON latest.dealer_id = d.id AND latest.rn = 1
        WHERE d.`co-ordinates` IS NOT NULL 
        AND d.`co-ordinates` != ''
        AND d.`co-ordinates` != '0,0'
        $dealerConditions
        ORDER BY d.name
    ";

    $result = $db->query($query);

    if (!$result) {
        // FALLBACK: If ROW_NUMBER doesn't work, use GROUP BY
        $query = "
            SELECT 
                d.id,
                d.name,
                d.`co-ordinates`,
                d.city,
                d.region,
                d.area,
                MAX(ds.variance) as variance,
                MAX(it.created_at) as last_visit
            FROM dealers d
            LEFT JOIN inspector_task it ON it.dealer_id = d.id AND it.status = '1'
            LEFT JOIN dealer_stock_recon_new ds ON ds.task_id = it.id
            WHERE d.`co-ordinates` IS NOT NULL 
            AND d.`co-ordinates` != ''
            AND d.`co-ordinates` != '0,0'
            AND (it.created_at IS NULL OR it.created_at BETWEEN '" . $db->real_escape_string($dateFrom) . " 00:00:00' AND '" . $db->real_escape_string($dateTo) . " 23:59:59')
            $dealerConditions
            GROUP BY d.id
            ORDER BY d.name
        ";

        $result = $db->query($query);

        if (!$result) {
            throw new Exception('Query failed: ' . $db->error);
        }
    }

    $sites = [];

    while ($row = $result->fetch_assoc()) {
        $coords = explode(',', $row['co-ordinates']);
        if (count($coords) >= 2) {
            $lat = trim($coords[0]);
            $lng = trim($coords[1]);

            if (is_numeric($lat) && is_numeric($lng) && $lat != 0 && $lng != 0) {
                $varianceData = $row['variance'] !== null ? floatval($row['variance']) : null;
                $lastVisit = $row['last_visit'] ?? null;

                $status = 'not_visited';
                $color = 'gray';

                $varianceData = floatval($row['variance']);
                $status = 'healthy';
                $color = 'green';

                if ($varianceData !== null) {
                    if (abs($varianceData) < 1000) {
                        $status = 'healthy';
                        $color = 'green';
                    } elseif (abs($varianceData) < 5000) {
                        $status = 'warning';
                        $color = 'yellow';
                    } elseif (abs($varianceData) > 5000) {
                        $status = 'critical';
                        $color = 'red';
                    }
                }


                if (!$lastVisit) {
                    $status = 'not_visited';
                    $color = 'gray';
                }

                $sites[] = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'lat' => (float) $lat,
                    'lng' => (float) $lng,
                    'city' => $row['city'] ?? 'N/A',
                    'region' => $row['region'] ?? 'N/A',
                    'status' => $status,
                    'color' => $color,
                    'variance' => $varianceData,
                    'last_visit' => $lastVisit
                ];
            }
        }
    }

    $response['success'] = true;
    $response['data'] = $sites;
    $response['message'] = 'Total sites found: ' . count($sites);

    $db->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>