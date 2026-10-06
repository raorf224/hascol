<?php
//fetch.php  
include("../../config.php");


$access_key = '2170';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        $id = $_GET["id"];
        $sql_query1 = "SELECT ds.*,dl.name,dl.`co-ordinates` as points,dl.status,dl.status_value,dl.status_time FROM dealers as dl 
        join dealers_stages as ds on ds.dealer_id=dl.id
        where dl.id=$id";


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