<?php
//fetch.php  
include("../config.php");


$access_key = '2170';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        $sql_query1 = "SELECT 
        oi.*, 
        dl.`co-ordinates` AS co, 
        dl.`form_status` AS polygone_points, 
        dc.id AS vehicle_id, 
        dc.name as vehicle 
    FROM 
        order_info AS oi 
    JOIN 
        dealers AS dl ON dl.sap_no = oi.customer_id 
    LEFT JOIN 
        devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicle 
    WHERE 
        oi.status = 1 
        AND oi.is_tracker = 1 
        AND oi.created_at >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error($db));

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
