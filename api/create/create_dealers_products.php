<?php
include("../../config.php");
// session_start();

header('Content-Type: application/json; charset=utf-8');

if (isset($_POST)) {
    $user_id   = $_POST['user_id'] ?? '';
    $dealer_id = mysqli_real_escape_string($db, $_POST["dealer_id"] ?? '');

    $products_name        = $_POST['products_name'] ?? '';
    $from_date            = $_POST['from_date'] ?? '';
    $to_date              = $_POST['to_date'] ?? '';
    $indent_price         = $_POST['indent_price'] ?? '';
    $nozel_price          = $_POST['nozel_price'] ?? '';
    $products_description = $_POST['products_description'] ?? '';

    $date   = date('Y-m-d H:i:s');
    $output = '';

    // ✅ FIX 1: row_id warning resolved
    $row_id = $_POST["row_id"] ?? '';

    if ($row_id != '') {
        // ============================
        // UPDATE LOGIC
        // ============================
        try {
            $query = "UPDATE `dealers_products`
            SET 
            `from` = '$from_date',
            `to` = '$to_date',
            `indent_price` = '$indent_price',
            `nozel_price` = '$nozel_price',
            `update_time` = '$date'
            WHERE `id` = $row_id;";

            if (mysqli_query($db, $query)) {
                $backlog = "INSERT INTO `dealer_nozel_price_log`
                (`dealer_id`, `product_id`, `indent_price`, `nozel_price`,
                 `from`, `to`, `description`, `created_at`, `created_by`)
                VALUES
                ('$dealer_id', '$row_id', '$indent_price', '$nozel_price',
                 '$from_date', '$to_date', '$products_description',
                 '$date', '$user_id');";

                if (mysqli_query($db, $backlog)) {
                    $output = 1;
                } else {
                    $output = 'Error' . mysqli_error($db) . '<br>' . $backlog;
                }
            } else {
                $output = 'Error' . mysqli_error($db) . '<br>' . $query;
            }
        } catch (mysqli_sql_exception $e) {
            // Handle duplicate or any other DB error
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $output = 'DUPLICATE';
            } else {
                $output = 'DB_ERROR';
            }
        }

    } else {
        // ============================
        // INSERT LOGIC
        // ============================

        // ✅ FIX 2: Check first if this product already exists
        $checkQuery = "SELECT id FROM dealers_products 
                       WHERE dealer_id = '$dealer_id' 
                       AND name = '$products_name' 
                       LIMIT 1";
        $checkResult = mysqli_query($db, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Product already exists — user-friendly message
            echo json_encode([
                'success' => false,
                'code'    => 'DUPLICATE_PRODUCT',
                'message' => 'This product (' . $products_name . ') already exists for this dealer. Please edit it or select a different product.'
            ]);
            exit;
        }

        // Now INSERT
        try {
            $query = "INSERT INTO `dealers_products`
            (`dealer_id`, `name`, `from`, `to`, `indent_price`, `nozel_price`,
             `created_at`, `update_time`, `created_by`)
            VALUES
            ('$dealer_id', '$products_name', '$from_date', '$to_date',
             '$indent_price', '$nozel_price', '$date', '$date', '$user_id');";

            if (mysqli_query($db, $query)) {
                $lastInsertedId = mysqli_insert_id($db);

                $backlog = "INSERT INTO `dealer_nozel_price_log`
                (`dealer_id`, `product_id`, `indent_price`, `nozel_price`,
                 `from`, `to`, `description`, `created_at`, `created_by`)
                VALUES
                ('$dealer_id', '$lastInsertedId', '$indent_price', '$nozel_price',
                 '$from_date', '$to_date', '$products_description',
                 '$date', '$user_id');";

                if (mysqli_query($db, $backlog)) {
                    echo json_encode([
                        'success' => true,
                        'code'    => 'CREATED',
                        'message' => 'Product created successfully',
                        'id'      => $lastInsertedId
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        'success' => false,
                        'code'    => 'LOG_ERROR',
                        'message' => 'Price log could not be inserted: ' . mysqli_error($db)
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'code'    => 'INSERT_ERROR',
                    'message' => 'Insert error: ' . mysqli_error($db)
                ]);
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            // Handle duplicate or any other DB error
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                echo json_encode([
                    'success' => false,
                    'code'    => 'DUPLICATE_PRODUCT',
                    'message' => 'This product (' . $products_name . ') already exists for this dealer. Please edit it or select a different product.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'code'    => 'DB_ERROR',
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            }
            exit;
        }
    }

    // Fallback (in case any path is missed)
    echo json_encode([
        'success' => false,
        'code'    => 'UNKNOWN',
        'message' => 'An unknown error occurred'
    ]);
}
?>