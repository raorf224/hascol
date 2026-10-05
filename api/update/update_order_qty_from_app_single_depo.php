<?php
include ("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $date = date('Y-m-d H:i:s');

    // Fetch data from POST request
    $product_name = $_POST['product_name'];
    $product_qty = $_POST['product_qty'];
    $product_id = $_POST['product_id'];
    $product_old_qty = $_POST['product_old_qty'];
    $rate = $_POST['rate'];
    $main_id = $_POST['main_id']; 
    $order_id = $_POST['sub_id']; 
    $depot_name = $_POST['depot_name']; 
    $type = $_POST['type']; 
    $vehicle = $_POST['vehicle']; 

    $amount = $rate * $product_qty;
    $total_amount = $amount;

    $total_order_amount = $_POST['total_order_amount'];

    // Begin transaction
    mysqli_autocommit($db, FALSE);

    try {
        // Update order_detail
        $query_count = " UPDATE `order_detail`
            SET `quantity` = '$product_qty',
                `amount` = '$amount',
                `rate` = '$rate',
                `depot` = '$depot_name'
            WHERE `id` = '$order_id' AND `main_id` = '$main_id'
        ";
        if (!mysqli_query($db, $query_count)) {
            throw new Exception("Error updating order_detail: " . mysqli_error($db));
        }

        // Insert into order_qty_update_log
        $insert_log = "INSERT INTO `order_qty_update_log`
            (`order_main_id`, `order_sub_id`, `product_id`, `product_name`,
             `old_qty`, `new_qty`, `created_at`, `created_by`)
            VALUES
            ('$main_id', '$order_id', '$product_id', '$product_name',
             '$product_old_qty', '$product_qty', '$date', '$user_id')
        ";
        if (!mysqli_query($db, $insert_log)) {
            throw new Exception("Error inserting into order_qty_update_log: " . mysqli_error($db));
        }

        // Update order_main
        $main_update = "UPDATE `order_main`
            SET `total_amount` = '$total_order_amount',
            `depot` = '$depot_name',
            `type` = '$type',
            `tl_no` = '$vehicle'
            WHERE `id` = '$main_id'
        ";
        if (!mysqli_query($db, $main_update)) {
            throw new Exception("Error updating order_main: " . mysqli_error($db));
        }

        // Commit the transaction
        mysqli_commit($db);
        $output = 1;
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($db);
        $output = $e->getMessage();
    }

    mysqli_autocommit($db, TRUE);

    echo $output;
}
?>
