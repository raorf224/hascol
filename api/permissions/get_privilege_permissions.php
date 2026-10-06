<?php
// Get permissions for a specific privilege
include("../../config.php");
header('Content-Type: application/json');

$access_key = '2170';
$pass = $_GET["key"] ?? '';

if ($pass !== $access_key) {
    echo json_encode(['status' => 0, 'message' => 'Wrong Key']);
    exit;
}

$privilege = isset($_GET['privilege']) ? mysqli_real_escape_string($db, $_GET['privilege']) : '';

if ($privilege === '') {
    echo json_encode(['status' => 0, 'message' => 'Privilege required']);
    exit;
}

$sql = "SELECT page_id FROM privilege_permissions WHERE privilege = '$privilege'";
$result = mysqli_query($db, $sql);

$page_ids = [];
while ($row = mysqli_fetch_assoc($result)) {
    $page_ids[] = (int)$row['page_id'];
}

echo json_encode([
    'status'    => 1,
    'privilege' => $privilege,
    'page_ids'  => $page_ids
]);
?>