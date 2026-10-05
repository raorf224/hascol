<?php
include("../config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $created_at = date("Y-m-d H:i:s");

    $upload_dir = __DIR__ . '/../uploads/signatures/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    function uploadSignature($file_key, $upload_dir) {
        if (!isset($_FILES[$file_key]) || $_FILES[$file_key]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $extension = pathinfo($_FILES[$file_key]['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = $upload_dir . $filename;

        if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $filepath)) {
            return $filename;
        }
        return false;
    }

    $sig_hascol = uploadSignature('sig_hascol', $upload_dir);
    $sig_customer = uploadSignature('sig_customer', $upload_dir);

    if (!$sig_hascol || !$sig_customer) {
        echo json_encode(["status" => "error", "message" => "Both signatures are required."]);
        exit;
    }

    $required = [
        "delivery_order", "ship_to", "purchase_order", "delivery_order_date", "lorry_no",
        "capacity", "contractor", "supply_source", "seal_no", "product_quantity_ambient",
        "product_quantity_85f", "ref_dip_despatch", "despatch_dip", "despatch_quantity", "despatch_product",
        "despatch_density", "despatch_temperature", "ref_dip_recipt", "recipt_dip", "recipt_quantity",
        "recipt_density", "recipt_product", "recipt_temperature", "time_tank_lorry", "user_id"
    ];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            echo json_encode(["status" => "error", "message" => "$key is required."]);
            exit;
        }
    }

    $data = array_map(function ($value) use ($db) {
        return mysqli_real_escape_string($db, trim($value));
    }, $_POST);

    // Add escaped file names
    $sig_hascol = mysqli_real_escape_string($db, $sig_hascol);
    $sig_customer = mysqli_real_escape_string($db, $sig_customer);

    $query = "INSERT INTO product_activation (
        delivery_order, ship_to, purchase_order, delivery_order_date, lorry_no,
        capacity, contractor, supply_source, seal_no, product_quantity_ambient,
        product_quantity_85f, ref_dip_despatch, despatch_dip, despatch_quantity, despatch_product,
        despatch_density, despatch_temperature, ref_dip_recipt, recipt_dip, recipt_quantity,
        recipt_density, recipt_product, recipt_temperature, time_tank_lorry,
        sig_hascol, sig_customer, created_by, created_at
    ) VALUES (
        '{$data['delivery_order']}', '{$data['ship_to']}', '{$data['purchase_order']}', '{$data['delivery_order_date']}',
        '{$data['lorry_no']}', '{$data['capacity']}', '{$data['contractor']}', '{$data['supply_source']}',
        '{$data['seal_no']}', '{$data['product_quantity_ambient']}', '{$data['product_quantity_85f']}',
        '{$data['ref_dip_despatch']}', '{$data['despatch_dip']}', '{$data['despatch_quantity']}',
        '{$data['despatch_product']}', '{$data['despatch_density']}', '{$data['despatch_temperature']}',
        '{$data['ref_dip_recipt']}', '{$data['recipt_dip']}', '{$data['recipt_quantity']}',
        '{$data['recipt_density']}', '{$data['recipt_product']}', '{$data['recipt_temperature']}',
        '{$data['time_tank_lorry']}', '$sig_hascol', '$sig_customer', '{$data['user_id']}', '$created_at'
    )";

    if (mysqli_query($db, $query)) {
        $id = mysqli_insert_id($db);

        if (function_exists('logSystemActivity')) {
            logSystemActivity($db, $data['user_id'], 'Inserted Product Activation', 'product_activation', $id);
        }

        echo json_encode(["status" => "success", "id" => $id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($db)]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Only POST requests are allowed."]);
}
?>
