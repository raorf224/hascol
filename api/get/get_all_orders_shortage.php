<?php
//fetch.php  
include("../../config.php");

header('Content-Type: application/json');

$access_key = '2170';
$rettype = $_GET["rettype"];

$pass = $_GET["key"];
if ($pass != '') {
    $id = $_GET["id"];
    if ($pass == $access_key) {
        $sql_query1 = "SELECT od.*,oi.customer_id,oi.customer_name FROM order_shortage as od
        join order_info as oi on oi.order_no=od.order_id 
        join dealers as dl on dl.sap_no=oi.customer_id
        where dl.rettype='$rettype'
        order by od.id desc;";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error($db));

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
            $thread[] = $user;
        }
        echo json_encode(utf8ize($thread));

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