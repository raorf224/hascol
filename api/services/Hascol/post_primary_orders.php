<?php
include("../../hacol_conif_post.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Receiving values sent via POST
    $customer_id = $_POST['FR_DEPOT'] ?? '';
    $customer_name = $_POST['SOURCE'] ?? '';
    $order_no = $_POST['ORDER#'] ?? '';
    $order_type = $_POST['ORDERTYPE'] ?? '';
    $invoice_no = $_POST['INVOICE#'] ?? '';
    $invoice_desc = $_POST['INVOICETYPE'] ?? '';
    $item = $_POST['ITEM'] ?? '';
    $quantity = $_POST['QUANTITY'] ?? 0;
    $unit_measure = $_POST['UNITMEASURE'] ?? '';
    $order_date = $_POST['ORDERDATE'] ?? '';
    $load_status = $_POST['LOADSTATUS'] ?? '';
    $vehicle = $_POST['VEHICLE#'] ?? '';
    $carrier_code = $_POST['CARRIERCODE'] ?? '';
    $carrier_desc = $_POST['CARRIERDESC'] ?? '';
    $buyer_own = $_POST['BUYERSOWN'] ?? '';
    $sp_code = $_POST['TO_DEPOT'] ?? '';
    $sp_desc = $_POST['DESTINATION'] ?? '';

    $status = 0;
    $created_at = date('Y-m-d H:i:s');
    $update_at = NULL;

    // Rate logic
   
    $invoice_amount = '';

    // Insert into database
    $insert = "INSERT INTO `primary_movement_sales_orders`
    (
         `customer_id`, `customer_name`, `order_no`, `order_type`, `invoice_no`, `invoice_type`,
        `item`, `rate`, `quantity`, `unit_measure`, `inovice_amount`, `order_date`, `invoice_date`,
        `load_status`, `vehicles`, `carrier_code`, `carrier_desc`, `buyer_own`,
        `depot_code`, `depot_name`, `status`, `created_at`, `update_at`
    )
    VALUES (
        '$customer_id', '$customer_name', '$order_no', '$order_type', '$invoice_no', '$invoice_desc',
        '$item', '$rate', '$quantity', '$unit_measure', '$invoice_amount', '$order_date', '$order_date',
        '$load_status', '$vehicle', '$carrier_code', '$carrier_desc', '$buyer_own',
        '$sp_code', '$sp_desc', '$status', '$created_at', ''
    )";

    if (mysqli_query($conn, $insert)) {
        echo json_encode(["success" => true, "msg" => "Inserted"]);
    } else {
        echo json_encode(["error" => mysqli_error($conn)]);
    }

    mysqli_close($conn);

} else {
    echo json_encode(["error" => "Invalid request method. Use POST."]);
}
?>
