<?php
// fetch.php  
include("../../config.php");

$access_key = '03201232927';

$pass = $_GET["key"] ?? '';
$pre = $_GET["pre"] ?? '';
$id = $_GET["user_id"] ?? '';

if (!$pass) {
    echo 'Key is Required';
    exit;
}

if ($pass !== $access_key) {
    echo 'Wrong Key...';
    exit;
}

$sql_query1 = "SELECT * FROM devicesnew order by time desc;";

$result1 = $db->query($sql_query1) or die("Error: " . mysqli_error($db));

$thread = [];
while ($user = $result1->fetch_assoc()) {
    $thread[] = $user;
}

$thread = utf8ize($thread);
$json = json_encode($thread, JSON_PRETTY_PRINT);

if ($json === false) {
    echo json_encode(["error" => "JSON encoding failed", "details" => json_last_error_msg()]);
} else {
    echo $json;
}

function utf8ize($data) {
    if (is_array($data)) {
        return array_map('utf8ize', $data);
    } elseif (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    }
    return $data;
}
?>