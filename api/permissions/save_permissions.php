<?php
// Save permissions for a privilege
include("../../config.php");
header('Content-Type: application/json');

$access_key = '03201232927';
$pass = $_POST["key"] ?? '';

if ($pass !== $access_key) {
    echo json_encode(['status' => 0, 'message' => 'Wrong Key']);
    exit;
}

$privilege = isset($_POST['privilege']) ? mysqli_real_escape_string($db, $_POST['privilege']) : '';
$page_ids = isset($_POST['page_ids']) ? $_POST['page_ids'] : '';

if ($privilege === '') {
    echo json_encode(['status' => 0, 'message' => 'Privilege required']);
    exit;
}

// Pehle is privilege ki saari permissions delete karo
$delete = "DELETE FROM privilege_permissions WHERE privilege = '$privilege'";
if (!mysqli_query($db, $delete)) {
    echo json_encode(['status' => 0, 'message' => 'DB Error: ' . mysqli_error($db)]);
    exit;
}

// Ab nayi permissions insert karo
if (!empty($page_ids)) {
    $ids = explode(',', $page_ids);
    foreach ($ids as $pid) {
        $pid = (int)$pid;
        if ($pid > 0) {
            $insert = "INSERT INTO privilege_permissions (privilege, page_id) VALUES ('$privilege', $pid)";
            mysqli_query($db, $insert);
        }
    }
}

echo json_encode([
    'status'    => 1,
    'message'   => 'Permissions saved successfully',
    'privilege' => $privilege
]);
?>