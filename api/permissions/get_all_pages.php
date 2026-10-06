<?php
// Get all pages from pages table
include("../../config.php");
header('Content-Type: application/json');

$access_key = '03201232927';
$pass = $_GET["key"] ?? '';

if ($pass !== $access_key) {
    echo json_encode(['status' => 0, 'message' => 'Wrong Key']);
    exit;
}

$sql = "SELECT id, page_name, page_url FROM pages WHERE status = 1 ORDER BY id ASC";
$result = mysqli_query($db, $sql);

$pages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pages[] = [
        'id'        => (int)$row['id'],
        'page_name' => $row['page_name'],
        'page_url'  => $row['page_url']
    ];
}

echo json_encode($pages);
?>