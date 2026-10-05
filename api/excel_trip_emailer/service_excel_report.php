<?php
// Error reporting off to hide notices
error_reporting(0);
ini_set('display_errors', 0);

session_start();
include("../config.php");

// Set time limit to unlimited
set_time_limit(0);
ini_set('memory_limit', '512M');

// Function to fetch tracking data from API
function getTrackingData($vehicle, $from_date, $to_date) {
    $url = "http://151.106.17.246:8080/hascolbridgeApis/excel_trip_emailer/get_position_data.php?vehicle=" . urlencode($vehicle) . "&from_date=" . urlencode($from_date) . "&to_date=" . urlencode($to_date);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($curl_error) {
        return ['success' => false, 'error' => 'CURL Error: ' . $curl_error, 'http_code' => $http_code];
    }
    
    if (empty($response)) {
        return ['success' => false, 'error' => 'Empty response from API', 'http_code' => $http_code];
    }
    
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['success' => false, 'error' => 'JSON Parse Error: ' . json_last_error_msg(), 'http_code' => $http_code];
    }
    
    if (is_array($data) && !empty($data)) {
        if (isset($data['success']) && $data['success'] == 1) {
            if (isset($data['data']) && is_array($data['data']) && !empty($data['data'])) {
                return ['success' => true, 'data' => $data['data']];
            } else {
                return ['success' => true, 'data' => [], 'empty' => true];
            }
        } else {
            return ['success' => true, 'data' => $data];
        }
    } else {
        return ['success' => false, 'error' => 'Invalid response structure'];
    }
}

// Function to filter tracking data between start_time and close_time
function filterTrackingDataByTime($trackingData, $startTime, $closeTime) {
    if (empty($trackingData) || empty($startTime) || empty($closeTime)) {
        return [];
    }
    
    $filteredData = [];
    $startTimestamp = strtotime($startTime);
    $closeTimestamp = strtotime($closeTime);
    
    foreach ($trackingData as $point) {
        $lat = isset($point['latitude']) ? $point['latitude'] : ($point[1] ?? 0);
        $lon = isset($point['longitude']) ? $point['longitude'] : ($point[2] ?? 0);
        $gps_time = isset($point['gps_time']) ? $point['gps_time'] : (isset($point['time']) ? $point['time'] : ($point[4] ?? ''));
        $vehicle_number = isset($point['vehicle_number']) ? $point['vehicle_number'] : (isset($point['vehicle_name']) ? $point['vehicle_name'] : ($point[3] ?? ''));
        $location = isset($point['location']) ? $point['location'] : (isset($point['address']) ? $point['address'] : ($point[0] ?? ''));
        $speed = isset($point['speed']) ? $point['speed'] : ($point[5] ?? 0);
        
        if (empty($gps_time)) {
            continue;
        }
        
        $pointTime = strtotime($gps_time);
        
        if ($pointTime >= $startTimestamp && $pointTime <= $closeTimestamp) {
            $filteredData[] = [
                'vehicle_number' => $vehicle_number,
                'latitude' => floatval($lat),
                'longitude' => floatval($lon),
                'speed' => floatval($speed),
                'gps_time' => $gps_time,
                'location' => $location,
                'ignition' => 0
            ];
        }
    }
    
    usort($filteredData, function($a, $b) {
        return strtotime($a['gps_time']) - strtotime($b['gps_time']);
    });
    
    return $filteredData;
}

