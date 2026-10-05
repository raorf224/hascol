<?php
include("../config.php");
session_start();
header("Content-Type: application/json");

// Check if request is GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["status_code" => 405, "message" => "Method Not Allowed"]);
    exit;
}

// Check required parameters
if (!isset($_GET["tablename"]) || empty($_GET["tablename"])) {
    http_response_code(400);
    echo json_encode(["status_code" => 400, "message" => "Bad Request: table name is required"]);
    exit;
}

// Validate table name (whitelist approach)
$tablename = $_GET["tablename"];
$allowed_tables = [
    'stops_scouting_lead_generation',
    'stops_suspect',
    'stops_qualification',
    'stops_prospect',
    'stops_negotiation',
    'stops_management_approval',
    'stops_loi_mou_a2l_lease',
    'stops_dc_noc',
    'stops_form_k',
    'stops_commissioned'
];

if (!in_array($tablename, $allowed_tables)) {
    http_response_code(400);
    echo json_encode(["status_code" => 400, "message" => "Invalid table name"]);
    exit;
}

// Optional: Add dealer_id filter
$dealer_id = isset($_GET["dealer_id"]) ? intval($_GET["dealer_id"]) : null;

// Build WHERE clause if dealer_id provided
$where_clause = "";
$params = [];
$types = "";

if ($dealer_id && $dealer_id > 0) {
    $where_clause = " WHERE dealer_id = ?";
    $params[] = $dealer_id;
    $types .= "i";
}

// Build query with ORDER BY id DESC LIMIT 1
$query = "SELECT * FROM `$tablename` $where_clause ORDER BY id DESC LIMIT 1";

// Prepare and execute query
$stmt = mysqli_prepare($db, $query);

if ($stmt) {
    // Bind parameters if any
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            http_response_code(200);
            echo json_encode([
                "status_code" => 200,
                "message" => "Record found successfully",
                "table" => $tablename,
                "data" => $row
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status_code" => 404,
                "message" => "No record found in table: " . $tablename
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