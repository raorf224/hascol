<?php
// fetch.php  
include("../../config.php");

$access_key = '2170';
$pass = $_GET["key"];
$from = $_GET["from"];
$to = $_GET["to"];
$pre = $_GET["pre"];
$id = $_GET["id"];

if ($pass != '') {
    if ($pass == $access_key) {
        
        // Common SQL structure template
        $common_select = "SELECT 
        it.*, 
        us.name, 
        dd.name AS dealer_name, 
        dd.sap_no AS dealer_sap, 
    
        -- Status Mapping
        CASE
            WHEN it.status = 0 THEN 'Pending'
            WHEN it.status = 1 THEN 'Complete'
            WHEN it.status = 2 THEN 'Cancel'
        END AS current_status,
    
        -- Privilege Mapping
        CASE
            WHEN us.privilege = 'ZM' THEN 'GRM'
            WHEN us.privilege = 'TM' THEN 'RM'
            WHEN us.privilege = 'ASM' THEN 'TM'
            ELSE us.privilege -- Keep default privilege if it doesn't match
        END AS privilege,
    
        -- Approval Status Mapping
        CASE
            WHEN tr.created_at IS NOT NULL THEN 
                CASE
                    WHEN tr.recon_approval = 0 AND tr.approved_status = 1 THEN 'Hold'
                    WHEN tr.recon_approval = 1 THEN 
                        CASE
                            WHEN TIMESTAMPDIFF(HOUR, tr.created_at, tr.approved_at) <= 72 THEN 'Approved On Time'
                            ELSE 'Late Approved'
                        END
                    ELSE 'Still Not Approved'
                END
            ELSE 'Visit Not Complete'
        END AS approval_status,
    
        -- Additional Fields
        tr.created_at AS visit_close_time,
        tr.recon_approval,
        tr.inspection AS inspection_approval,
        tr.approved_status,
        tr.approved_at,
    
        -- Last Visit ID (Before Current Task)
        (SELECT id 
         FROM inspector_task 
         WHERE dealer_id = it.dealer_id 
         AND id < it.id 
         ORDER BY id DESC LIMIT 1) AS last_visit_id,
    
        tr.dealer_sign
    
    FROM inspector_task AS it
    
    JOIN users AS us ON us.id = it.user_id
    LEFT JOIN inspector_task_response AS tr ON tr.task_id = it.id
    JOIN dealers AS dd ON dd.id = it.dealer_id
    
    WHERE it.time BETWEEN '$from' AND '$to' 
    AND it.status = 0 
    AND (it.inspection = 1 AND it.stock_recon = 1) 
    AND tr.dealer_sign IS NULL 
    
    ORDER BY it.id DESC;
    ";

       

        // Execute the query
        $result1 = $db->query($common_select) or die("Error: " . mysqli_error($db));

        $thread = array();
        while ($user = $result1->fetch_assoc()) {
            $thread[] = $user;
        }

        // Convert the data to UTF-8 to ensure proper encoding
        $thread = utf8ize($thread);

        // Return JSON response
        $json = json_encode($thread, JSON_PRETTY_PRINT);
        if ($json === false) {
            echo json_encode(["error" => "JSON encoding failed", "details" => json_last_error_msg()]);
        } else {
            echo $json;
        }

    } else {
        echo 'Wrong Key...';
    }
} else {
    echo 'Key is Required';
}

// Function to ensure proper UTF-8 encoding
function utf8ize($data)
{
    if (is_array($data)) {
        return array_map('utf8ize', $data);
    } elseif (is_string($data)) {
        return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
    }
    return $data;
}
?>