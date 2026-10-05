<?php
include("../config.php");
header('Content-Type: application/json');

$type = isset($_GET['type']) ? $_GET['type'] : '';
$user = isset($_GET['user']) ? $_GET['user'] : '';

if (empty($type) || empty($user)) {
    echo json_encode(["error" => "Missing type or user"]);
    exit;
}

// Get user info
$user_q = "SELECT id, name FROM users WHERE id = '" . mysqli_real_escape_string($db, $user) . "'";
$user_r = mysqli_query($db, $user_q);
if (!$user_r || mysqli_num_rows($user_r) == 0) {
    echo json_encode(["error" => "User not found"]);
    exit;
}
$user_data = mysqli_fetch_assoc($user_r);
$user_id = $user_data['id'];

// Device list
$device_ids = [];
$devices_q = "SELECT devices_id FROM users_devices_new WHERE users_id = '$user_id'";
$devices_r = mysqli_query($db, $devices_q);
while ($row = mysqli_fetch_assoc($devices_r)) {
    $device_ids[] = $row['devices_id'];
}
if (empty($device_ids)) {
    echo json_encode([]);
    exit;
}
$device_list = implode(",", array_map('intval', $device_ids));

// Geofence list
$geo_ids = [];
$geo_q = "SELECT geo_id FROM cartraige_fence WHERE user_id = '$user_id'";
$geo_r = mysqli_query($db, $geo_q);
while ($row = mysqli_fetch_assoc($geo_r)) {
    $geo_ids[] = $row['geo_id'];
}
$geo_list = !empty($geo_ids) ? implode(",", array_map('intval', $geo_ids)) : "0";

// Set up query
$data = [];
$query = '';

