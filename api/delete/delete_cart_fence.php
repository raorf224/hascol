<?php
include("../config.php");
header("Content-Type: application/json");

// Read raw JSON body
$input = json_decode(file_get_contents("php://input"), true);

// Validate
if (!isset($input['ids']) || !is_array($input['ids']) || count($input['ids']) === 0) {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'No valid IDs provided']);
    exit;
}

// Sanitize & Build Query
$ids = array_map('intval', $input['ids']);
$id_string = implode(',', $ids);

$sql = "DELETE FROM cartraige_fence WHERE id IN ($id_string)";
if (mysqli_query($db, $sql)) {
    echo json_encode(['status' => true, 'message' => 'Records deleted']);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'message' => 'Database error',
        'error' => mysqli_error($db)
    ]);
}
?>
