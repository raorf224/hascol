<?php
include("../config.php");
session_start();

if (!empty($_POST)) {
    $logo = "";
    $banner = "";
    

    $dealer_id = mysqli_real_escape_string($db, $_POST['row_id']);
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $circle = mysqli_real_escape_string($db, $_POST['lati']);
    $poly = mysqli_real_escape_string($db, $_POST['poly']);
  

    // Update dealer details
    $query = "UPDATE `dealers` SET 
        `co-ordinates`='$circle',
        `form_status`='$poly'
        WHERE id='$dealer_id'";

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
