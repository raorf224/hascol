<?php
include("../../config.php");
session_start();
set_time_limit(0);
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $date = date('Y-m-d H:i:s');
    
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $fileName = $_FILES['csv_file']['tmp_name'];
        
        if (($handle = fopen($fileName, "r")) !== FALSE) {
            // Read all CSV data at once
            $allData = [];
            fgetcsv($handle); // Skip header
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $allData[] = $data;
            }
            fclose($handle);
            
            if (empty($allData)) {
                echo json_encode(["status" => "error", "message" => "CSV file is empty"]);
                exit;
            }
            
            // STEP 1: Collect all unique SAP codes and products
            $sapCodes = [];
            $products = [];
            foreach ($allData as $row) {
                $sapCodes[] = trim($row[0]);
                $products[] = trim($row[2]);
            }
            $sapCodes = array_unique($sapCodes);
            $products = array_unique($products);
            
            // STEP 2: Get ALL dealers in ONE query
            $sapCodesStr = "'" . implode("','", array_map(function($code) use ($db) {
                return mysqli_real_escape_string($db, $code);
            }, $sapCodes)) . "'";
            
            $dealerMap = [];
            $dealerQuery = "SELECT id, sap_no FROM dealers WHERE sap_no IN ($sapCodesStr)";
            $dealerResult = mysqli_query($db, $dealerQuery);
            while ($row = mysqli_fetch_assoc($dealerResult)) {
                $dealerMap[$row['sap_no']] = $row['id'];
            }
            
            // STEP 3: Prepare batch data
            $existingRecords = [];
            $batchInserts = [];
            $batchUpdates = [];
            $batchLogs = [];
            
            // First, find all existing records in ONE query
            $conditions = [];
            foreach ($allData as $row) {
                $sap = trim($row[0]);
                $product = trim($row[2]);
                if (isset($dealerMap[$sap])) {
                    $dealerId = $dealerMap[$sap];
                    $conditions[] = "(dealer_id = $dealerId AND name = '$product')";
                }
            }
            
            if (!empty($conditions)) {
                $existingQuery = "SELECT id, dealer_id, name FROM dealers_products WHERE " . implode(" OR ", $conditions);
                $existingResult = mysqli_query($db, $existingQuery);
                while ($row = mysqli_fetch_assoc($existingResult)) {
                    $key = $row['dealer_id'] . '|' . $row['name'];
                    $existingRecords[$key] = $row['id'];
                }
            }
            
            // STEP 4: Process each row for batch operations
            foreach ($allData as $row) {
                $dealerr_code = trim($row[0]);
                $product = trim($row[2]);
                $freight = trim($row[3]);
                $indent_price = trim($row[4]);
                $nozel_price = trim($row[5]);
                $from = trim($row[6]);
                $to = trim($row[7]);
                
                if (!isset($dealerMap[$dealerr_code])) {
                    continue; // Skip if dealer not found
                }
                
                $dealer_db_id = $dealerMap[$dealerr_code];
                $key = $dealer_db_id . '|' . $product;
                
                // Escape values
                $product_esc = mysqli_real_escape_string($db, $product);
                $from_esc = mysqli_real_escape_string($db, $from);
                $to_esc = mysqli_real_escape_string($db, $to);
                $freight_esc = mysqli_real_escape_string($db, $freight);
                $indent_esc = mysqli_real_escape_string($db, $indent_price);
                $nozel_esc = mysqli_real_escape_string($db, $nozel_price);
                
                if (isset($existingRecords[$key])) {
                    // UPDATE - queue for batch
                    $dealer_product_id = $existingRecords[$key];
                    $batchUpdates[] = "UPDATE dealers_products 
                                      SET `from` = '$from_esc',
                                          `to` = '$to_esc',
                                          freight_value = '$freight_esc',
                                          indent_price = '$indent_esc',
                                          nozel_price = '$nozel_esc',
                                          update_time = '$date'
                                      WHERE id = $dealer_product_id";
                    
                    $batchLogs[] = "($dealer_db_id, $dealer_product_id, '$indent_esc', '$nozel_esc', '$freight_esc', '$from_esc', '$to_esc', 'Updated via importer', '$date', $user_id)";
                } else {
                    // INSERT - queue for batch
                    $batchInserts[] = "($dealer_db_id, '$product_esc', '$freight_esc', '$indent_esc', '$nozel_esc', '$from_esc', '$to_esc', '$date')";
                }
            }
            
            // STEP 5: Execute batch operations
            $update_count = 0;
            $insert_count = 0;
            $errors = [];
            $success = true;
            
            // Start transaction
            mysqli_begin_transaction($db);
            
            try {
                // Handle updates
                if (!empty($batchUpdates)) {
                    foreach ($batchUpdates as $updateQuery) {
                        if (mysqli_query($db, $updateQuery)) {
                            $update_count++;
                        } else {
                            throw new Exception("Update failed: " . mysqli_error($db));
                        }
                    }
                }
                
                // Handle inserts
                if (!empty($batchInserts)) {
                    $insertQuery = "INSERT INTO dealers_products 
                                   (dealer_id, name, freight_value, indent_price, nozel_price, `from`, `to`, created_at) 
                                   VALUES " . implode(", ", $batchInserts);
                    
                    if (mysqli_query($db, $insertQuery)) {
                        $insert_count = count($batchInserts);
                        $firstId = mysqli_insert_id($db);
                        
                        // Add logs for inserted records
                        for ($i = 0; $i < count($batchInserts); $i++) {
                            // Extract dealer_id from insert value
                            preg_match("/\(([^,]+),/", $batchInserts[$i], $matches);
                            $dealer_id_log = $matches[1];
                            $product_id_log = $firstId + $i;
                            
                            // Extract values from insert
                            preg_match("/,'([^']+)','([^']+)','([^']+)','([^']+)','([^']+)','([^']+)',/", $batchInserts[$i], $valueMatches);
                            $batchLogs[] = "($dealer_id_log, $product_id_log, '{$valueMatches[3]}', '{$valueMatches[4]}', '{$valueMatches[2]}', '{$valueMatches[5]}', '{$valueMatches[6]}', 'Inserted via importer', '$date', $user_id)";
                        }
                    } else {
                        throw new Exception("Batch insert failed: " . mysqli_error($db));
                    }
                }
                
                // Handle logs
                if (!empty($batchLogs)) {
                    $logQuery = "INSERT INTO dealer_nozel_price_log 
                                (dealer_id, product_id, indent_price, nozel_price, freight_value, `from`, `to`, description, created_at, created_by) 
                                VALUES " . implode(", ", $batchLogs);
                    
                    if (!mysqli_query($db, $logQuery)) {
                        throw new Exception("Log insert failed: " . mysqli_error($db));
                    }
                }
                
                mysqli_commit($db);
                
                echo json_encode([
                    "status" => "success",
                    "message" => "Data processed successfully!",
                    "total_records" => count($allData),
                    "updates" => $update_count,
                    "inserts" => $insert_count
                ]);
                
            } catch (Exception $e) {
                mysqli_rollback($db);
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage(),
                    "errors" => [$e->getMessage()]
                ]);
            }
            
        } else {
            echo json_encode(["status" => "error", "message" => "Error opening file"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No file uploaded"]);
    }
    
    $db->close();
}
?>