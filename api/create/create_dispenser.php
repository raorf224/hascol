<?php
include("../../config.php");
session_start();
header('Content-Type: application/json'); 

if (isset($_POST)) {
    $user_id = $_POST['user_id'];
    $dealer_id = mysqli_real_escape_string($db, $_POST["dealer_id"]);
    $name = mysqli_real_escape_string($db, $_POST["dispenser_name"]);
    $dispenser_description = mysqli_real_escape_string($db, $_POST["dispenser_description"]);
    $date = date('Y-m-d H:i:s');

    // echo 'HAmza';
   $row_id = isset($_POST["row_id"]) ? $_POST["row_id"] : '';

    if ($row_id != '') {


    } else {

        $query = "INSERT INTO `dealers_dispenser`
        (`dealer_id`,
        `name`,
        `description`,
        `created_at`,
        `created_by`)
        VALUES
        ('$dealer_id',
        '$name',
        '$dispenser_description',
        '$date',
        '$user_id');";


        if (mysqli_query($db, $query)) {


            $output = 1;

        } else {
            $output = 'Error' . mysqli_error($db) . '<br>' . $query;

        }
    }



    echo $output;
}
?>