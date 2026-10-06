<?php
// delete_eng_dealer.php (GET version)
include("../config.php");

$access_key = '2170';
$pass = $_GET["key"] ?? '';
$ids_raw = $_GET["ids"] ?? '';

if ($pass === '') {
    echo 'Key is Required';
    exit;
}

if ($pass !== $access_key) {
    echo 'Wrong Key...';
    exit;
}

if (empty($ids_raw)) {
    echo 'No IDs provided';
    exit;
}

// Convert comma-separated string to array and sanitize
$id_array = array_filter(array_map('intval', explode(',', $ids_raw)));
if (empty($id_array)) {
    echo 'No valid IDs found';
    exit;
}

$id_list = implode(',', $id_array);

$sql = "DELETE FROM `eng_users_dealers` WHERE id IN ($id_list)";

if (mysqli_query($db, $sql)) {
    echo 1;
} else {
    echo 'Error: ' . mysqli_error($db);
}
?>
