<?php
include("../config.php");
session_start();

header('Content-Type: application/json'); // Force JSON output

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['ids']) || !is_array($data['ids']) || empty($data['ids'])) {
        echo json_encode(['success' => false, 'message' => 'No valid IDs provided']);
        exit;
    }

    $ids = array_map('intval', $data['ids']);
    $ids_list = implode(',', $ids);

    $query = "UPDATE `order_sales_invoice` SET `finance_status`='1' WHERE id IN ($ids_list)";
    if (mysqli_query($db, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . mysqli_error($db)
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
