<?php
include("../../config.php");

header("Content-Type: application/json");

$access_key = '2170';
$pass = $_GET["key"] ?? '';

if ($pass == '') die(json_encode(["error" => "Key is Required"]));
if ($pass !== $access_key) die(json_encode(["error" => "Wrong Key"]));

$current_day = date('d');
$last_day_of_month = date('t');

// if ($current_day <= 31 && $current_day <= $last_day_of_month) {
//     echo json_encode(["status" => "Not IN"]);
//     exit;
// }

$v_lat = isset($_GET['i_lat']) ? floatval($_GET['i_lat']) : null;
$v_lng = isset($_GET['i_lng']) ? floatval($_GET['i_lng']) : null;
$c_lat = isset($_GET['d_lat']) ? floatval($_GET['d_lat']) : null;
$c_lng = isset($_GET['d_lng']) ? floatval($_GET['d_lng']) : null;

if ($v_lat === null || $v_lng === null || $c_lat === null || $c_lng === null) {
    die(json_encode(["error" => "Missing coordinates"]));
}

$km = 0.6000;

$ky = 40000 / 360;
$kx = cos(pi() * $c_lat / 180.0) * $ky;
$dx = abs($c_lng - $v_lng) * $kx;
$dy = abs($c_lat - $v_lat) * $ky;

$distance = sqrt(($dx * $dx) + ($dy * $dy));

if ($distance <= $km) {

    $tm_id = $_GET["tm_id"] ?? '';
    $dealers_id = $_GET["dealers_id"] ?? '';
    $task_id = $_GET["task_id"] ?? '';
    $created_by = $_GET["created_by"] ?? '';

    if ($tm_id == '' || $dealers_id == '' || $task_id == '' || $created_by == '') {
        echo json_encode(["status" => "IN", "warning" => "Missing insert parameters"]);
        exit;
    }

    $today = date("Y-m-d");

    $check_sql = "SELECT id FROM tm_dealers_attendance 
                  WHERE tm_id=? AND dealers_id=? AND task_id=? AND DATE(check_in_time)=?";
    $stmt2 = $db->prepare($check_sql);
    $stmt2->bind_param("iiis", $tm_id, $dealers_id, $task_id, $today);
    $stmt2->execute();
    $stmt2->store_result();

    if ($stmt2->num_rows > 0) {
        echo json_encode(["status" => "IN", "message" => "Already Marked"]);
        exit;
    }

    // 🟢 Correct Format
    $check_in_time = date("Y-m-d H:i:s");
    $created_at = $check_in_time;

    $insert = "INSERT INTO tm_dealers_attendance
        (`tm_id`, `dealers_id`, `task_id`, `check_in_lat`, `check_in_lng`, `check_in_time`, `created_at`, `created_by`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($insert);

    // 🟢 FIXED BIND PARAM — correct sequence
    $stmt->bind_param(
        "iiiddsss",
        $tm_id,
        $dealers_id,
        $task_id,
        $v_lat,
        $v_lng,
        $check_in_time,
        $created_at,
        $created_by
    );

    if ($stmt->execute()) {
        echo json_encode(["status" => "IN", "insert" => "Success"]);
    } else {
        echo json_encode(["status" => "IN", "insert" => "Failed", "error" => $db->error]);
    }

} else {
    echo json_encode(["status" => "Not IN"]);
}
?>
