<?php
include("../config.php");
session_start();

if (!empty($_POST)) {
    $logo = "";
    $banner = "";
    

    $row_id = mysqli_real_escape_string($db, $_POST['row_id']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
  

    // Update dealer details
    $query = "UPDATE `devicesnew` SET 
        `name`='$name'
        WHERE id='$row_id'";

    $start_time = date("Y-m-d H:i:s");
    $output = '';

    if (mysqli_query($db, $query)) {
        
        $output = 1;
    } else {
        $output = 'Error: ' . mysqli_error($db) . '<br>' . $query;
    }

    echo $output;
}
?>
