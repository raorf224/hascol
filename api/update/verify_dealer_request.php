<?php
include("../../config.php");
session_start();

if (isset($_POST)) {
    // Required POST variables
    $session_user_id = $_POST['user_id'];
    $row_id = $_POST['row_id'];
    $name = $_POST['name'];
    $user_id = $_POST['dealer_sap'];
    $imei = $_POST['imei'];
    $set_password = "";
    $datetime = date('Y-m-d H:i:s');

    $output = 0;

    // Query to check if the dealer exists
    $sql_query1 = "SELECT * FROM users WHERE id='$user_id';";
    $result = mysqli_query($db, $sql_query1);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $dealer_id = $row['id'];

        // Update the dealer verification status and IMEI
        $verify = "UPDATE users
                   SET is_verify = '1',
                       login_imei = '$imei'
                   WHERE id='$user_id';";

        if (mysqli_query($db, $verify)) {
            // Successfully updated the dealer status, return dealer info
            $output = json_encode($row);

            // Update the verification request status
            $query = "UPDATE dealer_request_for_verification
                      SET is_verify = '1',
                      verify_by = '$session_user_id',
                          verify_time = '$datetime'
                      WHERE id = '$row_id';";

            if (mysqli_query($db, $query)) {
                // Log the device login for the dealer
                $log = "INSERT INTO dealer_login_devices
                        (user_id, imei, created_at, created_by)
                        VALUES ('$user_id', '$imei', NOW(), '$session_user_id');";
                
                mysqli_query($db, $log);
                $output = 1;
            } else {
                $output = 0; // Error updating verification request status
            }
        } else {
            $output = 0; // Error updating dealer verification status
        }
    } else {
        $output = 0; // Dealer not found
    }

    echo $output;
}
?>