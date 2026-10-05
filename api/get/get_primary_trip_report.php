<?php
// api/get_primary_trip_report.php
include("../config.php");

$access_key = '03201232927';
$pass = isset($_GET["key"]) ? $_GET["key"] : '';

if ($pass != '') {
    if ($pass == $access_key) {
        
        // By default current date
        $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
        $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
        $vehicle_no = isset($_GET['vehicle_no']) ? $_GET['vehicle_no'] : '';
        
        $where = "DATE(oi.created_at) >= '$from_date' AND DATE(oi.created_at) <= '$to_date' and oi.is_tracker=1";
        
        if (!empty($customer_id)) {
            $where .= " AND oi.customer_id = '$customer_id'";
        }
        if (!empty($vehicle_no)) {
            $where .= " AND oi.vehicles LIKE '%$vehicle_no%'";
        }
        
        $sql = "SELECT 
            oi.id,
            oi.order_no,
            oi.customer_id,
            oi.customer_name,
            oi.order_type,
            oi.invoice_no,
            oi.invoice_type,
            oi.item,
            oi.quantity,
            oi.unit_measure,
            oi.vehicles,
            oi.carrier_code,
            oi.carrier_desc,
            oi.start_time,
            oi.eta,
            oi.close_time,
            oi.distance,
            oi.remain_distance,
            oi.status,
            oi.is_site_out,
            oi.site_out_time,
            oi.created_at,
            dl.Coordinates AS co,
            dl.consignee_name AS depot_name,
            dc.id AS vehicle_id, 
            dc.name as vehicle_name,
            dc.location as current_location,
            dc.lat,
            dc.lng
        FROM 
            primary_movement_sales_orders AS oi 
        JOIN 
            geofenceing AS dl ON dl.code = oi.depot_code 
        LEFT JOIN 
            devicesnew AS dc ON TRIM(SUBSTRING_INDEX(dc.organisation, ' ', 1)) = oi.vehicles 
        WHERE 
            $where
            group by dc.name ORDER BY 
            oi.created_at DESC";
        
        $result = $db->query($sql);
        
        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($db)]);
            exit;
        }
        
        $trips = array();
        while ($row = $result->fetch_assoc()) {
            // Format Loading Date
            $loading_date = date('d-M-y', strtotime($row['created_at']));
            
            // Depot (customer name)
            $depot = trim($row['customer_name']);
            
            // Destination (depot_name from geofenceing)
            $destination = trim($row['depot_name']);
            
            // Departure Time
            $departure_time = $row['start_time'] ? date('H:i', strtotime($row['start_time'])) : '-';
            
            // Calculate ETA in hours
            $eta_hours = 0;
            if ($row['start_time'] && $row['start_time'] != '0000-00-00 00:00:00' && 
                $row['eta'] && $row['eta'] != '0000-00-00 00:00:00') {
                $start = new DateTime($row['start_time']);
                $eta_dt = new DateTime($row['eta']);
                $interval = $start->diff($eta_dt);
                $eta_hours = round($interval->h + ($interval->i / 60), 2);
            }
            
            // TL No.
            $tl_no = $row['vehicles'];
            
            // Live Tracking
            $live_tracking = $row['current_location'];
            
            // Distance from destination
            $distance_from_destination = round($row['remain_distance'], 2);
            
            // Total distance
            $total_distance = round($row['distance'], 2);
            
            // Site In Date & Time (close_time)
            $site_in_datetime = $row['close_time'] ? date('d-M-y H:i', strtotime($row['close_time'])) : '-';
            
            // Site Out Date & Time
            $site_out_datetime = $row['site_out_time'] ? date('d-M-y H:i', strtotime($row['site_out_time'])) : '-';
            
            // Total Decantation Time (fixed 45 minutes = 0.75 hours)
            $total_decantation_hours = 0.75;
            
            // Total Stay At Site
            $total_stay_hours = 0;
            if ($row['close_time'] && $row['close_time'] != '0000-00-00 00:00:00' && 
                $row['site_out_time'] && $row['site_out_time'] != '0000-00-00 00:00:00') {
                $close = new DateTime($row['close_time']);
                $site_out = new DateTime($row['site_out_time']);
                $interval = $close->diff($site_out);
                $total_stay_hours = round($interval->h + ($interval->i / 60), 2);
            } elseif ($row['close_time'] && $row['status'] == 2 && !$row['site_out_time']) {
                $close = new DateTime($row['close_time']);
                $now = new DateTime();
                $interval = $close->diff($now);
                $total_stay_hours = round($interval->h + ($interval->i / 60), 2);
            }
            
            // Total Delay at Site
            $total_delay_hours = 0;
            if ($row['eta'] && $row['eta'] != '0000-00-00 00:00:00' && 
                $row['close_time'] && $row['close_time'] != '0000-00-00 00:00:00') {
                $eta_dt = new DateTime($row['eta']);
                $close_dt = new DateTime($row['close_time']);
                if ($close_dt > $eta_dt) {
                    $interval = $eta_dt->diff($close_dt);
                    $total_delay_hours = round($interval->h + ($interval->i / 60), 2);
                }
            }
            
            // Delay Status
            if ($total_delay_hours > 1) {
                $delay_status = "DELAYED";
            } elseif ($total_delay_hours > 0.5) {
                $delay_status = "WARNING";
            } elseif ($row['status'] == 2 && $row['site_out_time']) {
                $delay_status = "COMPLETED";
            } elseif ($row['status'] == 2 && !$row['site_out_time']) {
                $delay_status = "AT SITE";
            } else {
                $delay_status = "IN TRANSIT";
            }
            
            $trips[] = array(
                'id' => $row['id'],
                'loading_date' => $loading_date,
                'depot' => $depot,
                'destination' => $destination,
                'departure_time' => $departure_time,
                'eta_hours' => $eta_hours,
                'tl_no' => $tl_no,
                'live_tracking' => $live_tracking,
                'distance_from_destination' => $distance_from_destination,
                'total_distance' => $total_distance,
                'site_in_datetime' => $site_in_datetime,
                'site_out_datetime' => $site_out_datetime,
                'total_decantation_hours' => $total_decantation_hours,
                'total_stay_hours' => $total_stay_hours,
                'total_delay_hours' => $total_delay_hours,
                'delay_status' => $delay_status,
                'status' => $row['status'],
                'is_site_out' => $row['is_site_out']
            );
        }
        
        // Calculate statistics
        $total_trips = count($trips);
        $completed_trips = count(array_filter($trips, function($t) { return $t['delay_status'] == 'COMPLETED'; }));
        $at_site_trips = count(array_filter($trips, function($t) { return $t['delay_status'] == 'AT SITE'; }));
        $delayed_trips = count(array_filter($trips, function($t) { return $t['delay_status'] == 'DELAYED'; }));
        
        echo json_encode([
            'status' => 'success',
            'data' => $trips,
            'statistics' => [
                'total_trips' => $total_trips,
                'completed_trips' => $completed_trips,
                'at_site_trips' => $at_site_trips,
                'delayed_trips' => $delayed_trips
            ],
            'filters' => [
                'from_date' => $from_date,
                'to_date' => $to_date,
                'customer_id' => $customer_id,
                'vehicle_no' => $vehicle_no
            ]
        ]);
        
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Wrong Key...']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Key is Required']);
}

$db->close();
?>