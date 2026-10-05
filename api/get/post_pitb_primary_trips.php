<?php
//fetch.php  
include("../config.php");

$access_key = '03201232927';

$pass = $_GET["key"];
if ($pass != '') {
    if ($pass == $access_key) {
        
        // Get today's date
        $today = date('Y-m-d');
        
        $sql_query1 = "SELECT * FROM primary_movement_sales_orders WHERE DATE(created_at) = CURDATE() ORDER BY id DESC;";
        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());
        
        // Initialize arrays
        $data = array();
        $counter = 0;
        
        while ($row = $result1->fetch_assoc()) {
            // Clean data
            $customer_name = trim($row['customer_name']);
            $customer_id = trim($row['customer_id']);
            $depot_name = trim($row['depot_name']);
            $depot_code = trim($row['depot_code']);
            $item = trim($row['item']);
            
            // Determine product name from item code
            $product_name = "";
            if ($item == "110") {
                $product_name = "PMG";
            } elseif ($item == "152") {
                $product_name = "HSD";
            } elseif ($item == "154") {
                $product_name = "HASRON";
            } else {
                $product_name = $item; // fallback
            }
            
            // Format date
            $order_date = date('Y-m-d H:i:s.000', strtotime($row['order_date']));
            
            // Clean vehicle number
            $vehicle = trim($row['vehicles']);
            
            // Create entry in required format
            $data[] = array(
                "Date" => $order_date,
                "From Warehouse" => $depot_name, // depot_name se (CHAK PIRANHA)
                "From WH Code" => $depot_code, // depot_code se (55280)
                "To Warehouse" => $customer_name, // customer_name se (BE Mehmoodkot)
                "To WH Code" => $customer_id, // customer_id se (1159047)
                "ItemCode" => $item, // Static as per your requirement
                "Item Description" => $product_name,
                "Item Quantity" => number_format((float)$row['quantity'], 6, '.', ''),
                "U_TLNo" => $vehicle,
                "U_DriverName" => null,
                "U_DriverCNIC" => null,
                "U_DriverCell" => null,
                "U_VSC" => "True", // Static
                "U_SealNoFrom" => null,
                "U_SealNoTo" => null,
                "U_TotalSeals" => null,
                "Comments" => null,
                "JrnlMemo" => "Inventory Transfers -"
            );
            
            $counter++;
        }
        
        // Prepare final response
        $response = array(
            "status" => "success",
            "from_date" => $today,
            "total_records" => $counter,
            "data" => $data
        );
        
        echo json_encode($response);

    } else {
        echo json_encode(array("status" => "error", "message" => "Wrong Key..."));
    }

} else {
    echo json_encode(array("status" => "error", "message" => "Key is Required"));
}
?>