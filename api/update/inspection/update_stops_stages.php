<?php
include("../../config.php");
session_start();
header("Content-Type: application/json");

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status_code" => 405, "message" => "Method Not Allowed"]);
    exit;
}

// Validate and sanitize input
$dealer_id = isset($_POST['dealer_id']) ? intval($_POST['dealer_id']) : null;
$table_name = isset($_POST['table_name']) ? $_POST['table_name'] : null;

// Check required fields
if (!$dealer_id || $dealer_id <= 0) {
    http_response_code(400);
    echo json_encode(["status_code" => 400, "message" => "Invalid dealer ID"]);
    exit;
}

if (!$table_name) {
    http_response_code(400);
    echo json_encode(["status_code" => 400, "message" => "Table name is required"]);
    exit;
}

// Validate table name (whitelist approach)
$allowed_tables = [
    'scouting_lead_generation',
    'suspect',
    'qualification',
    'prospect',
    'negotiation',
    'management_approval',
    'loi_mou_a2l_lease',
    'dc_noc',
    'form_k',
    'commissioned'
];

if (!in_array($table_name, $allowed_tables)) {
    http_response_code(400);
    echo json_encode(["status_code" => 400, "message" => "Invalid table name"]);
    exit;
}

// Map table name to its corresponding time field
$time_field_map = [
    'scouting_lead_generation' => 'scouting_lead_generation_time',
    'suspect' => 'suspect_time',
    'qualification' => 'qualification_time',
    'prospect' => 'prospect_time',
    'negotiation' => 'negotiation_time',
    'management_approval' => 'management_approval_time',
    'loi_mou_a2l_lease' => 'loi_mou_a2l_lease_time',
    'dc_noc' => 'dc_noc_time',
    'form_k' => 'form_k_time',
    'commissioned' => 'commissioned_time'
];

$time_field = $time_field_map[$table_name];
$datetime = date('Y-m-d H:i:s');

// Check if dealer exists
$check_dealer = "SELECT id FROM dealers WHERE id = ?";
$stmt_check = mysqli_prepare($db, $check_dealer);
mysqli_stmt_bind_param($stmt_check, "i", $dealer_id);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) === 0) {
    http_response_code(404);
    echo json_encode(["status_code" => 404, "message" => "Dealer not found"]);
    mysqli_stmt_close($stmt_check);
    exit;
}
mysqli_stmt_close($stmt_check);

// Check if record exists in dealers_stages
$check_stage = "SELECT id FROM dealers_stages WHERE dealer_id = ?";
$stmt_stage = mysqli_prepare($db, $check_stage);
mysqli_stmt_bind_param($stmt_stage, "i", $dealer_id);
mysqli_stmt_execute($stmt_stage);
$result_stage = mysqli_stmt_get_result($stmt_stage);

if (mysqli_num_rows($result_stage) === 0) {
    // If no record exists, insert new record with both status and time
    $insert_query = "INSERT INTO `dealers_stages` 
                     (`dealer_id`, `$table_name`, `$time_field`, `created_at`, `updated_at`) 
                     VALUES (?, '1', ?, ?, ?)";
    
    $stmt_insert = mysqli_prepare($db, $insert_query);
    mysqli_stmt_bind_param($stmt_insert, "isss", $dealer_id, $datetime, $datetime, $datetime);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        http_response_code(201);
        echo json_encode([
            "status_code" => 201,
            "message" => "Stage created and updated successfully",
            "data" => [
                "dealer_id" => $dealer_id,
                "table_name" => $table_name,
                "status" => "1",
                "time_field" => $time_field,
                "updated_at" => $datetime
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status_code" => 500,
            "message" => "Database Error: " . mysqli_stmt_error($stmt_insert)
        ]);
    }
    mysqli_stmt_close($stmt_insert);
    mysqli_stmt_close($stmt_stage);
    exit;
}
mysqli_stmt_close($stmt_stage);

// Update query with both status and time field
$query = "UPDATE `dealers_stages` 
          SET `$table_name` = '1', 
              `$time_field` = ?, 
              `updated_at` = ? 
          WHERE `dealer_id` = ?";

$stmt = mysqli_prepare($db, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssi", $datetime, $datetime, $dealer_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Check if any row was affected
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            http_response_code(200);
            echo json_encode([
                "status_code" => 200,
                "message" => "Stage updated successfully",
                "data" => [
                    "dealer_id" => $dealer_id,
                    "table_name" => $table_name,
                    "status" => "1",
                    "time_field" => $time_field,
                    "updated_at" => $datetime
                ]
            ]);
        } else {
            // No rows affected (maybe already set to 1)
            http_response_code(200);
            echo json_encode([
                "status_code" => 200,
                "message" => "Stage is already active",
                "data" => [
                    "dealer_id" => $dealer_id,
                    "table_name" => $table_name,
                    "status" => "1",
                    "time_field" => $time_field
                ]
            ]);
        }
    } else {
        http_response_code(500);
        echo json_encode([
            "status_code" => 500,
            "message" => "Database Error: " . mysqli_stmt_error($stmt)
        ]);
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode([
        "status_code" => 500,
        "message" => "Database Error: " . mysqli_error($db)
    ]);
}

mysqli_close($db);
?>