if ($type === 'inbound') {
    $query = "SELECT 
    dc.id AS vehicle_id,
    dc.organisation AS vehicle_org,
    dc.name AS vehicle_name,
    dc.location AS vehicle_loc,
    pp.id AS order_id,
    pp.order_no,
    pp.vehicles,
    pp.invoice_no,
    pp.invoice_date,
    pp.customer_id,
    pp.item,
    pp.rate AS product_rate,
    pp.quantity,
    pp.distance,
    pp.remain_distance,
    dc.name AS vehi_cap,
    pp.start_time,
    pc.name AS product_name,
    pp.eta,
    pp.*,
    DATE_ADD(NOW(), INTERVAL ((pp.remain_distance / 30) * 60 + 20) MINUTE) AS remain_time,
    CASE 
        WHEN pp.status = 0 THEN 'Pending'
        WHEN pp.status = 1 THEN 'Start'
        WHEN pp.status = 2 THEN 'Complete'
        ELSE 'Unknown' 
    END AS trip_status,
    CASE 
        WHEN pp.is_shortage = 0 THEN 'Shortage Not Submit'
        WHEN pp.is_shortage = 1 THEN 'Shortage Submitted'
        ELSE 'Unknown' 
    END AS shortage_status,
    IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker') AS tracker_status
FROM (
    SELECT *
    FROM (
        SELECT *,
               ROW_NUMBER() OVER (PARTITION BY vehicles ORDER BY eta DESC) AS rn
        FROM primary_movement_sales_orders
        WHERE status = 1
    ) AS ranked
    WHERE rn = 1
) AS pp
JOIN devicesnew AS dc ON dc.organisation = pp.vehicles
JOIN all_products AS pc ON pc.sap_no = pp.item
WHERE dc.is_on_trip = 1
  AND dc.id IN($device_list)
  AND TIMESTAMPDIFF(HOUR, dc.time, NOW()) < 24
ORDER BY pp.id DESC;
";

} else if ($type === 'outbound') {
    $query = "SELECT 
        dc.id AS vehicle_id,
        dc.organisation AS vehicle_org,
        dc.name AS vehicle_name,
        dc.location AS vehicle_loc,
        pp.id AS order_id,
        pp.order_no,
        pp.vehicles,
        pp.invoice_no,
        pp.invoice_date,
        pp.customer_id,
        pp.item,
        pp.rate AS product_rate,
        pp.quantity,
        pp.distance,
        pp.remain_distance,
        dc.name AS vehi_cap,
        pp.start_time,
        pc.name AS product_name,
        pp.eta,
        pp.*,
        DATE_ADD(NOW(), INTERVAL ((pp.remain_distance / 30) * 60 + 20) MINUTE) AS remain_time,
        CASE WHEN pp.status = 0 THEN 'Pending'
             WHEN pp.status = 1 THEN 'Start'
             WHEN pp.status = 2 THEN 'Complete'
             ELSE 'No Trip' END AS trip_status,
        CASE WHEN pp.is_shortage = 0 THEN 'Shortage Not Submit'
             WHEN pp.is_shortage = 1 THEN 'Shortage Submitted'
             ELSE 'N/A' END AS shortage_status,
        IF(dc.name IS NOT NULL, 'With-Tracker', 'Without-Tracker') AS tracker_status
        FROM devicesnew AS dc
        LEFT JOIN (
            SELECT * FROM (
                SELECT *,
                    ROW_NUMBER() OVER (PARTITION BY vehicles ORDER BY close_time DESC) AS rn
                FROM primary_movement_sales_orders
                WHERE status = 2
            ) AS ranked
            WHERE rn = 1
        ) AS pp ON dc.organisation = pp.vehicles
        LEFT JOIN all_products AS pc ON pc.sap_no = pp.item
        WHERE dc.id IN ($device_list)
          AND dc.is_on_trip = 0
          AND TIMESTAMPDIFF(HOUR, dc.time, NOW()) < 24
          AND dc.id NOT IN (
              SELECT DISTINCT gc.veh_id
              FROM geo_check AS gc
              JOIN geofenceing AS geo ON geo.id = gc.geo_id
              WHERE gc.log = 0 AND geo.geotype = 'depot'
          )
          AND dc.id NOT IN (
              SELECT DISTINCT gc.veh_id
              FROM geo_check AS gc
              JOIN geofenceing AS geo ON geo.id = gc.geo_id
              WHERE gc.log = 0 AND geo.geotype IN ('base','hpl_parking')
                AND geo.id IN ($geo_list)
          )
        ORDER BY pp.id DESC";

}  else if ($type === 'depot' || $type === 'hpl' || $type === 'base') {
    $query = "SELECT d.*, ranked.consignee_name, ranked.in_time,ranked.geotype
    FROM devicesnew d
    JOIN (
        SELECT *
        FROM (
            SELECT 
                gc.veh_id,
                geo.consignee_name,
                gc.in_time,
                geo.geotype,
                ROW_NUMBER() OVER (PARTITION BY gc.veh_id ORDER BY gc.in_time DESC) AS rn
            FROM geo_check gc
            JOIN geofenceing geo ON geo.id = gc.geo_id
            WHERE gc.log = 0 and geotype IN('base','hpl_parking','depot')
        ) AS sub
        WHERE rn = 1
    ) AS ranked ON d.id = ranked.veh_id
    WHERE d.id IN ($device_list)
      AND TIMESTAMPDIFF(HOUR, d.time, NOW()) < 24 and d.is_on_trip=0
    ORDER BY ranked.in_time DESC";

}  else if ($type === 'nr') {
    $query = "SELECT * FROM devicesnew 
              WHERE id IN ($device_list)
              AND TIMESTAMPDIFF(HOUR, time, NOW()) > 24";

} else if ($type === 'snc') {
    $query = "SELECT id AS device_id, name, plate_no, time, speed 
              FROM devicesnew 
              WHERE id IN ($device_list) AND is_on_trip = 2";

} else {
    echo json_encode(["error" => "Invalid type"]);
    exit;
}

// Execute and return result
$result = mysqli_query($db, $query);
if (!$result) {
    echo json_encode(["error" => mysqli_error($db)]);
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {

    if ($type === 'depot' && $row['geotype'] === 'depot') {
        $data[] = $row;
    
    } elseif ($type === 'hpl' && $row['geotype'] === 'hpl_parking') {
        $data[] = $row;
    
    } elseif ($type === 'base' && $row['geotype'] === 'base') {
        $data[] = $row;
    
    } else {
        // For other types (like inbound, outbound, nr, snc), push all rows
        if ($type !== 'depot' && $type !== 'hpl' && $type !== 'base') {
            $data[] = $row;
        }
    }
    

}

echo json_encode($data, JSON_PRETTY_PRINT);
?>