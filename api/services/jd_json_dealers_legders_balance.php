<?php
// fetch.php  

ini_set('max_execution_time', '0');
$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 7200; URL=$url1");
include("../config.php");
set_time_limit(5000); // Set time limit for long-running queries

$access_key = '2170';

echo 'Start Time: ' . date('Y-m-d H:i:s') . '<br>';

$pass = isset($_GET["key"]) ? $_GET["key"] : ''; // Check if key is set

if ($pass !== '') {
    if ($pass === $access_key) {
        // Query to get the latest record from the table
        $sql_query1 = "SELECT * FROM dealers_jd_ledger_data WHERE status=0 ORDER BY id DESC LIMIT 1;";
        $result1 = $db->query($sql_query1) or die("Error: " . $db->error);
        firebase_log('HascolBridge', 'jd_json_dealers_legders_balance.php', 'Success', "Run successfully.");

        if ($result1->num_rows > 0) {
            while ($user = $result1->fetch_assoc()) {
                $id = $user['id'];
                $json_data = $user['json_data'];

                // Decode the JSON data
                $dataArray = json_decode($json_data, true);

                // Check if decoding was successful
                if (json_last_error() === JSON_ERROR_NONE) {
                    // Iterate over each record in the array
                    foreach ($dataArray as $item) {
                        $customer_id = $item['customer_id'];
                        $name = $item['name'];
                        $balance = $item['balance'];
                        $lastbalance = $item['lastbalance'];

                        // Fetch dealer information
                        $sql = "SELECT * FROM dealers WHERE sap_no='$customer_id' ORDER BY id DESC";
                        $result = $db->query($sql);
                        
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $dealers_id = $row['id'];
                            $acount = $row['acount'];

                            // Update account balance
                            $query = "UPDATE dealers SET acount='$balance' WHERE sap_no='$customer_id'";

                            if ($db->query($query) === TRUE) {
                                // Log the update
                                $log = "INSERT INTO dealer_ledger_log
                                (dealer_id, old_ledger, new_ledger, datetime, description, doc_no, debit_no, assignment_no, document_type, sap_no, ledger_balance, created_at, created_by)
                                VALUES
                                ('$dealers_id', '$acount', '$balance', '$lastbalance', '', '', '', '', '', '$customer_id', '$lastbalance', NOW(), '1')";

                                if ($db->query($log) === TRUE) {
                                    $output = 1; // Successful update
                                } else {
                                    $output = 'Log Error: ' . $db->error . '<br>';
                                }
                            } else {
                                $output = 'Update Error: ' . $db->error . '<br>' . $query;
                            }
                        }
                    }
                } else {
                    echo "Error decoding JSON: " . json_last_error_msg();
                }
            }
            $update_status_sql = "UPDATE dealers_jd_ledger_data SET status = 1 WHERE id = ?";
                    $update_stmt = $db->prepare($update_status_sql);

                    if ($update_stmt) {
                        // Bind the ID of the record to update
                        $update_stmt->bind_param("i", $id);

                        // Execute the update
                        if ($update_stmt->execute()) {
                            echo "Status of the processed record updated to 1.<br>";
                        } else {
                            echo "Error updating status: " . $update_stmt->error . "<br>";
                        }

                        // Close the update statement
                        $update_stmt->close();
                    } else {
                        echo "Error preparing update statement: " . $db->error . "<br>";
                    }
        } else {
            echo "No data found.";
        }
    } else {
        echo 'Wrong Key...';
    }
} else {
    echo 'Key is Required';
}

echo 'End Time: ' . date('Y-m-d H:i:s') . '<br>';


function firebase_log($company, $service, $status, $message) {

    $payload = json_encode([
        'company' => $company,
        'service' => $service,
        'status' => $status,
        'message' => $message
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://151.106.17.246:8080/firebase_systems_logs/firebase_bridge.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $payload, // Data ko JSON string ke roop mein bhejein
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json', // Yeh header ab data format se match karega
        'Content-Length: ' . strlen($payload)
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
}
?>
