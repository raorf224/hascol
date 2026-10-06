<?php
//fetch.php  
include("../config.php");


$access_key = '2170';

$pass = $_GET["key"];
if ($pass != '') {
    $from = $_GET["from"];
    $to = $_GET["to"];
    if ($pass == $access_key) {
        $sql_query1 = "SELECT * FROM geofenceing where code IN($from,$to) order by id desc";

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