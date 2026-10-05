<?php
//fetch.php  
include("../config.php");

$access_key = '03201232927';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        $sql_query1 = "SELECT * FROM pitb_depot ORDER BY PLANT_CODE ASC;";
        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());

        // Temporary array to group data by depot
        $depots = array();
        $depot_counter = 1; // For generating dummy IDs
        
        while ($row = $result1->fetch_assoc()) {
            $plant_code = trim($row['PLANT_CODE']); // Clean the PLANT_CODE
            $plant_name = trim($row['PLANT_NAME']); // Clean PLANT_NAME
            
            // Clean product description - extract only product code
            $prod_desc = trim($row['PROD_DESC']);
            // Extract product name from description (e.g., "PMG - 2710.1210" -> "PMG")
            $product_name = trim(substr($prod_desc, 0, strpos($prod_desc, ' - ')));
            if (empty($product_name)) {
                // Fallback if no space found
                $product_name = $prod_desc;
            }
            
            // If depot doesn't exist, create it
            if (!isset($depots[$plant_code])) {
                $depots[$plant_code] = array(
                    "Depot ID" => $plant_code,
                    "Depot Name" => $plant_name,
                    "Address" => "Sample Address, Near Main Road, City Center", // Dummy Address
                    "City" => "Sample City", // Dummy City
                    "Depot Type" => "Standalone",
                    "District" => "Sample District", // Dummy District
                    "Latitude" => "30.123456", // Dummy Latitude
                    "Longitude" => "71.123456", // Dummy Longitude
                    "License No" => "OGRA-9-(3)/(112)2016-" . $depot_counter, // Dynamic license
                    "License Expiry" => "2030-12-31 00:00:00.000", // Dummy Expiry
                    "Province" => "Punjab", // Dummy Province
                    "Type" => "Secondary",
                    "tanks" => array()
                );
                $depot_counter++;
            }
            
            // Add tank to this depot
            $depots[$plant_code]['tanks'][] = array(
                "Tank No" => trim($row['TANK_NAME']),
                "Product" => $product_name, // Only product name (PMG, HSD, etc.)
                "Capacity" => "597500", // Fixed capacity
                "Stock" => $row['AVAIL_QTY']
            );
        }

        // Convert associative array to indexed array
        $response = array(
            "status" => "success",
            "data" => array_values($depots)
        );

        echo json_encode($response);

    } else {
        echo json_encode(array("status" => "error", "message" => "Wrong Key..."));
    }

} else {
    echo json_encode(array("status" => "error", "message" => "Key is Required"));
}
?>