<?php
//fetch.php  
include("../config.php");

$access_key = '2170';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        $sql_query1 = "SELECT 
            TRIM(`vehicle_master`.`REGISTRATION_NO`) as `TL Number`,
            'BUYERS OWN FLEET' as `Carriage Contractor`,
            TRIM(`vehicle_master`.`CAPACITY`) as `Total Capacity`,
            TRIM(`vehicle_master`.`NO_OF_COMPARTMENTS`) as `Chambers`,
            'Active' as `U_IsActive`
        FROM `hascolbridge`.`vehicle_master`;";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
            // Clean up spaces and format data
            foreach ($user as $key => $value) {
                if (is_string($value)) {
                    $user[$key] = preg_replace('/\s+/', ' ', trim($value));
                }
            }
            $thread[] = $user;
        }
        
        // Wrap in required format
        $response = array(
            "status" => "success",
            "data" => $thread
        );
        
        echo json_encode($response);

    } else {
        echo json_encode(array("status" => "error", "message" => "Wrong Key..."));
    }

} else {
    echo json_encode(array("status" => "error", "message" => "Key is Required"));
}

?>