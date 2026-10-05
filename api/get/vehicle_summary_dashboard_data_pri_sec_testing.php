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
$todate=date("Y-m-d H:i:s", time());
$prev_date=date("Y-m-d H:i:s", strtotime($todate .' -1 day'));
// Set up query
$data = [];
$query = '';
if ($type === 'all_users') {
    $now = date("Y-m-d H:i:s");

    // Get all unique user_ids from cartraige_fence
    $user_ids_q = "SELECT * FROM users where privilege='cartraige';";
    $user_ids_r = mysqli_query($db, $user_ids_q);

    while ($user_row = mysqli_fetch_assoc($user_ids_r)) {
        $uid = $user_row['id'];
        $uname = $user_row['name'];

        // Get device IDs for this user
        $devices_q = "SELECT devices_id FROM users_devices_new WHERE users_id = '$uid'";
        $devices_r = mysqli_query($db, $devices_q);

        $device_ids = [];
        while ($row = mysqli_fetch_assoc($devices_r)) {
            $device_ids[] = $row['devices_id'];
        }

        if (empty($device_ids)) continue;

        $device_list = implode(",", array_map('intval', $device_ids));

        // Fetch devices
        $device_q = "SELECT * FROM devicesnew WHERE id IN ($device_list)";
        $device_r = mysqli_query($db, $device_q);

        while ($device = mysqli_fetch_assoc($device_r)) {
            $status = 'unknown';
            $consignee_name = '---';
            $trip_status = '---';
            $from_location = '---';
            $to_location = '---';

            if ($device['is_on_trip'] == 2) {
                $status = 'SNC';
            } elseif ((strtotime($now) - strtotime($device['time'])) > 86400) {
                $status = 'NR';
            } elseif ($device['is_on_trip'] == 1) {
                $status = 'Out-Bound';
                if ($device['trip_type'] == 'Primary') {
                    $trip_status = 'Primary Trip';
                    $trip_q = "SELECT customer_name, depot_name FROM primary_movement_sales_orders WHERE vehicles = '{$device['organisation']}' AND status = 1 ORDER BY id DESC LIMIT 1";
                    $trip_r = mysqli_query($db, $trip_q);
                    if ($trip_r && mysqli_num_rows($trip_r) > 0) {
                        $trip_data = mysqli_fetch_assoc($trip_r);
                        $from_location = $trip_data['customer_name'];
                        $to_location = $trip_data['depot_name'];
                    }
                } elseif ($device['trip_type'] == 'Secondary') {
                    $trip_status = 'Secondary Trip';
                    $trip_q = "SELECT carrier_desc, customer_name FROM order_info WHERE vehicle = '{$device['organisation']}' AND status = 1 ORDER BY id DESC LIMIT 1";
                    $trip_r = mysqli_query($db, $trip_q);
                    if ($trip_r && mysqli_num_rows($trip_r) > 0) {
                        $trip_data = mysqli_fetch_assoc($trip_r);
                        $from_location = $trip_data['carrier_desc'];
                        $to_location = $trip_data['customer_name'];
                    }
                }
            } elseif ($device['is_on_trip'] == 0) {
                $geo_q = "
                    SELECT geo.geotype, geo.consignee_name
                    FROM geo_check gc
                    JOIN geofenceing geo ON geo.id = gc.geo_id
                    WHERE gc.veh_id = {$device['id']} 
                      AND gc.log = 0
                      AND geo.geotype IN ('depot', 'base', 'hpl_parking')
                    ORDER BY gc.in_time DESC
                    LIMIT 1
                ";
                $geo_r = mysqli_query($db, $geo_q);
                if ($geo_r && mysqli_num_rows($geo_r) > 0) {
                    $geo = mysqli_fetch_assoc($geo_r);
                    $status = $geo['geotype'] === 'hpl_parking' ? 'hpl' : $geo['geotype'];
                    $consignee_name = $geo['consignee_name'];
                } else {
                    $status = 'In-Bound';
            $trip_status = '---';
            $from_location = '---';
            $to_location = '---';
                    // Check for a completed secondary trip
                    // $secondary_trip_q = "SELECT carrier_desc, customer_name FROM order_info WHERE vehicle = '{$device['organisation']}' AND status = 2 ORDER BY id DESC LIMIT 1";
                    // $secondary_trip_r = mysqli_query($db, $secondary_trip_q);
                    // if ($secondary_trip_r && mysqli_num_rows($secondary_trip_r) > 0) {
                    //     $secondary_trip_data = mysqli_fetch_assoc($secondary_trip_r);
                    //     $trip_status = 'Secondary Trip';
                    //     $from_location = $secondary_trip_data['carrier_desc'];
                    //     $to_location = $secondary_trip_data['customer_name'];
                    // } else {
                    //     // Check for a completed primary trip
                    //     $primary_trip_q = "SELECT customer_name, depot_name FROM primary_movement_sales_orders WHERE vehicles = '{$device['organisation']}' AND status = 2 ORDER BY id DESC LIMIT 1";
                    //     $primary_trip_r = mysqli_query($db, $primary_trip_q);
                    //     if ($primary_trip_r && mysqli_num_rows($primary_trip_r) > 0) {
                    //         $primary_trip_data = mysqli_fetch_assoc($primary_trip_r);
                    //         $trip_status = 'Primary Trip (Completed)';
                    //         $from_location = $primary_trip_data['customer_name'];
                    //         $to_location = $primary_trip_data['depot_name'];
                    //     } else {
                    //         $trip_status = 'No Trip';
                    //     }
                    // }
                }
            }

            $data[] = [
                'device_id' => $device['id'],
                'organisation' => $device['organisation'],
                'time' => $device['time'],
                'location' => $device['location'],
                'lat' => $device['lat'],
                'lng' => $device['lng'],
                'speed' => $device['speed'],
                'status' => $status,
                'consignee_name' => $consignee_name,
                'trip_status' => $trip_status,
                'from' => $from_location,
                'to' => $to_location,
                'user_id' => $uid,
                'cart_name' => $uname
            ];
        }
    }
}else {
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
    

if ($type === 'inbound') {
    $query = "SELECT 
             dc.id AS vehicle_id,
             dc.organisation AS vehicle_org,
             dc.name AS vehicle_name,
             dc.speed AS speed,
             dc.lat AS lat,
             dc.lng AS lng,
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
             pp.customer_name AS from_location, 
             pp.depot_name AS to_location,
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
         WHERE dc.is_on_trip = 1 and dc.trip_type='Primary'
         AND dc.id IN($device_list)
         AND TIMESTAMPDIFF(HOUR, dc.time, NOW()) < 24
         ORDER BY pp.id DESC;
         ";

} else if ($type === 'inbound_s') {
    $query = "SELECT 
             dc.id AS vehicle_id,
             dc.organisation AS vehicle_org,
             dc.name AS vehicle_name,
             dc.speed AS speed,
             dc.lat AS lat,
             dc.lng AS lng,
             dc.location AS vehicle_loc,
             pp.id AS order_id,
             pp.order_no,
             pp.vehicle,
             pp.invoice as invoice_no,
             pp.order_date as invoice_date,
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
             pp.carrier_desc AS from_location, 
             pp.customer_name AS to_location,
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
             SELECT *,
                 ROW_NUMBER() OVER (PARTITION BY vehicle ORDER BY eta DESC) AS rn
             FROM order_info
             WHERE status = 1
         ) AS pp
         JOIN devicesnew AS dc ON dc.organisation = pp.vehicle
         JOIN all_products AS pc ON pc.sap_no = pp.item
         WHERE dc.is_on_trip = 1 and dc.trip_type='Secondary'
         AND dc.id IN($device_list)
         AND TIMESTAMPDIFF(HOUR, dc.time, NOW()) < 24
         ORDER BY pp.id DESC;
         ";

}else if ($type === 'outbound') {
    $query = "SELECT 
          dc.id AS vehicle_id,
          dc.organisation AS vehicle_org,
          dc.name AS vehicle_name,
          dc.speed AS speed,
             dc.lat AS lat,
             dc.lng AS lng,
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
          pp.customer_name AS from_location,
          pp.depot_name AS to_location,
          CASE WHEN pp.status = 0 THEN 'Pending'
               WHEN pp.status = 1 THEN 'Start'
               WHEN pp.status = 2 THEN 'Complete'
               ELSE 'No Trip' END AS trip_status,
          CASE WHEN pp.is_shortage = 0 THEN 'Shortage Not Submit'
               WHEN pp.is_shortage = 1 THEN 'Shortage Submitted'
               ELSE '---' END AS shortage_status,
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

} else if ($type === 'depot' || $type === 'hpl' || $type === 'base') {
    $query = "SELECT d.*, ranked.consignee_name, ranked.in_time,ranked.geotype, '---' AS from_location, '---' AS to_location
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

} else if ($type === 'nr') {
    $query = "SELECT *, '---' AS from_location, '---' AS to_location FROM devicesnew 
              WHERE id IN ($device_list)
              AND time <='$prev_date'";

} else if ($type === 'snc') {
    $query = "SELECT id AS device_id, name, plate_no, time, speed, '---' AS from_location, '---' AS to_location
              FROM devicesnew 
              WHERE id IN ($device_list) AND is_on_trip = 2";

} else if ($type === 'all') {
    $now = date("Y-m-d H:i:s");

    $device_q = "SELECT * FROM devicesnew WHERE id IN ($device_list)";
    $device_r = mysqli_query($db, $device_q);
    
    while ($device = mysqli_fetch_assoc($device_r)) {
        $status = 'unknown';
        $consignee_name = '---';
        $trip_status = '---';
        $from_location = '---';
        $to_location = '---';

        // Check tracker fault
        if ($device['is_on_trip'] == 2) {
            $status = 'SNC';

        // Not reporting > 24hr
        } elseif ((strtotime($now) - strtotime($device['time'])) > 86400) {
            $status = 'NR';

        // On active trip
        } elseif ($device['is_on_trip'] == 1) {
            $status = 'Out-Bound';
            if ($device['trip_type'] == 'Primary') {
                $trip_status = 'Primary Trip';
                 $trip_q = "SELECT customer_name, depot_name FROM primary_movement_sales_orders WHERE vehicles = '{$device['organisation']}' AND status = 1 ORDER BY id DESC LIMIT 1";
                 $trip_r = mysqli_query($db, $trip_q);
                 if ($trip_r && mysqli_num_rows($trip_r) > 0) {
                     $trip_data = mysqli_fetch_assoc($trip_r);
                     $from_location = $trip_data['customer_name'];
                     $to_location = $trip_data['depot_name'];
                 }
            } elseif ($device['trip_type'] == 'Secondary') {
                $trip_status = 'Secondary Trip';
                 $trip_q = "SELECT carrier_desc, customer_name FROM order_sales_invoice WHERE vehicle = '{$device['organisation']}' AND status = 1 ORDER BY id DESC LIMIT 1";
                 $trip_r = mysqli_query($db, $trip_q);
                 if ($trip_r && mysqli_num_rows($trip_r) > 0) {
                     $trip_data = mysqli_fetch_assoc($trip_r);
                     $from_location = $trip_data['carrier_desc'];
                     $to_location = $trip_data['customer_name'];
                 }
            }

        // Not on trip, check geofence
        } elseif ($device['is_on_trip'] == 0) {
            $geo_q = "
                SELECT geo.geotype,geo.consignee_name
                FROM geo_check gc
                JOIN geofenceing geo ON geo.id = gc.geo_id
                WHERE gc.veh_id = {$device['id']} 
                  AND gc.log = 0
                  AND geo.geotype IN ('depot', 'base', 'hpl_parking')
                ORDER BY gc.in_time DESC
                LIMIT 1
            ";
            $geo_r = mysqli_query($db, $geo_q);
            if ($geo_r && mysqli_num_rows($geo_r) > 0) {
                $geo = mysqli_fetch_assoc($geo_r);
                $status = $geo['geotype'] === 'hpl_parking' ? 'hpl' : $geo['geotype'];
                $consignee_name = $geo['consignee_name'];
            } else {
                $status = 'In-Bound';
                $trip_status = '---';
                $from_location = '---';
                $to_location = '---';
            }
        }

        $data[] = [
            'device_id' => $device['id'],
            'organisation' => $device['organisation'],
            'time' => $device['time'],
            'location' => $device['location'],
            'lat' => $device['lat'],
            'lng' => $device['lng'],
            'speed' => $device['speed'],
            'status' => $status,
            'from' => $from_location,
            'to' => $to_location,
            'consignee_name' => $consignee_name,
            'trip_status' => $trip_status,
        ];
    }

} else if ($type === 'all_users') {
        $now = date("Y-m-d H:i:s");

        // Get all unique user_ids from cartraige_fence
        $user_ids_q = "SELECT * FROM users where privilege='cartraige';";
        $user_ids_r = mysqli_query($db, $user_ids_q);

        while ($user_row = mysqli_fetch_assoc($user_ids_r)) {
            $uid = $user_row['id'];
            $uname = $user_row['name'];

            // Get device IDs for this user
            $devices_q = "SELECT devices_id FROM users_devices_new WHERE users_id = '$uid'";
            $devices_r = mysqli_query($db, $devices_q);

            $device_ids = [];
            while ($row = mysqli_fetch_assoc($devices_r)) {
                $device_ids[] = $row['devices_id'];
            }

            if (empty($device_ids)) continue;

            $device_list = implode(",", array_map('intval', $device_ids));

            // Fetch devices
            $device_q = "SELECT * FROM devicesnew WHERE id IN ($device_list)";
            $device_r = mysqli_query($db, $device_q);

            while ($device = mysqli_fetch_assoc($device_r)) {
                $status = 'unknown';
                $consignee_name = '---';
                $trip_status = '---';
                $from_location = '---';
                $to_location = '---';

                if ($device['is_on_trip'] == 2) {
                    $status = 'SNC';
                } elseif ((strtotime($now) - strtotime($device['time'])) > 86400) {
                    $status = 'NR';
                } elseif ($device['is_on_trip'] == 1) {
                    $status = 'Out-Bound';
                    if ($device['trip_type'] == 'Primary') {
                        $trip_status = 'Primary Trip';
                        $trip_q = "SELECT customer_name, depot_name FROM primary_movement_sales_orders WHERE vehicles = '{$device['organisation']}' AND status = 1 ORDER BY id DESC LIMIT 1";
                        $trip_r = mysqli_query($db, $trip_q);
                        if ($trip_r && mysqli_num_rows($trip_r) > 0) {
                            $trip_data = mysqli_fetch_assoc($trip_r);
                            $from_location = $trip_data['customer_name'];
                            $to_location = $trip_data['depot_name'];
                        }
                    } elseif ($device['trip_type'] == 'Secondary') {
                        $trip_status = 'Secondary Trip';
                        $trip_q = "SELECT carrier_desc, customer_name FROM order_sales_invoice WHERE vehicle = '{$device['organisation']}' AND status = 1 ORDER BY id DESC LIMIT 1";
                        $trip_r = mysqli_query($db, $trip_q);
                        if ($trip_r && mysqli_num_rows($trip_r) > 0) {
                            $trip_data = mysqli_fetch_assoc($trip_r);
                            $from_location = $trip_data['carrier_desc'];
                            $to_location = $trip_data['customer_name'];
                        }
                    }
                } elseif ($device['is_on_trip'] == 0) {
                    $geo_q = "
                        SELECT geo.geotype,geo.consignee_name
                        FROM geo_check gc
                        JOIN geofenceing geo ON geo.id = gc.geo_id
                        WHERE gc.veh_id = {$device['id']} 
                          AND gc.log = 0
                          AND geo.geotype IN ('depot', 'base', 'hpl_parking')
                        ORDER BY gc.in_time DESC
                        LIMIT 1
                    ";
                    $geo_r = mysqli_query($db, $geo_q);
                    if ($geo_r && mysqli_num_rows($geo_r) > 0) {
                        $geo = mysqli_fetch_assoc($geo_r);
                        $status = $geo['geotype'] === 'hpl_parking' ? 'hpl' : $geo['geotype'];
                        $consignee_name = $geo['consignee_name'];
                    } else {
                        $status = 'In-Bound';
                        // Check for a completed secondary trip
                        $secondary_trip_q = "SELECT carrier_desc, customer_name FROM order_sales_invoice WHERE vehicle = '{$device['organisation']}' AND status = 2 ORDER BY id DESC LIMIT 1";
                        $secondary_trip_r = mysqli_query($db, $secondary_trip_q);
                        if ($secondary_trip_r && mysqli_num_rows($secondary_trip_r) > 0) {
                            $secondary_trip_data = mysqli_fetch_assoc($secondary_trip_r);
                            $trip_status = 'Secondary Trip (Completed)';
                            $from_location = $secondary_trip_data['carrier_desc'];
                            $to_location = $secondary_trip_data['customer_name'];
                        } else {
                            // Check for a completed primary trip
                            $primary_trip_q = "SELECT customer_name, depot_name FROM primary_movement_sales_orders WHERE vehicles = '{$device['organisation']}' AND status = 2 ORDER BY id DESC LIMIT 1";
                            $primary_trip_r = mysqli_query($db, $primary_trip_q);
                            if ($primary_trip_r && mysqli_num_rows($primary_trip_r) > 0) {
                                $primary_trip_data = mysqli_fetch_assoc($primary_trip_r);
                                $trip_status = 'Primary Trip (Completed)';
                                $from_location = $primary_trip_data['customer_name'];
                                $to_location = $primary_trip_data['depot_name'];
                            } else {
                                $trip_status = 'No Trip';
                            }
                        }
                    }
                }

                $data[] = [
                    'device_id' => $device['id'],
                    'organisation' => $device['organisation'],
                    'time' => $device['time'],
                    'location' => $device['location'],
                    'lat' => $device['lat'],
                    'lng' => $device['lng'],
                    'speed' => $device['speed'],
                    'status' => $status,
                    'consignee_name' => $consignee_name,
                    'trip_status' => $trip_status,
                    'from' => $from_location,
                    'to' => $to_location,
                    'user_id' => $uid,
                    'cart_name' => $uname

                ];
            }
        }
    }else {
        echo json_encode(["error" => "Invalid type"]);
        exit;
    }
}

// Execute and return result (only for query types)
if (!empty($query)) {
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
            if ($type !== 'depot' && $type !== 'hpl' && $type !== 'base') {
                $data[] = $row;
            }
        }
    }
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>