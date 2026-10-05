<?php
// fetch.php
include("../config.php");
header("Content-Type: application/json");

$access_key = '03201232927';

$pass = $_GET["key"] ?? '';
$date = $_GET["date"] ?? '';

/* ---------------- VALIDATIONS ---------------- */

if ($pass == '') {
    echo json_encode(["error" => "Key is Required"]);
    exit;
}

if ($pass !== $access_key) {
    echo json_encode(["error" => "Wrong Key"]);
    exit;
}

if ($date == '') {
    echo json_encode(["error" => "Date is Required"]);
    exit;
}

/* ---------------- MAIN QUERY ---------------- */

$sql = "
SELECT 
    us.id AS tm_id,
    us.name AS tm_name,

    att.dealers_id,
    dl.name AS dealer_name,
    att.created_at AS first_visit_time,

    CASE 
        WHEN att.tm_id IS NULL THEN 'Absent'
        ELSE 'Present'
    END AS attendance_status

FROM hascolbridge.users us

LEFT JOIN (
    SELECT 
        a.*
    FROM hascolbridge.tm_dealers_attendance a
    JOIN (
        SELECT 
            tm_id,
            MIN(created_at) AS first_time
        FROM hascolbridge.tm_dealers_attendance
        WHERE DATE(created_at) = ?
        GROUP BY tm_id
    ) x 
        ON x.tm_id = a.tm_id 
       AND x.first_time = a.created_at
) att 
    ON att.tm_id = us.id

LEFT JOIN dealers dl 
    ON dl.id = att.dealers_id

WHERE us.privilege = 'ASM'
ORDER BY us.id DESC
";

/* ---------------- EXECUTION ---------------- */

$stmt = $db->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();

$result = $stmt->get_result();

$response = [];
while ($row = $result->fetch_assoc()) {
    $response[] = $row;
}

echo json_encode($response);
?>
