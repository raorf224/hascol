<?php
//fetch.php  
include ("../../config.php");


$access_key = '03201232927';

$pass = $_GET["key"];
// $id=$_GET["id"];
if ($pass != '') {
    if ($pass == $access_key) {
        $id = $_GET["id"];


        $sql_query1 = "SELECT 
		oi.id AS sub_id,
		dl.code AS dealer_sap,
		dl.consignee_name as name,
		pp.name AS product_name,
		geo.consignee_name,
		geo.Coordinates as depot_co,
		dl.id as geo_id,
		oi.rate as product_rate,
		oi.*,
		dc.id AS vehicle_id,
		dc.name AS vehicle_name,
        dc.id as vehicle_id,
		dc.name vehicle_name,dc.time,dc.lat as d_lat,dc.lng as d_lng,dl.consignee_name as dealer_name,dl.`Coordinates` as dealer_co,
		IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker') AS tracker_status,
		geo.consignee_name AS depot_name,
		dc.id AS uniqueId,
		CASE
                           WHEN oi.status = 0 THEN 'Pending'
                           WHEN oi.status = 1 THEN 'Start'
                           WHEN oi.status = 2 THEN 'Complete'
                           END AS current_status,geo.Coordinates as depo_co
	FROM primary_movement_sales_orders AS oi
	LEFT JOIN devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles
	JOIN geofenceing AS geo ON geo.code = oi.customer_id
	JOIN all_products AS pp ON pp.sap_no = oi.item
	JOIN geofenceing AS dl ON dl.code = oi.depot_code
	WHERE oi.id = $id
	group by dc.name
	ORDER BY oi.id DESC";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());

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