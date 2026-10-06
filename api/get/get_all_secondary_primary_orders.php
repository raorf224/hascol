<?php
// fetch.php  
include("../config.php");

$access_key = '2170';

$pass = $_GET["key"];
$pre = $_GET["pre"];
$id = $_GET["user_id"];


if (!empty($pass)) {
    if ($pass === $access_key) {
        $cart_condition = '';
        

         $sql_query1 = "SELECT 
         om.id AS sals_id, 
          us.name AS usersnames, 
         rm.name AS rm_name,
         DATE_ADD(NOW(), INTERVAL ((oi.remain_distance / 30) * 60 + 20) MINUTE) AS remain_time,
         dc.name AS vehi_cap,
         om.sp_code AS sp_code, 
         om.sp_desc AS sp_desc, 
         om.created_at AS order_time, 
         om.order_no AS sale_order_no,
         dl.name, 
         dl.zm, 
         dl.tm, 
         dl.asm, 
         dl.region, 
         dl.city, 
         dl.province, 
         dl.district, 
         dl.rettype_desc, 
         
         dl.credit_limit, 
         dl.rettype_desc, 
         dl.sap_no,
         oi.id AS sub_id,
         oi.invoice as order_invoice,
         oi.remain_distance as order_remain_distance,
         dl.sap_no AS dealer_sap,
         dl.name,
         IF(oi.id IS NOT NULL, om.rate, '---') AS product_rate,
         IF(om.id IS NOT NULL, pp.name, '---') AS product_name,
         IF(oi.id IS NOT NULL, om.rate * om.quantity, '---') AS total_dispatched_amount,
         oi.*,
         dc.id AS vehicle_id,
         oi.vehicle AS vehicle_name,
         IF(oi.id IS NOT NULL, IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker'), '---') AS tracker_status,
         dc.id AS uniqueId,
         dc.location as vehi_location,
         CASE
             WHEN oi.status = 0 THEN 'Pending'
             WHEN oi.status = 1 THEN 'Start'
             WHEN oi.status = 2 THEN 'Complete'
         END AS current_status,
         CASE
             WHEN oi.is_shortage = 0 THEN 'Shortage Not Submit'
             WHEN oi.is_shortage = 1 THEN 'Shortage Submitted'
         END AS is_shortage,
         os.file, os.sign, os.product_json
     FROM order_sales_invoice AS om
     JOIN dealers AS dl ON dl.sap_no = om.customer_id 
     LEFT JOIN users AS us ON us.id = dl.asm 
     LEFT JOIN users AS rm ON rm.id = dl.tm 
     JOIN all_products AS pp ON pp.sap_no = om.item
     RIGHT JOIN order_info AS oi ON oi.order_no = om.order_no
     LEFT JOIN devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicle
     LEFT JOIN dealers_products AS dp ON dp.dealer_id = dl.id AND dp.name = pp.name
     LEFT JOIN order_shortage AS os ON os.order_id = oi.order_no AND os.invoice_no = oi.invoice
     WHERE oi.created_at>='2025-06-10' and oi.status=1
     group by oi.invoice
     ORDER BY om.id DESC;";

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
