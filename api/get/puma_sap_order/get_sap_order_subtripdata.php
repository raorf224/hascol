<?php
// ============================================
// Disable all time limits
// ============================================
set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);
ini_set('memory_limit', '2048M');

// ============================================
// Include config
// ============================================
include("../../../config.php");

$access_key = '2170';
$pass = isset($_GET["key"]) ? $_GET["key"] : '';

if ($pass != '') {
    if ($pass == $access_key) {
        
        // ============================================
        // SUPPORT BOTH: order_no AND id
        // ============================================
        $where_clause = "";
        
        // Check if order_no is provided
        if (isset($_GET["order_no"]) && $_GET["order_no"] != '') {
            $order_no = mysqli_real_escape_string($db, $_GET["order_no"]);
            // ========== FIX: Remove status=1 condition ==========
            $where_clause = "oi.order_no = '$order_no'";
        } 
        // Check if id is provided
        elseif (isset($_GET["id"]) && $_GET["id"] != '') {
            $id = intval($_GET["id"]);
            // ========== FIX: Remove status=1 condition ==========
            $where_clause = "oi.id = $id";
        } 
        else {
            echo json_encode(["error" => "Please provide 'order_no' or 'id'"]);
            exit;
        }

        // ============================================
        // SQL Query
        // ============================================
        $sql_query1 = "SELECT 
            oi.id AS sub_id,
            dl.sap_no AS dealer_sap,
            dl.name,
            pp.name AS product_name,
            geo.consignee_name,
            si.rate as product_rate,
            oi.*,
            dc.id AS vehicle_id,
            dc.name AS vehicle_name,
            IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker') AS tracker_status,
            geo.consignee_name AS depot_name,
            dc.id AS uniqueId,
            CASE
                WHEN oi.status = 0 THEN 'Pending'
                WHEN oi.status = 1 THEN 'Start'
                WHEN oi.status = 2 THEN 'Complete'
                ELSE 'Unknown'
            END AS current_status,
            CASE
                WHEN oi.is_shortage = 0 THEN 'Shortage Not Submit'
                WHEN oi.is_shortage = 1 THEN 'Shortage Submitted'
                ELSE '---'
            END AS is_shortage,
            os.file,
            os.sign,
            os.product_json
        FROM order_info AS oi
        LEFT JOIN devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicle
        LEFT JOIN geofenceing AS geo ON geo.code = oi.carrier_code
        LEFT JOIN all_products AS pp ON pp.sap_no = oi.item
        LEFT JOIN dealers AS dl ON dl.sap_no = oi.customer_id
        LEFT JOIN order_sales_invoice AS si ON si.order_no = oi.order_no
        LEFT JOIN order_shortage AS os ON os.order_id = oi.order_no AND os.invoice_no = oi.invoice
        WHERE $where_clause
        ORDER BY oi.id DESC";

        $result1 = $db->query($sql_query1);

        if (!$result1) {
            echo json_encode(["error" => "Database error: " . $db->error]);
            exit;
        }

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
            $thread[] = $user;
        }

        // ============================================
        // Return JSON
        // ============================================
        header('Content-Type: application/json');
        
        if (count($thread) == 0) {
            echo json_encode([
                "error" => "No data found",
                "parameters" => [
                    "order_no" => isset($_GET["order_no"]) ? $_GET["order_no"] : null,
                    "id" => isset($_GET["id"]) ? $_GET["id"] : null
                ],
                "suggestion" => "Check if this order_no/id exists in order_info table"
            ]);
        } else {
            echo json_encode($thread);
        }

    } else {
        echo json_encode(["error" => "Wrong Key"]);
    }
} else {
    echo json_encode(["error" => "Key is Required"]);
}
?>