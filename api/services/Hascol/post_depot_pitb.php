<?php
include("../../hacol_conif_post.php");

// Create pitb_depot table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS pitb_depot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    PLANT_CODE VARCHAR(50) NOT NULL,
    PLANT_NAME VARCHAR(100) NOT NULL,
    TANK_NAME VARCHAR(100),
    PROD_CODE VARCHAR(50),
    PROD_DESC VARCHAR(200),
    AVAIL_QTY DECIMAL(15,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_depot (PLANT_CODE, TANK_NAME, PROD_CODE)
)";

if ($conn->query($createTableSQL) === TRUE) {
    // Table created successfully or already exists
} else {
    echo "Error creating table: " . $conn->error;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get all fields from POST
    $plant_code = isset($_POST['PLANT_CODE']) ? $_POST['PLANT_CODE'] : '';
    $plant_name = isset($_POST['PLANT_NAME']) ? $_POST['PLANT_NAME'] : '';
    $tank_name = isset($_POST['TANK_NAME']) ? $_POST['TANK_NAME'] : '';
    $prod_code = isset($_POST['PROD_CODE']) ? $_POST['PROD_CODE'] : '';
    $prod_desc = isset($_POST['PROD_DESC']) ? $_POST['PROD_DESC'] : '';
    $avail_qty = isset($_POST['AVAIL_QTY']) ? $_POST['AVAIL_QTY'] : 0;
    
    // Check if record already exists
    $checkStmt = $conn->prepare("SELECT id FROM pitb_depot WHERE PLANT_CODE = ? AND TANK_NAME = ? AND PROD_CODE = ?");
    $checkStmt->bind_param("sss", $plant_code, $tank_name, $prod_code);
    $checkStmt->execute();
    $checkStmt->store_result();
    
    if ($checkStmt->num_rows > 0) {
        // Record exists - update it
        $checkStmt->close();
        
        $updateStmt = $conn->prepare("UPDATE pitb_depot SET 
            PLANT_NAME = ?, 
            PROD_DESC = ?, 
            AVAIL_QTY = ?,
            updated_at = CURRENT_TIMESTAMP
            WHERE PLANT_CODE = ? AND TANK_NAME = ? AND PROD_CODE = ?");
        
        $updateStmt->bind_param("ssdsss", $plant_name, $prod_desc, $avail_qty, $plant_code, $tank_name, $prod_code);
        
        if ($updateStmt->execute()) {
            echo json_encode(array("message" => "Record updated successfully", "action" => "updated"));
        } else {
            echo json_encode(array("error" => "Update failed: " . $conn->error));
        }
        $updateStmt->close();
        
    } else {
        // Record doesn't exist - insert new record
        $checkStmt->close();
        
        $insertStmt = $conn->prepare("INSERT INTO pitb_depot 
            (PLANT_CODE, PLANT_NAME, TANK_NAME, PROD_CODE, PROD_DESC, AVAIL_QTY, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        $insertStmt->bind_param("sssssd", $plant_code, $plant_name, $tank_name, $prod_code, $prod_desc, $avail_qty);
        
        if ($insertStmt->execute()) {
            echo json_encode(array("message" => "Record inserted successfully", "action" => "inserted"));
        } else {
            echo json_encode(array("error" => "Insert failed: " . $conn->error));
        }
        $insertStmt->close();
    }
}

// Close the connection
$conn->close();
?>