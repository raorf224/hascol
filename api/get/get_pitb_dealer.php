<?php
//fetch.php  
include("../config.php");

$access_key = '2170';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        $sql_query1 = "SELECT 
            TRIM(`dealers`.`sap_no`) as CardCode,
            TRIM(`dealers`.`name`) as CardName,
            TRIM(`dealers`.`co-ordinates`) as U_Latitude,
            TRIM(`dealers`.`co-ordinates`) as U_Longitude,
            TRIM(`dealers`.`province`) as U_Province,
            TRIM(`dealers`.`district`) as U_District,
            TRIM(`dealers`.`city`) as U_City,
            'GAD-6182 – 6183 – 6184-P' as U_KFORM,
            '31-12-26' as U_KFExpiry,
            '0' as U_DDCount,
            '3' as U_MDCount,
            'NO' as U_ATG,
            '1' as U_OGRAProvinceID,
            '2' as U_OGRADistID,
            '3' as U_OGRACityID,
            TRIM(`dealers`.`location`) as Street,
            TRIM(`dealers`.`city`) as City,
            TRIM(`dealers`.`co-ordinates`) as U_Latitude_Decimal,
            TRIM(`dealers`.`co-ordinates`) as U_Longitude_Decimal
        FROM `dealers`;";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
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