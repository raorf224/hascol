<?php
include("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Inputs
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $order_ids = $_POST['order_ids'] ?? [];
    $approved_order_description = mysqli_real_escape_string(
        $db,
        $_POST['approved_order_description'] ?? 'Cancelled by user'
    );
    $datetime = date('Y-m-d H:i:s');

    // Validate
    if (!is_array($order_ids) || count($order_ids) === 0) {
        echo json_encode(["status" => "error", "message" => "No order IDs provided"]);
        exit;
    }

    // Define cancel status
    $status = 2;
    $status_value = 'Cancelled';

    $success = [];
    $errors = [];

    foreach ($order_ids as $order_id) {
        $order_id = intval($order_id);

        // Update main order table
        $update = "
            UPDATE order_main 
            SET 
                status = '$status',
                status_value = '$status_value',
                comment = '$approved_order_description',
                approved_time = '$datetime'
            WHERE id = '$order_id'
        ";

        if (mysqli_query($db, $update)) {
            // Insert into log table
            $log = "
                INSERT INTO order_detail_log
                    (order_id, status, status_value, description, created_at, created_by)
                VALUES
                    ('$order_id', '$status', '$status_value', '$approved_order_description', '$datetime', '$user_id')
            ";
            if (mysqli_query($db, $log)) {
                $success[] = $order_id;
            } else {
                $errors[$order_id] = 'Log error: ' . mysqli_error($db);
            }
        } else {
            $errors[$order_id] = 'Update error: ' . mysqli_error($db);
        }
    }

    // Prepare response
    if (count($errors) === 0) {
        echo json_encode([
            "status" => "success",
            "message" => "All selected orders cancelled successfully.",
            "orders" => $success
        ]);
    } elseif (count($success) > 0) {
        echo json_encode([
            "status" => "partial",
            "message" => "Some orders cancelled successfully, but some failed.",
            "success" => $success,
            "errors" => $errors
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to cancel any order.",
            "errors" => $errors
        ]);
    }
}
?>
