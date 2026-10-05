<?php
//fetch.php  
include("../config.php");


$access_key = '03201232927';

$pass = $_GET["key"];
$dealer_sap = $_GET["dealer_sap"];
$from = $_GET["from"];
$to = $_GET["to"];
$product = $_GET["product"];
if ($pass != '') {
    // $id = $_GET["id"];
    if ($pass == $access_key) {
        $sql_query1 = "SELECT SUM(quantity) AS total_receipt
        FROM recipt_sales AS rs
        JOIN all_products AS pp ON pp.sap_no = rs.item
        WHERE rs.customer_id = '21528'
          AND STR_TO_DATE(rs.invoice_date, '%d-%b-%y') >= '$from'
          AND STR_TO_DATE(rs.invoice_date, '%d-%b-%y') <= '$to'
          AND pp.name = '$product';";

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