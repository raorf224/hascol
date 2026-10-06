<?php
// Delete User API
include("../../config.php");

header('Content-Type: application/json');

$access_key = '03201232927';
$pass = $_GET["key"] ?? '';

if ($pass == '') {
    echo json_encode(['status' => 0, 'message' => 'Key is Required']);
    exit;
}

if ($pass !== $access_key) {
    echo json_encode(['status' => 0, 'message' => 'Wrong Key']);
    exit;
}

$id = $_GET['id'] ?? '';

if ($id === '') {
    echo json_encode(['status' => 0, 'message' => 'ID is required']);
    exit;
}

$sql = "DELETE FROM users WHERE id = '$id'";

if (mysqli_query($db, $sql)) {
    echo json_encode(['status' => 1, 'message' => 'User deleted successfully']);
} else {
    echo json_encode(['status' => 0, 'message' => 'DB Error: ' . mysqli_error($db)]);
}
?>