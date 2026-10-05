<?php
include("../config.php");
session_start();
header("Content-Type: application/json");

try {
    // Check if request is POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["status_code" => 405, "message" => "Method Not Allowed"]);
        exit;
    }

    // Check required parameters
    if (!isset($_POST["user_id"]) || !isset($_POST["json_data"]) || !isset($_POST["dealer_id"])) {
        http_response_code(400);
        echo json_encode(["status_code" => 400, "message" => "Bad Request: Missing parameters"]);
        exit;
    }

    // Validate and sanitize inputs
    $user_id = filter_var($_POST["user_id"], FILTER_VALIDATE_INT);
    $dealer_id = filter_var($_POST["dealer_id"], FILTER_VALIDATE_INT);
    $response = $_POST["json_data"];
    $tablename = isset($_POST["tablename"]) ? $_POST["tablename"] : 'dealers_responses';
    $datetime = date('Y-m-d H:i:s');

    // Validate IDs
    if ($user_id === false || $user_id <= 0) {
        http_response_code(400);
        echo json_encode(["status_code" => 400, "message" => "Invalid user ID"]);
        exit;
    }

    if ($dealer_id === false || $dealer_id <= 0) {
        http_response_code(400);
        echo json_encode(["status_code" => 400, "message" => "Invalid dealer ID"]);
        exit;
    }

    // Validate JSON data
    $json_decoded = json_decode($response, true);
    if ($json_decoded === null) {
        http_response_code(400);
        echo json_encode(["status_code" => 400, "message" => "Invalid JSON data"]);
        exit;
    }

    // Validate table name (whitelist)
    // $allowed_tables = ['dealers_responses', 'dealers_stages', 'dealers_logs'];
    // if (!in_array($tablename, $allowed_tables)) {
    //     http_response_code(400);
    //     echo json_encode(["status_code" => 400, "message" => "Invalid table name"]);
    //     exit;
    // }

    // Check if dealer exists
    $stmt = $db->prepare("SELECT id FROM dealers WHERE id = ?");
    $stmt->bind_param("i", $dealer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(["status_code" => 404, "message" => "Dealer not found"]);
        exit;
    }
    $stmt->close();

    // Insert data
    $query = "INSERT INTO `$tablename` (`dealer_id`, `json_data`, `created_at`, `created_by`) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("issi", $dealer_id, $response, $datetime, $user_id);
    
    if ($stmt->execute()) {
        $insert_id = $db->insert_id;
        http_response_code(201);
        echo json_encode([
            "status_code" => 201,
            "message" => "Data inserted successfully",
            "data" => [
                "id" => $insert_id,
                "dealer_id" => $dealer_id,
                "created_at" => $datetime,
                "created_by" => $user_id
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "status_code" => 500,
            "message" => "Database Error: " . $stmt->error
        ]);
    }
    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status_code" => 500,
        "message" => "Server Error: " . $e->getMessage()
    ]);
}

$db->close();
?>