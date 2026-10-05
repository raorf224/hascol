<?php
// fetch.php  
include("../../config.php");

$access_key = '03201232927';
$pass = isset($_GET["key"]) ? $_GET["key"] : '';

if ($pass == '') {
    die('Key is Required');
}

if ($pass !== $access_key) {
    die('Wrong Key...');
}

// Date check logic
$current_day = date('d'); // e.g. 26
$current_month = date('m'); // e.g. 11
$current_year = date('Y'); // e.g. 2025
$last_day_of_month = date('t'); // last day of current month

// If current date is after 25th and before or equal to last date of month
if ($current_day > 25 && $current_day <= $last_day_of_month) {
    echo 'Not IN';
    exit;
}

// If date <= 25, perform normal distance check
$v_lat = floatval($_GET['i_lat']);
$v_lng = floatval($_GET['i_lng']);
$c_lat = floatval($_GET['d_lat']);
$c_lng = floatval($_GET['d_lng']);

$km = 0.3000;

$ky = 40000 / 360;
$kx = cos(pi() * $c_lat / 180.0) * $ky;
$dx = abs($c_lng - $v_lng) * $kx;
$dy = abs($c_lat - $v_lat) * $ky;

$distance = sqrt(($dx * $dx) + ($dy * $dy));

if ($distance <= $km) {
    echo 'IN';
} else {
    echo 'Not IN';
}
?>