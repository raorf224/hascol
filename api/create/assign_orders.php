<?php
include("../../config.php");
session_start();

// Accept raw JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['orders'], $input['cart_user_id']) || !is_array($input['orders']) || empty($input['orders'])) {
    http_response_code(400);
    echo json_encode(['status' => 0, 'message' => 'Invalid or missing input.']);
    exit;
}

$orders = $input['orders'];
$cart_id = mysqli_real_escape_string($db, $input['cart_user_id']);
$created_by = $_SESSION['user_id'] ?? 0;
$created_at = date('Y-m-d H:i:s');

$inserted = 0;
$skipped = 0;
$errors = [];

foreach ($orders as $order_id) {
    $order_id = mysqli_real_escape_string($db, $order_id);

    $query = "INSERT INTO `cart_users_sales_orders` (`sale_order_id`, `cart_id`, `created_at`, `created_by`)
              VALUES ('$order_id', '$cart_id', '$created_at', '$created_by')";

    if (!mysqli_query($db, $query)) {
        if (mysqli_errno($db) == 1062) {
            // Duplicate entry
            $skipped++;
            continue;
        } else {
            $errors[] = "Error for order $order_id: " . mysqli_error($db);
        }
    } else {
        $inserted++;
    }
}

// Final response
if (!empty($errors)) {
    http_response_code(207); // Multi-Status
    echo json_encode([
        'status' => 0,
        'inserted' => $inserted,
        'skipped' => $skipped,
        'errors' => $errors
    ]);
} else {
    echo json_encode([
        'status' => 1,
        'inserted' => $inserted,
        'skipped' => $skipped,
        'message' => 'Orders processed successfully.'
    ]);
}
?>
