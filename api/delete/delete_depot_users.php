<?php
// delete_user.php
include("../config.php");

$access_key = '2170';
$pass = $_GET["key"] ?? '';
$id = $_GET["id"] ?? '';

if ($pass === '') {
    echo 'Key is Required';
    exit;
}

if ($pass !== $access_key) {
    echo 'Wrong Key...';
    exit;
}

if ($id === '' || !is_numeric($id)) {
    echo 'Invalid or missing ID';
    exit;
}

// First, delete from depot_users_emails where main_id = id
$delete_emails = "DELETE FROM depot_users_emails WHERE main_id = '$id'";
$delete_user   = "DELETE FROM users WHERE id = '$id'";

mysqli_begin_transaction($db);

try {
    mysqli_query($db, $delete_emails);
    mysqli_query($db, $delete_user);

    mysqli_commit($db);
    echo 1;
} catch (Exception $e) {
    mysqli_rollback($db);
    echo 'Error: ' . mysqli_error($db);
}
?>
