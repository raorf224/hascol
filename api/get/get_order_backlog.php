<?php
//fetch.php  
include("../../config.php");

$access_key = '2170';

$pass = $_GET["key"];
$order_id = $_GET["order_id"];

if ($pass != '') {
    if ($pass == $access_key) {
        // First query - order main
        $sql = "SELECT om.id,om.id as order_id,'' as sales_order,0 as status,'Order created' as status_value,'order generated' as description,om.created_at,om.created_at,us.name as name FROM order_main as om
        join dealers as us on us.id=om.user_id
        where om.id='$order_id';";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);

        // Second query - order detail log
        $sql_query1 = "SELECT od.*, us.name 
                       FROM order_detail_log as od
                       JOIN users as us ON us.id = od.created_by
                       WHERE od.order_id = $order_id";
        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error($db));

        $thread = array();

        // Pehle order_main ka data push hoga
        if ($row) {
            $thread[] = $row;
        }

        // Ab order_detail_log ka data push karna hai
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
