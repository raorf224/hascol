<?php
include("../config.php");
header('Content-Type: application/json');

$response = [];

$cartraige_users_query = "SELECT id, name FROM users WHERE privilege = 'Cartraige' and id=145";
$users_result = mysqli_query($db, $cartraige_users_query);

if (!$users_result) {
    echo json_encode(["error" => mysqli_error($db)]);
    exit;
}

while ($user = mysqli_fetch_assoc($users_result)) {
    $user_id = $user['id'];
    $user_name = $user['name'];

    // Fetch user devices
    $device_ids = [];
    $devices_q = "SELECT devices_id FROM users_devices_new WHERE users_id = '$user_id'";
    $devices_r = mysqli_query($db, $devices_q);
    while ($row = mysqli_fetch_assoc($devices_r)) {
        $device_ids[] = $row['devices_id'];
    }
    $device_list = !empty($device_ids) ? implode(",", array_map('intval', $device_ids)) : "0";

    // Fetch geofence IDs
    $geo_ids = [];
    $geo_q = "SELECT geo_id FROM cartraige_fence WHERE user_id = '$user_id'";
    $geo_r = mysqli_query($db, $geo_q);
    while ($row = mysqli_fetch_assoc($geo_r)) {
        $geo_ids[] = $row['geo_id'];
    }
    $geo_list = !empty($geo_ids) ? implode(",", array_map('intval', $geo_ids)) : "0";

    // Initialize counters
    $inbound = $outbound = $base = $depot = $hpl = $nr = 0;

    // ----------------------------------------
    // INBOUND TRIPS
    // ----------------------------------------
    $inbound_q = "SELECT COUNT(*) as cnt FROM (
        SELECT dc.id
        FROM (
            SELECT *, ROW_NUMBER() OVER (PARTITION BY vehicles ORDER BY eta DESC) AS rn
            FROM primary_movement_sales_orders
            WHERE status = 1
        ) AS ranked
        INNER JOIN devicesnew dc ON dc.organisation = ranked.vehicles
        WHERE ranked.rn = 1
          AND dc.is_on_trip = 1
          AND dc.id IN ($device_list)
          AND TIMESTAMPDIFF(HOUR, dc.time, NOW()) < 24
    ) AS inbound_data";
    $inbound_r = mysqli_query($db, $inbound_q);
    $inbound = mysqli_fetch_assoc($inbound_r)['cnt'] ?? 0;

    // ----------------------------------------
    // OUTBOUND TRIPS
    // ----------------------------------------
    $outbound_q = "SELECT COUNT(*) as cnt FROM (
        SELECT dc.id
        FROM devicesnew dc
        LEFT JOIN (
            SELECT *, ROW_NUMBER() OVER (PARTITION BY vehicles ORDER BY close_time DESC) AS rn
            FROM primary_movement_sales_orders
            WHERE status = 2
        ) AS ranked ON dc.organisation = ranked.vehicles AND ranked.rn = 1
        WHERE dc.id IN ($device_list)
          AND dc.is_on_trip = 0
          AND TIMESTAMPDIFF(HOUR, dc.time, NOW()) < 24
          AND dc.id NOT IN (
              SELECT gc.veh_id
              FROM geo_check gc
              JOIN geofenceing geo ON geo.id = gc.geo_id
              WHERE gc.log = 0 AND geo.geotype = 'depot'
          )
          AND dc.id NOT IN (
              SELECT gc.veh_id
              FROM geo_check gc
              JOIN geofenceing geo ON geo.id = gc.geo_id
              WHERE gc.log = 0 AND geo.geotype IN ('base','hpl_parking') AND geo.id IN ($geo_list)
          )
    ) AS outbound_data";
    $outbound_r = mysqli_query($db, $outbound_q);
    $outbound = mysqli_fetch_assoc($outbound_r)['cnt'] ?? 0;

    // ----------------------------------------
    // DEPOT / BASE / HPL
    // ----------------------------------------
    $depot_q = "SELECT d.organisation,d.time,d.trackername, ranked.consignee_name, ranked.in_time,ranked.geotype
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
    $depot_r = mysqli_query($db, $depot_q);
    while ($row = mysqli_fetch_assoc($depot_r)) {
        if ( $row['geotype'] === 'depot') {
            $depot++;
        
        } elseif ($row['geotype'] === 'hpl_parking') {
            $hpl++;
        
        } elseif ( $row['geotype'] === 'base') {
            $base++;
        
        }
    }

    // ----------------------------------------
    // NR (Not Reporting)
    // ----------------------------------------
    $nr_q = "SELECT COUNT(*) as cnt FROM devicesnew 
             WHERE id IN ($device_list)
             AND TIMESTAMPDIFF(HOUR, time, NOW()) > 24";
    $nr_r = mysqli_query($db, $nr_q);
    $nr = mysqli_fetch_assoc($nr_r)['cnt'] ?? 0;

    // ----------------------------------------
    // SNC (Special Case)
    // ----------------------------------------
    $snc_q = "SELECT out_trackers AS cnt FROM users WHERE id = '$user_id'";
    $snc = mysqli_fetch_assoc(mysqli_query($db, $snc_q))['cnt'] ?? 0;

    // Total
    $total = ($user_name === 'HPL Parking') ? 39 : count($device_ids);
    if ($user_name === 'HPL Parking') $hpl = 39;

    $response[] = [
        "user_id" => $user_id,
        "user" => $user_name,
        "inbound" => $inbound,
        "outbound" => $outbound,
        "base" => $base,
        "depot" => $depot,
        "hpl" => $hpl,
        "nr" => $nr,
        "snc" => $snc,
        "total" => $total
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
