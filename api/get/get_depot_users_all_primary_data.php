<?php
// fetch.php  
include("../config.php");

$access_key = '03201232927';

$pass = $_GET["key"];
$pre = $_GET["pre"];
$id = $_GET["user_id"];
$from = $_GET["from"];
$to = $_GET["to"];

// Format dates from 'YYYY-MM-DD' to 'DD-MMM-YY'
$fromDateFormatted = strtoupper(date('d-M-y', strtotime($from)));
$toDateFormatted = strtoupper(date('d-M-y', strtotime($to)));

if (!empty($pass)) {
    if ($pass === $access_key) {
        $cart_condition = '';
        


        $sql_query1="SELECT 
        oi.id AS sub_id,
        dl.code AS dealer_sap,
        DATE_ADD(NOW(), INTERVAL ((oi.remain_distance / 30) * 60 + 20) MINUTE) AS remain_time,
        dc.name AS vehi_cap,
        dl.consignee_name AS name,
        pp.name AS product_name,
        geo.consignee_name AS depot_name,
        oi.rate AS product_rate,
        oi.*,
        dc.id AS vehicle_id,
        dc.name AS vehicle_name,
        IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker') AS tracker_status,
        dc.id AS uniqueId,
        dc.location as vehicle_loc,
        CASE
            WHEN oi.status = 0 THEN 'Pending'
            WHEN oi.status = 1 THEN 'Start'
            WHEN oi.status = 2 THEN 'Complete'
        END AS current_status,
        CASE
            WHEN oi.is_shortage = 0 THEN 'Shortage Not Submit'
            WHEN oi.is_shortage = 1 THEN 'Shortage Submitted'
        END AS is_shortage,
        '' AS file,
        '' AS sign,
        '' AS product_json
    FROM primary_movement_sales_orders AS oi
    LEFT JOIN devicesnew AS dc 
        ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles
    LEFT JOIN geofenceing AS geo ON geo.code = oi.customer_id
    JOIN all_products AS pp ON pp.sap_no = oi.item
    LEFT JOIN geofenceing AS dl ON dl.code = oi.depot_code
    join users as gus on gus.image=dl.id
    WHERE 
    STR_TO_DATE(oi.invoice_date, '%d-%b-%y') > STR_TO_DATE('2025-06-10', '%Y-%m-%d') and oi.status=1
            and gus.id='$id'
        group by oi.order_no
    ORDER BY oi.id DESC;";

        $result1 = $db->query($sql_query1);

        if (!$result1) {
            die("Error: " . mysqli_error($db));
        }

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
            $thread[] = $user;
        }

        echo json_encode($thread);
    } else {
        echo 'Wrong Key...';
    }
} else {
    echo 'Key is Required';
}
?>