<?php
include("../config.php");
session_start();
if (isset($_GET)) {


   $id=$_GET['id'];
    
    // echo 'HAmza';



    $query = "UPDATE `order_sales_invoice` SET `finance_status`='1' WHERE id='$id';";


    if (mysqli_query($db, $query)) {

        $output= 1;
    } else {
        $output = 'Error' . mysqli_error($db) . '<br>' . $query;

    }




    echo $output;
}
?>
