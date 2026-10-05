<?php  
include("../config.php");
header("Content-Type: application/json");

$access_key = '03201232927';
$pass = $_GET["key"] ?? '';

if ($pass == "") {
    echo json_encode(["error" => "Key is Required"]);
    exit;
}

if ($pass !== $access_key) {
    echo json_encode(["error" => "Wrong Key"]);
    exit;
}

$data = [];

/*----------------------------------------
    1. GET REGIONS
----------------------------------------*/
$sql = "SELECT DISTINCT(region) 
        FROM hascolbridge.geofenceing 
        WHERE geotype='depot' AND region!=''";

$result = $db->query($sql);

if (!$result) {
    echo json_encode(["error" => "Region Query Failed", "db_error" => $db->error]);
    exit;
}

while ($region_row = $result->fetch_assoc()) {

    $region_name = $region_row["region"];

    /*----------------------------------------
        2. GET VEHICLES OF THIS REGION
    ----------------------------------------*/
    $vehicles_sql = "
    SELECT distinct(dc.id), dc.organisation, dc.name, dc.location, dc.speed,us.name as cart_name
    FROM depot_vehicles dv
    JOIN devicesnew dc 
    join users_devices_new as ud on ud.devices_id=dc.id
    join users as us on us.id=ud.users_id
    ON dc.id = dv.vehicle_id  
        WHERE dv.region = '$region_name' and us.privilege='Cartraige'
    ";

    $vehicles_result = $db->query($vehicles_sql);

    if (!$vehicles_result) {
        echo json_encode([
            "error" => "Vehicle Query Failed",
            "region" => $region_name,
            "sql" => $vehicles_sql,
            "db_error" => $db->error
        ]);
        exit;
    }

    $vehicles_array = [];

    while ($v = $vehicles_result->fetch_assoc()) {

        $vehicle_no = $v["organisation"]; // vehicle number

        /*----------------------------------------
            3. GET ORDERS FOR THIS VEHICLE (TODAY)
        ----------------------------------------*/
        $orders_sql = "
            SELECT oi.*, pp.name AS product_name 
            FROM order_info oi
            JOIN all_products pp ON pp.sap_no = oi.item
            WHERE oi.vehicle = '$vehicle_no'
            AND oi.created_at >= DATE_SUB(CURDATE(), INTERVAL 3 DAY)
            AND oi.status = 1
            ORDER BY oi.id DESC
        ";

        $orders_result = $db->query($orders_sql);

        $orders = [];
        if ($orders_result) {
            while ($o = $orders_result->fetch_assoc()) {
                $orders[] = $o;  // multiple orders store correctly
            }
        }

        /*----------------------------------------
            Vehicle + Orders
        ----------------------------------------*/
        $vehicles_array[] = [
            "vehicle_id"   => $v["id"],
            "vehicle_no"   => $v["organisation"],
            "vehicle_name" => $v["name"],
            "location"     => $v["location"],
            "cart_name"     => $v["cart_name"],
            "speed"        => $v["speed"] . ' KM/Hr',
            "orders"       => $orders
        ];
    }

    if (count($vehicles_array) == 0) {
        continue;
    }

    $data[] = [
        "region"   => $region_name,
        "vehicles" => $vehicles_array
    ];
}

/*----------------------------------------
    FINAL JSON OUTPUT
----------------------------------------*/
echo json_encode($data, JSON_PRETTY_PRINT);
?>
