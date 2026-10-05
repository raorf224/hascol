<?php
header("Content-Type: application/json");
include("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Parse JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['order_ids']) || !is_array($input['order_ids']) || empty($input['order_ids'])) {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Invalid or missing order_ids']);
    exit;
}

$order_ids = $input['order_ids'];
$now = date("Y-m-d H:i:s");

$success = [];
$fail = [];

foreach ($order_ids as $id) {
    $id = intval($id); // sanitize
    if ($id <= 0) {
        $fail[] = ['id' => $id, 'error' => 'Invalid ID'];
        continue;
    }

    $sql = "UPDATE order_info 
            SET 
                close_time = '$now',
                last_check = '$now',
                status = 2,
                is_forced_closed = 1,
                remain_distance = 0
            WHERE id = $id";

    if (mysqli_query($db, $sql)) {
        if (mysqli_affected_rows($db) > 0) {
            $success[] = $id;
        } else {
            $fail[] = ['id' => $id, 'error' => 'No rows updated'];
        }
    } else {
        $fail[] = ['id' => $id, 'error' => mysqli_error($db)];
    }
}

echo json_encode([
    'status' => true,
    'message' => 'Update complete',
    'success_ids' => $success,
    'failed' => $fail
]);
exit;
