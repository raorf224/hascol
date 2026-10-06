<?php
// fetch.php  
include("../config.php");

$access_key = '2170';

$pass = isset($_GET["key"]) ? $_GET["key"] : '';

if ($pass == '') {
    die('Key is Required');
}

if ($pass !== $access_key) {
    die('Wrong Key...');
}

$dealer_id = isset($_GET["dealer_id"]) ? $_GET["dealer_id"] : '';

if ($dealer_id == '') {
    die('Dealer ID is Required');
}

// Initialize array
$data = [];
$month_series = 1;

// Get TM ID from dealer
$get_tm_id = "SELECT * FROM dealers WHERE id='$dealer_id' LIMIT 1";
$result = mysqli_query($db, $get_tm_id);
$row = mysqli_fetch_array($result);
$tm_id = $row['asm'];

// Check how many recons the TM has done today

$check_current_date_visit = "SELECT * 
    FROM dealer_stock_recon_new
    WHERE created_by='$tm_id'
    AND DATE(created_at) = CURDATE()
    GROUP BY task_id
    ORDER BY id DESC";

$result_check = mysqli_query($db, $check_current_date_visit);
$count_check = mysqli_num_rows($result_check);

// If already done 4 or more recons today
if ($count_check >= 4) {
    // Fetch all dispensers for structure but replace data text
    $sql = "SELECT id, name FROM dealers_dispenser WHERE dealer_id=$dealer_id;";
    $result = $db->query($sql);

    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];

        // Each dispenser will contain one placeholder nozzle showing restriction
        $nozels = [
            [
                "id" => "",
                "dealer_id" => $dealer_id,
                "name" => "You had already performed 4 recons",
                "products" => "You had already performed 4 recons",
                "tank_id" => "0",
                "dispenser_id" => $id,
                "last_reading" => "",
                "last_date" => date('Y-m-d H:i:s'),
                "totalizer" => "",
                "created_at" => "",
                "updated_at" => "",
                "created_by" => $tm_id,
                "product_name" => "You had already performed 4 recons",
                "dispenser_name" => "You had already performed 4 recons",
                "tank_name" => "You had already performed 4 recons",
                "new_reading" => ""
            ]
        ];

        $data[] = [
            "id" => $id,
            "name" => "You had already performed 4 recons",
            "nozels" => $nozels
        ];
    }

    echo json_encode($data);
    exit;
}

// If recon count < 4, return actual dispenser + nozzle data
$sql = "SELECT * FROM dealers_dispenser WHERE dealer_id=$dealer_id;";
$result = $db->query($sql);

while ($row = $result->fetch_assoc()) {
    $id = $row["id"];
    $name = $row["name"];
    $myArray = [];

    $get_orders = "SELECT dz.*, 
               ap.name AS product_name,
               ds.name AS dispenser_name,
               dl.lorry_no AS tank_name,
               (SELECT new_reading 
                FROM dealers_nozzel_readings 
                WHERE nozle_id=dz.id 
                ORDER BY id DESC 
                LIMIT 1) AS new_reading 
        FROM dealers_nozzel dz
        JOIN dealers_products dp ON dp.id=dz.products
        JOIN dealers_dispenser ds ON ds.id=dz.dispenser_id
        JOIN dealers_lorries dl ON dl.id=dz.tank_id
        JOIN all_products ap ON ap.name=dp.name
        WHERE dz.dispenser_id='$id' 
          AND dz.dealer_id='$dealer_id';
    ";

    $result_orders = $db->query($get_orders);
    while ($row_2 = $result_orders->fetch_assoc()) {
        $myArray[] = $row_2;
    }

    $data[] = [
        "id" => $id,
        "name" => $name,
        "nozels" => $myArray
    ];
}

// Output JSON
echo json_encode($data);
?>