// Function to save Excel file - Simplified
function saveExcelFile($data, $filename, $folder_path = "all_data") {
    try {
        // Get the script directory
        $script_dir = __DIR__;
        
        // Build the full folder path
        $full_path = $script_dir . DIRECTORY_SEPARATOR . $folder_path;
        
        // Create folder if not exists
        if (!file_exists($full_path)) {
            if (!mkdir($full_path, 0777, true)) {
                // If cannot create, use current directory
                $full_path = $script_dir;
            }
        }
        
        // Check if folder is writable
        if (!is_writable($full_path)) {
            @chmod($full_path, 0777);
            if (!is_writable($full_path)) {
                // If still not writable, use system temp
                $full_path = sys_get_temp_dir();
            }
        }
        
        // Build the complete file path
        $file_path = $full_path . DIRECTORY_SEPARATOR . $filename . ".xls";
        
        // Build Excel content - Simplified without distance calculation
        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        $html .= '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
        $html .= '<table border="1">';
        
        // Trip details header
        $html .= '<tr style="background-color:#4CAF50; color:white; font-weight:bold;">';
        $html .= '<td colspan="11" style="font-size:16px; text-align:center;">TRIP DETAILS</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="background-color:#f2f2f2;">';
        $html .= '<td><b>Customer ID</b></td>';
        $html .= '<td><b>Customer Name</b></td>';
        $html .= '<td><b>Order No</b></td>';
        $html .= '<td><b>Order Main ID</b></td>';
        $html .= '<td><b>Order Date</b></td>';
        $html .= '<td><b>Invoice</b></td>';
        $html .= '<td><b>Item</b></td>';
        $html .= '<td><b>Quantity</b></td>';
        $html .= '<td><b>Vehicle</b></td>';
        $html .= '<td><b>Start Time</b></td>';
        $html .= '<td><b>Close Time</b></td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['customer_id'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['customer_name'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['order_no'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['order_main_id'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['order_date'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['invoice'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['item'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['quantity'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($data['trip_details']['vehicle'] ?? '') . '</td>';
        $html .= '<td>' . ($data['trip_details']['start_time'] ?? 'Not Found') . '</td>';
        $html .= '<td>' . ($data['trip_details']['close_time'] ?? 'Not Found') . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr><td colspan="11">&nbsp;</td></tr>';
        
        // Tracking data header
        $html .= '<tr style="background-color:#4CAF50; color:white; font-weight:bold;">';
        $html .= '<td colspan="11" style="font-size:16px; text-align:center;">VEHICLE TRACKING DATA</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="background-color:#f2f2f2;">';
        $html .= '<td><b>#</b></td>';
        $html .= '<td><b>Vehicle</b></td>';
        $html .= '<td><b>Latitude</b></td>';
        $html .= '<td><b>Longitude</b></td>';
        $html .= '<td><b>Speed (m/s)</b></td>';
        $html .= '<td><b>GPS Time</b></td>';
        $html .= '<td><b>Location</b></td>';
        $html .= '<td><b>Time Diff</b></td>';
        $html .= '<td><b>Elapsed Time</b></td>';
        $html .= '<td><b>Source</b></td>';
        $html .= '<td><b>Speed (km/h)</b></td>';
        $html .= '</tr>';
        
        if (!empty($data['tracking_data']) && is_array($data['tracking_data'])) {
            $counter = 1;
            $start_time = null;
            $last_time = null;
            
            foreach ($data['tracking_data'] as $point) {
                $time_diff = '';
                $elapsed = '';
                $current_time = strtotime($point['gps_time']);
                
                if ($start_time === null) {
                    $start_time = $current_time;
                    $last_time = $current_time;
                    $time_diff = 'Start';
                    $elapsed = '0:00:00';
                } else {
                    $diff = $current_time - $last_time;
                    $time_diff = gmdate('H:i:s', $diff);
                    $total_elapsed = $current_time - $start_time;
                    $elapsed = gmdate('H:i:s', $total_elapsed);
                    $last_time = $current_time;
                }
                
                $speed_kmh = isset($point['speed']) ? round($point['speed'] * 3.6, 2) : 0;
                
                $html .= '<tr>';
                $html .= '<td>' . $counter . '</td>';
                $html .= '<td>' . htmlspecialchars($point['vehicle_number'] ?? '') . '</td>';
                $html .= '<td>' . ($point['latitude'] ?? '') . '</td>';
                $html .= '<td>' . ($point['longitude'] ?? '') . '</td>';
                $html .= '<td>' . ($point['speed'] ?? '') . '</td>';
                $html .= '<td>' . htmlspecialchars($point['gps_time'] ?? '') . '</td>';
                $html .= '<td>' . htmlspecialchars($point['location'] ?? '') . '</td>';
                $html .= '<td>' . $time_diff . '</td>';
                $html .= '<td>' . $elapsed . '</td>';
                $html .= '<td>API</td>';
                $html .= '<td>' . $speed_kmh . '</td>';
                $html .= '</tr>';
                
                $counter++;
            }
        } else {
            $html .= '<tr><td colspan="11" align="center">No tracking data available</td></tr>';
        }
        
        // Add summary row
        if (!empty($data['tracking_data']) && is_array($data['tracking_data'])) {
            $last_point = end($data['tracking_data']);
            $first_point = reset($data['tracking_data']);
            
            $html .= '<tr><td colspan="11">&nbsp;</td></tr>';
            $html .= '<tr style="background-color:#e6f3ff; font-weight:bold;">';
            $html .= '<td colspan="11" style="text-align:center;">TRIP SUMMARY</td>';
            $html .= '</tr>';
            $html .= '<tr style="background-color:#e6f3ff;">';
            $html .= '<td colspan="3"><b>Start Time:</b> ' . ($first_point['gps_time'] ?? 'N/A') . '</td>';
            $html .= '<td colspan="3"><b>End Time:</b> ' . ($last_point['gps_time'] ?? 'N/A') . '</td>';
            $html .= '<td colspan="3"><b>Total Points:</b> ' . count($data['tracking_data']) . '</td>';
            
            if (!empty($first_point) && !empty($last_point)) {
                $start = new DateTime($first_point['gps_time']);
                $end = new DateTime($last_point['gps_time']);
                $interval = $start->diff($end);
                $duration = $interval->format('%H hours %I minutes %S seconds');
                $html .= '<td colspan="2"><b>Duration:</b> ' . $duration . '</td>';
            }
            $html .= '</tr>';
        }
        
        $html .= '</table></body></html>';
        
        // Write file
        $result = file_put_contents($file_path, $html);
        
        if ($result === false) {
            // Try alternative: save in current directory directly
            $alt_file = $filename . ".xls";
            $result = file_put_contents($alt_file, $html);
            if ($result !== false) {
                return ['success' => true, 'file_path' => realpath($alt_file), 'size' => $result];
            }
            return ['success' => false, 'error' => 'Failed to write file'];
        }
        
        return ['success' => true, 'file_path' => $file_path, 'size' => $result];
        
    } catch (Exception $e) {
        return ['success' => false, 'error' => 'Exception: ' . $e->getMessage()];
    }
}

