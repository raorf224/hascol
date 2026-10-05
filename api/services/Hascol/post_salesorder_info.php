<?php
include("../../hacol_conif_post.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form data
    $customer_id   = !empty($_POST['customer_id'])   ? $_POST['customer_id']   : 0;
$customer_name = !empty($_POST['customer_name']) ? $_POST['customer_name'] : 0;
$catcode07     = !empty($_POST['catcode07'])     ? $_POST['catcode07']     : 0;
$cat7desc      = !empty($_POST['cat7desc'])      ? $_POST['cat7desc']      : 0;
$order_no      = !empty($_POST['order_no'])      ? $_POST['order_no']      : 0;
$order_type    = !empty($_POST['order_type'])    ? $_POST['order_type']    : 0;
$invoice_no    = !empty($_POST['invoice_no'])    ? $_POST['invoice_no']    : 0;
$invoice_desc  = !empty($_POST['invoice_desc'])  ? $_POST['invoice_desc']  : 0;
$item          = !empty($_POST['item'])          ? $_POST['item']          : 0;
$quantity      = !empty($_POST['quantity'])      ? $_POST['quantity']      : 0;
$unit_measure  = !empty($_POST['unit_measure'])  ? $_POST['unit_measure']  : 0;
$next_status   = !empty($_POST['next_status'])   ? $_POST['next_status']   : 0;
$last_status   = !empty($_POST['last_status'])   ? $_POST['last_status']   : 0;
$hold_code     = !empty($_POST['hold_code'])     ? $_POST['hold_code']     : 0;
$order_date    = !empty($_POST['order_date'])    ? $_POST['order_date']    : 0;
$datetime      = !empty($_POST['datetime'])      ? $_POST['datetime']      : 0;
$load_status   = !empty($_POST['load_status'])   ? $_POST['load_status']   : 0;
$vehicle       = !empty($_POST['vehicle'])       ? $_POST['vehicle']       : 0;
$carrier_code  = !empty($_POST['carrier_code'])  ? $_POST['carrier_code']  : 0;
$carrier_desc  = !empty($_POST['carrier_desc'])  ? $_POST['carrier_desc']  : 0;
$buyer_own     = !empty($_POST['buyer_own'])     ? $_POST['buyer_own']     : 0;
$sp_code       = !empty($_POST['sp_code'])       ? $_POST['sp_code']       : 0;
$sp_desc       = !empty($_POST['sp_desc'])       ? $_POST['sp_desc']       : 0;


    $status = 0;
    $created_at = date('Y-m-d H:i:s');

    $sql = "SELECT pd.id,pd.indent_price,pd.Nozel_price,pd.freight_value,dl.rettype_desc  FROM dealers_products as pd
    join all_products as pp on pp.name=pd.name
    join dealers as dl on dl.id=pd.dealer_id
    where pp.sap_no='$item' and dl.sap_no=$customer_id";

    // echo $sql;

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);
    $rate = '';
    if ($count > 0) {
        $id = $row['id'];
        $indent_price = $row['indent_price'];
        $Nozel_price = $row['Nozel_price'];
        $freight_value = $row['freight_value'];
        $rettype_desc = $row['rettype_desc'];

        if ($buyer_own == 'PP ') {
            $rate = $indent_price;
        } else {
            if ($rettype_desc == 'COCO site                     ') {
                $rate = $Nozel_price;

            } else {

                $rate = $freight_value;
            }

        }
    }



    // Prepare and bind the SQL statement
    // $stmt = $conn->prepare("INSERT INTO order_sales_invoice 
    // (customer_id, 
    // customer_name, 
    // catcode07, 
    // cat7desc, 
    // order_no, 
    // order_type, 
    // invoice_no, 
    // invoice_desc, 
    // item, 
    // rate, 
    // quantity, 
    // unit_measure, 
    // next_status, 
    // last_status, 
    // hold_code, 
    // order_date, 
    // datetime, 
    // load_status, 
    // vehicle, 
    // carrier_code, 
    // carrier_desc, 
    // status, 
    // buyer_own,
    // sp_code,
    // sp_desc,
    // created_at) 
    // VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");


    // // Check if the prepare statement was successful
    // if ($stmt) {
    //     // Bind parameters to the statement
    //     $stmt->bind_param(
    //         "ssssssssssssssssssssssssss",
    //         $customer_id,
    //         $customer_name,
    //         $catcode07,
    //         $cat7desc,
    //         $order_no,
    //         $order_type,
    //         $invoice_no,
    //         $invoice_desc,
    //         $item,
    //         $rate,
    //         $quantity,
    //         $unit_measure,
    //         $next_status,
    //         $last_status,
    //         $hold_code,
    //         $order_date,
    //         $datetime,
    //         $load_status,
    //         $vehicle,
    //         $sp_code,
    //         $sp_desc,
    //         $status,
    //         $buyer_own,
    //         $sp_code,
    //         $sp_desc,
    //         $created_at
    //     );


    //     // Execute the statement
    //     if ($stmt->execute() === TRUE) {
    //         // echo json_encode(array("message" => "Record created successfully"));
    //     } else {
    //         // echo json_encode(array("error" => "Error: " . $conn->error));
    //     }

    //     // Close the statement
    //     $stmt->close();
    // } else {
    //     echo json_encode(array("error" => "Prepare statement error: " . $conn->error));
    // }


    // Prepare the INSERT statement with ON DUPLICATE KEY UPDATE
    $stmt = $conn->prepare("INSERT INTO order_sales_invoice (
        customer_id, 
        customer_name, 
        catcode07, 
        cat7desc, 
        order_no, 
        order_type, 
        invoice_no, 
        invoice_desc, 
        item, 
        rate, 
        quantity, 
        unit_measure, 
        next_status, 
        last_status, 
        hold_code, 
        order_date, 
        datetime, 
        load_status, 
        vehicle, 
        carrier_code, 
        carrier_desc, 
        status, 
        buyer_own,
        sp_code,
        sp_desc,
        created_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        hold_code = VALUES(hold_code),
        last_status = VALUES(last_status),
        next_status = VALUES(next_status),
        invoice_no = VALUES(invoice_no),
        update_at = CURRENT_TIMESTAMP");

    // Check if the prepare statement was successful
    if ($stmt) {
        // Bind parameters to the statement
        $stmt->bind_param(
            "ssssssssssssssssssssssssss",
            $customer_id,
            $customer_name,
            $catcode07,
            $cat7desc,
            $order_no,
            $order_type,
            $invoice_no,
            $invoice_desc,
            $item,
            $rate,
            $quantity,
            $unit_measure,
            $next_status,
            $last_status,
            $hold_code,
            $order_date,
            $datetime,
            $load_status,
            $vehicle,
            $carrier_code,
            $carrier_desc,
            $status,
            $buyer_own,
            $sp_code,
            $sp_desc,
            $created_at
        );

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo json_encode(array("message" => "Record created or updated successfully"));
        } else {
            echo json_encode(array("error" => "Error: " . $conn->error));
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(array("error" => "Prepare statement error: " . $conn->error));
    }

    // Close the connection

}

// Close the connection
$conn->close();
?>