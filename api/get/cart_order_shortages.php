<?php
//fetch.php  
include("../config.php");


$access_key = '2170';

$pass = $_GET["key"];
if ($pass != '') {
    $id = $_GET["id"];
    if ($pass == $access_key) {
        $sql_query1 = "SELECT od.*,dl.id as customer_id,dl.name as customer_name,oi.SaleOrder,dl.sap_no,dc.name as vehiclenames FROM order_shortage as od
        join order_main as oi on oi.id=od.order_id 
        join dealers as dl on dl.sap_no=oi.dealer_sap
        join puma_sap_data_trips as pd on pd.salesapNo=oi.SaleOrder
        join puma_sap_data as ps on ps.id=pd.main_id
        left join devicesnew as dc on dc.name=ps.vehicle
        join users_devices_new as ud on ud.devices_id=dc.id where ud.users_id='$id'
        order by od.id desc;";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error($db));

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
            $thread[] = $user;
        }
        echo json_encode($thread);

    } else {
        echo 'Wrong Key...';
    }

} 
else 
{
    echo 'Key is Required';
}


?>