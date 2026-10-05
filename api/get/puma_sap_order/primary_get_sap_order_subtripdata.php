<?php
//fetch.php  
include("../../config.php");


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
		oi.rate as product_rate,
		oi.*,
		dc.id AS vehicle_id,
		dc.name AS vehicle_name,
		IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker') AS tracker_status,
		geo.consignee_name AS depot_namess,
		dc.id AS uniqueId,
		CASE
			WHEN oi.status = 0 THEN 'Pending'
			WHEN oi.status = 1 THEN 'Start'
			WHEN oi.status = 2 THEN 'Complete'
		END AS current_status,
		CASE
			WHEN oi.is_shortage = 0 THEN 'Shortage Not Submit'
			WHEN oi.is_shortage = 1 THEN 'Shortage Submitted'
		END AS is_shortage,
		'' as file,'' as sign,'' as product_json
	FROM primary_movement_sales_orders AS oi
	LEFT JOIN devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles
	LEFT JOIN geofenceing AS geo ON geo.code = oi.customer_id
	JOIN all_products AS pp ON pp.sap_no = oi.item
	LEFT JOIN geofenceing AS dl ON dl.code = oi.depot_code
	WHERE oi.order_no = $id
	group by dc.name
	ORDER BY oi.id DESC;";

		$result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());

		$thread = [];
		while ($user = $result1->fetch_assoc()) {
			$thread[] = $user;
		}
		// echo json_encode($thread);

		$thread = utf8ize($thread);
		$json = json_encode($thread, JSON_PRETTY_PRINT);

		if ($json === false) {
			echo json_encode(["error" => "JSON encoding failed", "details" => json_last_error_msg()]);
		} else {
			echo $json;
		}

	} else {
		echo 'Wrong Key...';
	}

} else {
	echo 'Key is Required';
}
function utf8ize($data)
{
	if (is_array($data)) {
		return array_map('utf8ize', $data);
	} elseif (is_string($data)) {
		return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
	}
	return $data;
}
?>