// Main execution
ob_start();

// Check if we should process specific trip ID from URL parameter
$specific_trip = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Get all trips that need processing (status=2 and is_excel=0)
if ($specific_trip > 0) {
    $sql = "SELECT id,`customer_id`, `customer_name`, `order_no`, `order_main_id`, `order_date`, `invoice`, `item`, `quantity`, `dispatch_date`, `dispatch_time`, `vehicle`, `depot`, `status`, `total_amount`, `total_amount_with_tax`, `start_time`, `eta`, `close_time`, `distance`, `driver_name`, `driver_cnic`, `driver_contact`, `is_forced`, `is_divertion`, `is_tracker`, `is_shortage`, `is_excel`, `created_at` 
            FROM `dealers_sap_order_info` 
            WHERE id = $specific_trip AND status = 2 AND is_excel = 0 AND is_tracker = 1";
} else {
    $sql = "SELECT `hascol_primary_trips`.`id`,
    `hascol_primary_trips`.`ORDER`,
    `hascol_primary_trips`.`ORDER_TYPE`,
    `hascol_primary_trips`.`INVOICE`,
    `hascol_primary_trips`.`SHIPMENT`,
    `hascol_primary_trips`.`INVOICE_DATE`,
    `hascol_primary_trips`.`MONTH`,
    `hascol_primary_trips`.`ACTUAL_SHIP_DATE`,
    `hascol_primary_trips`.`SHIPMENT_DEPOT`,
    `hascol_primary_trips`.`SHIPMENT_DEPOT_[0]`,
    `hascol_primary_trips`.`DESTINATION`,
    `hascol_primary_trips`.`DESTINATION_[0]`,
    `hascol_primary_trips`.`QTY`,
    `hascol_primary_trips`.`ITEM_DESCRIPTION`,
    `hascol_primary_trips`.`CARRIER_ON_LOAD`,
    `hascol_primary_trips`.`CARRIER_ON_LOAD_[0]`,
    `hascol_primary_trips`.`REGISTRATION_LICENSE_NUMBER`,
    `hascol_primary_trips`.`is_excel`,
    `hascol_primary_trips`.`status`,
    `hascol_primary_trips`.`reason`
            FROM `hascol_primary_trips` 
            WHERE is_excel = 0
            ORDER BY id DESC";
}

