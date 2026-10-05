<?php
// PHP Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json'); // Output will be JSON
ini_set('max_execution_time', -1);
date_default_timezone_set("Asia/Karachi");

// Database connection is assumed to be in config_apis.php
include("../config_apis.php");

$access_key = "12345";
$post_data = []; // Initialize response array

/**
 * Executes a prepared statement securely and fetches the first column count.
 * Returns an array mimicking mysqli_fetch_array([count]).
 */
function execute_and_fetch_count_securely($connect, $sql, $bind_types, $bind_params, $error_message) {
    if (!$connect) {
        die("Error: Database Connection Failed");
    }

    $stmt = $connect->prepare($sql);
    
    if ($stmt === false) {
        die("Error Prepare: " . $connect->error);
    }
    
    // Dynamically bind parameters using references
    $ref_bind_params = array_merge([$bind_types], $bind_params);
    $refs = [];
    foreach ($ref_bind_params as $key => $value) {
        $refs[$key] = &$ref_bind_params[$key];
    }
    
    // Call bind_param
    call_user_func_array([$stmt, 'bind_param'], $refs);

    if (!$stmt->execute()) {
        die("Error Execute: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $stmt->close();
    
    return [$row[0]];
}


if (isset($_GET['accesskey'])) {
    $access_key_received = $_GET['accesskey'];
    
    if (!isset($_GET['user'])) {
        http_response_code(400);
        die(json_encode(['error' => 'user parameter is required.']));
    }
    
    $user_input = $_GET['user']; // User input, used for secure binding
    
    $todate = date("Y-m-d H:i:s", time());
    $prev_date = date("Y-m-d H:i:s", strtotime($todate .' -1 day'));
    
    // --- DETERMINE BINDING LOGIC ---
    if ($user_input === 'resq911' || $user_input === 'tw_x') {
        // Case 1: Specific trackers. Binds tracker name (string) and date (string).
        $user_condition = "AND pos.tracker = ? AND ud.users_id = 1";
        $user_bind_types = 's';
        $user_bind_params = [$user_input];
    } else {
        // Case 2: Standard user ID. Binds user ID (integer) and date (string).
        $user_id = filter_var($user_input, FILTER_VALIDATE_INT);
        if ($user_id === false) {
             http_response_code(400);
             die(json_encode(['error' => 'Invalid user ID format.']));
        }
        $user_condition = "AND ud.users_id = ?";
        $user_bind_types = 'i';
        $user_bind_params = [$user_id];
    }

    if ($access_key_received == $access_key) {
        
        // --- DEFINE SECURE QUERIES WITH PLACEHOLDERS (Mimicking original format) ---
        // ? placeholders will be replaced by securely bound parameters.
        
        $que1 = "SELECT count(*) as stop FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.speed=0 AND pos.ignition = 'OFF' {$user_condition} AND pos.time >= ?";
        $que2 = "SELECT count(*) as idle FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.speed = 0 AND pos.ignition ='ON' {$user_condition} AND pos.time >= ?";
        $que3 = "SELECT count(*) as inactive FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.time < ? {$user_condition}";
        $que4 = "SELECT count(*) as running FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.speed > 0 AND pos.speed < 60 {$user_condition} AND pos.time >= ?";
        $que5 = "SELECT COUNT(*) as total FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE 1=1 {$user_condition}";
        $que6 = "SELECT count(*) as high_speed FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.speed >= 60 AND pos.ignition = 'ON' {$user_condition} AND pos.time >= ?";
        $que7 = "SELECT count(*) as primary_vehi FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.trip_type='Primary' {$user_condition} AND pos.time >= ?";
        $que8 = "SELECT count(*) as secondary_vehi FROM devicesnew AS pos JOIN users_devices_new ud ON pos.id = ud.devices_id WHERE pos.trip_type='Secondary' {$user_condition} AND pos.time >= ?";

        
        // --- EXECUTE QUERIES AND FETCH RESULTS ---
        // All time-based queries (1, 2, 4, 6, 7, 8) bind [user_param, $prev_date]
        // Inactive query (3) binds [$prev_date, user_param]
        // Total query (5) binds [user_param] only
        
        $row1 = execute_and_fetch_count_securely($connect, $que1, $user_bind_types . 's', array_merge($user_bind_params, [$prev_date]), "Error Q1");
        $row2 = execute_and_fetch_count_securely($connect, $que2, $user_bind_types . 's', array_merge($user_bind_params, [$prev_date]), "Error Q2");
        $row3 = execute_and_fetch_count_securely($connect, $que3, 's' . $user_bind_types, array_merge([$prev_date], $user_bind_params), "Error Q3");
        $row4 = execute_and_fetch_count_securely($connect, $que4, $user_bind_types . 's', array_merge($user_bind_params, [$prev_date]), "Error Q4");
        $row5 = execute_and_fetch_count_securely($connect, $que5, $user_bind_types, $user_bind_params, "Error Q5");
        $row6 = execute_and_fetch_count_securely($connect, $que6, $user_bind_types . 's', array_merge($user_bind_params, [$prev_date]), "Error Q6");
        $row7 = execute_and_fetch_count_securely($connect, $que7, $user_bind_types . 's', array_merge($user_bind_params, [$prev_date]), "Error Q7");
        $row8 = execute_and_fetch_count_securely($connect, $que8, $user_bind_types . 's', array_merge($user_bind_params, [$prev_date]), "Error Q8");
        
        // --- ASSEMBLE OUTPUT ---
        
        $stop = $row1[0];
        $idle = $row2[0];
        $inactive = $row3[0];
        $running = $row4[0];
        $total = $row5[0];
        $nodata = $row6[0]; // Q6 logic (speed>=60) is stored as 'nodata'
        $primary = $row7[0];
        $seconsary = $row8[0];

        $post_data = array('stop' => $stop,
                            'idle' => $idle,
                            'inactive' => $inactive,
                            'running' => $running,
                            'total' => $total,
                            'primary' => $primary,
                            'seconsary' => $seconsary,
                            'nodata' => $nodata);

        // create json output
        $post_data = json_encode($post_data);
    } else {
        http_response_code(401);
        die(json_encode(['error' => 'accesskey is incorrect.']));
    }
} else {
    http_response_code(400);
    die(json_encode(['error' => 'accesskey is required.']));
}

//Output the output.
echo $post_data;

// include_once('../includes/close_database.php');
?>