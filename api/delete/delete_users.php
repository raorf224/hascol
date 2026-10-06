<?php
// api/get/delete_user_handler.php
include("../../config.php");

$access_key = '03201232927';
$pass = $_GET["key"] ?? '';

if ($pass !== $access_key) {
    echo '0';
    exit;
}

$id = $_GET['id'] ?? '';

if ($id === '') {
    echo '0';
    exit;
}

$sql = "DELETE FROM users WHERE id = '$id'";

if (mysqli_query($db, $sql)) {
    echo 1;
} else {
    echo 'Error' . mysqli_error($db);
}
?>