$result = mysqli_query($db, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($db));
}

$total_trips = mysqli_num_rows($result);
$processed = 0;
$successful = 0;
$failed = 0;

$response_data = [];

echo "Starting processing for $total_trips trips...\n\n";

while($row = mysqli_fetch_assoc($result)) {
    $trip_id = $row['id'] ?? 0;
    $customer_id = $row['customer_id'] ?? '';
    $customer_name = $row['customer_name'] ?? '';
    $order_no = $row['order_no'] ?? '';
    $order_main_id = $row['order_main_id'] ?? '';
    $order_date = $row['order_date'] ?? '';
    $invoice = $row['invoice'] ?? '';
    $item = $row['item'] ?? '';
    $quantity = $row['quantity'] ?? '';
    $vehicle = $row['vehicle'] ?? '';
    $start_time = $row['start_time'] ?? '';
    $close_time = $row['close_time'] ?? '';
    $driver_name = $row['driver_name'] ?? '';
    $driver_contact = $row['driver_contact'] ?? '';
    
    $get_start_close_time = "SELECT start_time,close_time,is_tracker FROM hascolbridge.primary_movement_sales_orders where invoice_no='61501635' order by id desc;";
    $processed++;
    
    echo "========================================\n";
    echo "Processing Trip #$processed of $total_trips\n";
    echo "Trip ID: $trip_id\n";
    echo "Customer: $customer_name\n";
    echo "Vehicle: $vehicle\n";
    echo "Order No: $order_no\n";
    echo "Start Time: $start_time\n";
    echo "Close Time: $close_time\n";
    echo "========================================\n";
    
    $status = 'Failed';
    $excel_saved = false;
    $tracking_data = [];
    $excel_path = '';
    
    if (!empty($start_time) && !empty($close_time)) {
        echo "✓ Start time and close time found in database\n";
        
        $from_date_obj = new DateTime($start_time);
        $from_date_obj->modify('-7 days');
        $from_date = $from_date_obj->format('Y-m-d H:i:s');
        
        $to_date_obj = new DateTime($close_time);
        $to_date_obj->modify('+7 days');
        $to_date = $to_date_obj->format('Y-m-d H:i:s');
        
        echo "Fetching tracking data from: $from_date to $to_date\n";
        
        $trackingData = getTrackingData($vehicle, $from_date, $to_date);
        
        echo "API Response Status: " . ($trackingData['success'] ? 'Success' : 'Failed') . "\n";
        
        if (!$trackingData['success']) {
            echo "API Error: " . ($trackingData['error'] ?? 'Unknown error') . "\n";
        }
        
        if ($trackingData && isset($trackingData['success']) && $trackingData['success'] === true) {
            $full_tracking_data = $trackingData['data'];
            
            if (!empty($full_tracking_data) && count($full_tracking_data) > 0) {
                echo "Found " . count($full_tracking_data) . " tracking points\n";
                
                $tracking_data = filterTrackingDataByTime($full_tracking_data, $start_time, $close_time);
                
                echo "Filtered " . count($tracking_data) . " points between start and close time\n";
                
                if (!empty($tracking_data)) {
                    $status = 'Success';
                    $successful++;
                } else {
                    echo "✗ No tracking data found between start and close time\n";
                    $failed++;
                }
            } else {
                echo "✗ No tracking data available for this vehicle\n";
                $failed++;
            }
        } else {
            echo "✗ Failed to fetch tracking data\n";
            $failed++;
        }
    } else {
        echo "✗ Start time or close time not found in database\n";
        $failed++;
    }
    
    // Save Excel file if we have data
    if ($status == 'Success' && !empty($tracking_data)) {
        echo "\n--- SAVING EXCEL FILE ---\n";
        
        $excelData = [
            'trip_details' => [
                'customer_id' => $customer_id,
                'customer_name' => $customer_name,
                'order_no' => $order_no,
                'order_main_id' => $order_main_id,
                'order_date' => $order_date,
                'invoice' => $invoice,
                'item' => $item,
                'quantity' => $quantity,
                'vehicle' => $vehicle,
                'start_time' => $start_time,
                'close_time' => $close_time,
                'driver_name' => $driver_name,
                'driver_contact' => $driver_contact
            ],
            'tracking_data' => $tracking_data
        ];
        
        $filename = $order_no . "_" . str_replace('-', '_', $vehicle) . "_trip_" . $trip_id . "_" . date('Y-m-d_H-i-s');
        echo "Filename: $filename\n";
        
        $save_result = saveExcelFile($excelData, $filename, "all_data");
        
        if ($save_result['success']) {
            $excel_path = $save_result['file_path'];
            echo "✓✓✓ Excel saved successfully: $excel_path ✓✓✓\n";
            echo "File size: " . $save_result['size'] . " bytes\n";
            $excel_saved = true;
            
            // Update is_excel = 1 in database
            $update_excel_sql = "UPDATE dealers_sap_order_info SET is_excel = 1 WHERE id = $trip_id";
            if (mysqli_query($db, $update_excel_sql)) {
                echo "✓ is_excel set to 1\n";
            } else {
                echo "✗ Failed to update is_excel: " . mysqli_error($db) . "\n";
            }
        } else {
            echo "✗✗✗ Failed to save Excel: " . ($save_result['error'] ?? 'Unknown error') . " ✗✗✗\n";
        }
        echo "--- END EXCEL SAVING ---\n\n";
    } else {
        echo "✗ Skipping Excel generation due to no data\n";
    }
    
    $response_data[] = [
        'trip_id' => $trip_id,
        'customer_name' => $customer_name,
        'vehicle' => $vehicle,
        'order_no' => $order_no,
        'status' => $status,
        'start_time' => $start_time,
        'close_time' => $close_time,
        'excel_saved' => $excel_saved,
        'excel_path' => $excel_path,
        'points_count' => count($tracking_data)
    ];
    
    echo "Status: $status\n";
    echo "----------------------------------------\n\n";
}

echo "========================================\n";
echo "PROCESSING COMPLETE\n";
echo "Total Trips: $total_trips\n";
echo "Successful: $successful\n";
echo "Failed: $failed\n";
echo "========================================\n";

mysqli_close($db);

// Clear output buffer and return JSON response
ob_clean();
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'All trips processed',
    'summary' => [
        'total' => $total_trips,
        'successful' => $successful,
        'failed' => $failed
    ],
    'trips' => $response_data
], JSON_PRETTY_PRINT);
?>