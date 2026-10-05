<?php
// API: update_tm_order_status.php - Update order status by TM
include("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? 0;
    $status = $_POST['status'] ?? 0;
    $status_value = $_POST['status_value'] ?? '';
    $remarks = $_POST['remarks'] ?? '';
    $user_id = $_POST['user_id'] ?? 0;

    // Check if order exists and is in correct state
    $check_sql = "SELECT status FROM order_main WHERE id = '$order_id'";
    $check_result = mysqli_query($db, $check_sql);
    $check_row = mysqli_fetch_assoc($check_result);

    if (!$check_row) {
        echo "0";
        exit;
    }

    $current_status = $check_row['status'];

    // Validate status transition
    $valid_transitions = [
        '0' => ['8', '2', '7'], // Pending -> TM Approved, Cancelled, Hold
        '7' => ['8', '2'],      // Hold -> TM Approved, Cancelled
        '8' => ['1', '2']       // TM Approved -> Approved, Cancelled
    ];

    if (!isset($valid_transitions[$current_status]) || !in_array($status, $valid_transitions[$current_status])) {
        echo "0";
        exit;
    }

    // Update order main
    $update_sql = "UPDATE order_main 
                   SET status = '$status', 
                       status_value = '$status_value', 
                       approved_time = NOW() 
                   WHERE id = '$order_id'";
    
    if (mysqli_query($db, $update_sql)) {
        // Insert into order logs
        $log_sql = "INSERT INTO order_logs (order_id, status, status_value, description, user_id, created_at) 
                    VALUES ('$order_id', '$status', '$status_value', '$remarks', '$user_id', NOW())";
        mysqli_query($db, $log_sql);
        echo "1";
    } else {
        echo "0";
    }
}
?>