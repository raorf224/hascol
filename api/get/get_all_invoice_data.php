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
        

         $sql_query1 = "SELECT 
         oi.id AS sals_id, 
         oi.sp_code AS sp_code, 
         oi.sp_desc AS sp_desc, 
         oi.created_at AS order_time, 
         oi.order_no AS sale_order_no,
         dl.name, 
         dl.zm, 
         dl.tm, 
         dl.asm, 
         dl.region, 
         dl.city, 
         dl.province, 
         dl.district, 
         dl.rettype_desc, 
         us.name AS usersnames, 
         dl.credit_limit, 
         dl.rettype_desc, 
         dl.sap_no,
         om.id AS sub_id,
         om.invoice as order_invoice,
         om.remain_distance as order_remain_distance,
         dl.sap_no AS dealer_sap,
         dl.name,
         IF(om.id IS NOT NULL, oi.rate, '---') AS product_rate,
         IF(oi.id IS NOT NULL, pp.name, '---') AS product_name,
         IF(om.id IS NOT NULL, oi.rate * oi.quantity, '---') AS total_dispatched_amount,
         om.*,
         dc.id AS vehicle_id,
         om.vehicle AS vehicle_name,
         IF(om.id IS NOT NULL, IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker'), '---') AS tracker_status,
         dc.id AS uniqueId,
         dc.location as vehi_location,
         CASE
             WHEN om.status = 0 THEN 'Pending'
             WHEN om.status = 1 THEN 'Start'
             WHEN om.status = 2 THEN 'Complete'
         END AS current_status,
         CASE
             WHEN om.is_shortage = 0 THEN 'Shortage Not Submit'
             WHEN om.is_shortage = 1 THEN 'Shortage Submitted'
         END AS is_shortage,
         os.file, os.sign, os.product_json
     FROM  order_info AS om
     JOIN dealers AS dl ON dl.sap_no = om.customer_id 
     LEFT JOIN users AS us ON us.id = dl.asm 
     JOIN all_products AS pp ON pp.sap_no = om.item
     LEFT JOIN order_sales_invoice AS oi ON oi.order_no = om.order_no
     LEFT JOIN devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicle
     LEFT JOIN dealers_products AS dp ON dp.dealer_id = dl.id AND dp.name = pp.name
     LEFT JOIN order_shortage AS os ON os.order_id = oi.order_no AND os.invoice_no = om.invoice
     WHERE  STR_TO_DATE(om.order_date, '%d-%b-%y') >= STR_TO_DATE('$fromDateFormatted', '%d-%b-%y')
         AND STR_TO_DATE(om.order_date, '%d-%b-%y') <= STR_TO_DATE('$toDateFormatted', '%d-%b-%y')
         AND dl.indent_price = 1 
         AND om.status != 3 
     ORDER BY om.id DESC;
        ";

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
