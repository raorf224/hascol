<?php
//fetch.php  
include("../config.php");


$access_key = '03201232927';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        $sql_query1 = "SELECT 
        dl.sap_no AS dealer_sap,
        dl.id AS dealer_id,
        dl.name AS dealer_name,
        dp.name AS product_name,
        COUNT(dz.id) AS total_nozzles,
        COUNT(DISTINCT dz.tank_id) AS total_tanks,
        COUNT(DISTINCT dz.dispenser_id) AS total_dispensers
      FROM 
        hascolbridge.dealers AS dl
      LEFT JOIN 
        dealers_nozzel AS dz ON dz.dealer_id = dl.id
      LEFT JOIN 
        dealers_products AS dp ON dp.id = dz.products
      GROUP BY 
        dl.id, dl.name, dp.name
      ORDER BY 
        dl.id, dp.name;";

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