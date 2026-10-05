<?php  
// fetch.php  
include("../../config.php");

$access_key = '03201232927';

$pass = $_GET["key"] ?? '';
$pre = $_GET["pre"] ?? '';
$id = $_GET["user_id"] ?? '';
$from = $_GET["from"] ?? '';
$to = $_GET["to"] ?? '';
$region = $_GET["region"] ?? '';
$tm = $_GET["tm"] ?? '';

if (!empty($pass)) {
    if ($pass === $access_key) {
        $thread = [];

        // Fetch TM users
        $sql_tms = "SELECT * FROM users WHERE region='$region' AND id IN($tm);";
        $result_tm = $db->query($sql_tms) or die("Error: " . $db->error);

        while ($user_tm = $result_tm->fetch_assoc()) {
            $inspection_report = 0;
            $ehs_report = 0;
            $recon_report = 0;
            $profitability_report = 0;
            $decant_report = 0;
            $total_dumping = 0;
            $total_external = 0;
            $tm_id = intval($user_tm['id']);
            $tm_name = $user_tm['name'];
            $region = $user_tm['region'];

            if (!empty($region)) {
                $sql_query1 = "SELECT id, name FROM dealers 
                               WHERE privilege = 'Dealer' AND asm IN($tm_id) AND region = '$region' 
                               ORDER BY name ASC";

                $result1 = $db->query($sql_query1) or die("Error: " . $db->error);
                $dealers = 0;

                while ($user = $result1->fetch_assoc()) {
                    $dealer_id = intval($user['id']);
                    $dealer_name = $user['name'];

                    $sql_query2 = "SELECT it.*, us.name as user_name, dd.name as dealer_name, us.privilege as role_name, it.created_at as task_create_time,
                                   CASE
                                       WHEN it.status = 0 THEN 'Pending'
                                       WHEN it.status = 1 THEN 'Complete'
                                       WHEN it.status = 2 THEN 'Cancel'
                                   END AS current_status, dd.region, dd.province, dd.city
                                   FROM inspector_task as it
                                   LEFT JOIN inspector_task_response as tr ON tr.task_id=it.id
                                   JOIN dealers as dd ON dd.id = it.dealer_id
                                   JOIN users as us ON us.id = it.user_id 
                                   WHERE it.time >= '$from' AND it.time <= '$to' AND dd.id = $dealer_id AND us.region='$region' AND us.id IN($tm_id)";

                    $result2 = $db->query($sql_query2) or die("Error: " . $db->error);

                    while ($task = $result2->fetch_assoc()) {
                        $stock_recon = $task['stock_recon'];
                        $inspection = $task['inspection'];
                        if($stock_recon=='1'){
                            $recon_report++;
                        }
                        if($inspection=='1'){
                            $inspection_report++;
                        }
                    }
                }
            }

            // Fetch total counts per dealer
            $sql_query3 = "SELECT 
                dl.id, 
                dl.sap_no, 
                dl.name,
                
                -- Checking all four conditions and picking the max count
                GREATEST(
                    COALESCE(
                        (SELECT COUNT(DISTINCT rr.task_id) 
                         FROM inspector_task AS it
                         JOIN dealer_stock_recon_new AS rr ON rr.task_id = it.id
                         WHERE it.dealer_id = dl.id AND DATE(it.time) BETWEEN '$from' AND '$to'
                        ), 0
                    ),
                    COALESCE(
                        (SELECT COUNT(DISTINCT rr.inspection_id) 
                         FROM inspector_task AS it
                         JOIN survey_response_main AS rr ON rr.inspection_id = it.id
                         WHERE it.dealer_id = dl.id AND DATE(it.time) BETWEEN '$from' AND '$to'
                        ), 0
                    )
                ) AS total_count,
            
                -- Getting distinct dealer count by checking all four tables
                GREATEST(
                    COALESCE(
                        (SELECT COUNT(DISTINCT it.dealer_id) 
                         FROM inspector_task AS it
                         JOIN dealer_stock_recon_new AS rr ON rr.task_id = it.id
                         WHERE DATE(it.time) BETWEEN '$from' AND '$to' 
                         AND it.dealer_id = dl.id
                        ), 0
                    ),
                    COALESCE(
                        (SELECT COUNT(DISTINCT it.dealer_id) 
                         FROM inspector_task AS it
                         JOIN survey_response_main AS rr ON rr.inspection_id = it.id
                         WHERE DATE(it.time) BETWEEN '$from' AND '$to' 
                         AND it.dealer_id = dl.id
                        ), 0
                    )
                    
                ) AS distinct_count
            
            FROM dealers AS dl 
            JOIN users AS us ON us.id = dl.asm 
            WHERE dl.asm IN($tm_id);";

            $result3 = $db->query($sql_query3) or die("Error: " . $db->error);

            $total_site = 0;
            $total_count = 0;
            $distinct_count = 0;

            while ($user3 = $result3->fetch_assoc()) {
                $total_site++;
                $total_count += $user3['total_count'];
                $distinct_count += $user3['distinct_count'];
            }
            
            // Fix: Check if $total_site is greater than 0 before division
            if ($total_site > 0) {
                $per = ($distinct_count / $total_site) * 100;
            } else {
                $per = 0; // Set to 0 if no sites
            }

            $get_orders = "SELECT rs.*, pp.name as product_name
                           FROM dealer_stock_recon_new as rs
                           JOIN dealers_products as dp ON dp.id=rs.product_id
                           JOIN all_products as pp ON pp.name = dp.name
                           JOIN inspector_task as it ON it.id=rs.task_id
                           LEFT JOIN inspector_task_response as tr ON tr.task_id=it.id
                           JOIN users as us ON us.id = it.user_id
                           WHERE rs.total_days>0 AND us.region='$region' 
                           AND DATE(rs.created_at)>='$from' AND DATE(rs.created_at)<='$to' 
                           AND rs.variance!='0.0' AND us.id='$tm_id'
                           GROUP BY rs.product_id, rs.task_id";

            $result_orders = $db->query($get_orders);
            
            if ($result_orders) {
                while ($row_2 = $result_orders->fetch_assoc()) {
                    // Prepare the record data
                    $variance = floatval($row_2['variance']);
                    $book_value = floatval($row_2['book_value']);
                    $physical_stock = floatval($row_2['sum_of_closing']);
                    
                    if (!($variance < 1000 && $variance > -1000)) {
                        if ($book_value > $physical_stock) {
                            $total_dumping += abs($variance);
                        }
                        
                        if ($physical_stock > $book_value) {
                            $total_external += abs($variance);
                        }
                    }
                }
            } else {
                echo "Error fetching stock recon data: " . $db->error;
            }

            // Prepare final response array
            $report_data = [
                "id" => $tm_id,
                "tm_name" => $tm_name,
                "region" => $region,
                "total_dumping" => $total_dumping,
                "total_external" => $total_external,
                "inspection_count" => $inspection_report,
                "recon_count" => $recon_report,
                "total_site" => $total_site,
                "total_count" => $total_count,
                "distinct_count" => $distinct_count,
                "rank" => round($per, 2), // Round to 2 decimal places for cleaner output
            ];

            $thread[] = $report_data;
        }

        usort($thread, function ($a, $b) {
            return $b['rank'] - $a['rank']; // Descending Order (Greatest rank first)
        });
        
        echo json_encode($thread, JSON_PRETTY_PRINT);

    } else {
        echo json_encode(["error" => "Wrong Key"]);
    }
} else {
    echo json_encode(["error" => "Key is Required"]);
}
?>