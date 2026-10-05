<?php
//fetch.php  
include("../../config.php");

$access_key = '03201232927';
$pass = $_GET["key"];
ini_set('max_execution_time', 0);
ini_set('max_input_time', 0);
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');     // Allow 100MB file upload

if (!empty($pass)) {
    if ($pass == $access_key) {
        // $dealer_id = intval($_GET["dealer_id"]);
        // $tm_id = intval($_GET["tm_id"]);
        $region = $_GET["region"];
        $tm = $_GET["tm"] ?? '';

        $from = $db->real_escape_string($_GET["from"]);
        $to = $db->real_escape_string($_GET["to"]);
        $products = $db->real_escape_string($_GET["products"]);
        $product_val = "";
        if ($products != "") {
            $product_val = "AND pp.id='$products'";
        } else {
            $product_val = "";
        }

        // Initialize an array to store the data
        // and tr.recon_approval='1' and tr.approved_status='1';


        $formatted_data = [];
        $recon_dater = "SELECT GROUP_CONCAT(DISTINCT(rr.task_id)) AS task_ids 
        FROM dealer_stock_recon_new as rr
        join inspector_task as it on it.id=rr.task_id
        left join inspector_task_response as tr on tr.task_id=it.id
        JOIN users as us on us.id = it.user_id
        WHERE date(rr.created_at) >= '$from' 
        AND date(rr.created_at) <= '$to'
        AND us.region='$region' and us.id IN($tm)";

        $result_recon_dater = mysqli_query($db, $recon_dater);

        if ($result_recon_dater) {
            $row_recon_dater = mysqli_fetch_assoc($result_recon_dater);
            $task_ids = $row_recon_dater['task_ids'];

            if (!empty($task_ids)) {
                // Query to fetch records
                $sql = "SELECT it.*, dl.name as dealer_name, dl.region, us.name as tm_name,dl.sap_no as dealer_sap
                FROM inspector_task as it
                JOIN dealers as dl on dl.id = it.dealer_id
                JOIN users as us on us.id = it.user_id
                WHERE us.region='$region'
                AND it.stock_recon=1
                and us.id IN($tm)
                AND it.id IN($task_ids) order by it.id desc;";

                $result = $db->query($sql);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $dealer_sap = $row["dealer_sap"];

                        $name = $row["dealer_name"];
                        $terr = '';
                        $region = $row["region"];
                        $tm_name = $row["tm_name"];

                        $get_orders = "SELECT rs.*, pp.name as product_name
                        FROM dealer_stock_recon_new as rs
                        join dealers_products as dp on dp.id=rs.product_id
                        JOIN all_products as pp ON pp.name = dp.name
                        join inspector_task as it on it.id=rs.task_id
                        left join inspector_task_response as tr on tr.task_id=it.id
                        JOIN users as us on us.id = it.user_id
                        WHERE rs.task_id = $id and us.region='$region' and us.id IN($tm) $product_val
                        GROUP BY rs.product_id, rs.task_id";

                        $result_orders = $db->query($get_orders);

                        if ($result_orders) {
                            while ($row_2 = $result_orders->fetch_assoc()) {
                                // Prepare the record data
                                $tank_beharior = false;
                                $external_dumping = false;
                                $external_upliftment = false;
                                $variance = floatval($row_2['variance']);
                                $book_value = floatval($row_2['book_value']);
                                $physical_stock = floatval($row_2['sum_of_closing']);
                                
                                $variance = (is_nan($variance) || is_infinite($variance)) ? 0 : $variance;
                                $book_value = (is_nan($book_value) || is_infinite($book_value)) ? 0 : $book_value;
                                $physical_stock = (is_nan($physical_stock) || is_infinite($physical_stock)) ? 0 : $physical_stock;
                                
                                $task_id = $row_2['task_id'];
                                $total_days = $row_2['total_days'];
                                $created_at = $row_2['created_at'];
                                
                                $product_name = $row_2['product_name'];
                                $last_recon_date = $row_2['last_recon_date'];
                                $average_daily_sales = floatval($row_2['average_daily_sales']);
                                $sum_of_opening = floatval($row_2['sum_of_opening']);
                                $sum_of_closing = floatval($row_2['sum_of_closing']);
                                $total_recipt = floatval($row_2['total_recipt']);
                                $total_sales = floatval($row_2['total_sales']);
                                $variance_of_sales = floatval($row_2['variance_of_sales']);
                                
                                $average_daily_sales = (is_nan($average_daily_sales) || is_infinite($average_daily_sales)) ? 0 : $average_daily_sales;
                                $sum_of_opening = (is_nan($sum_of_opening) || is_infinite($sum_of_opening)) ? 0 : $sum_of_opening;
                                $sum_of_closing = (is_nan($sum_of_closing) || is_infinite($sum_of_closing)) ? 0 : $sum_of_closing;
                                $total_recipt = (is_nan($total_recipt) || is_infinite($total_recipt)) ? 0 : $total_recipt;
                                $total_sales = (is_nan($total_sales) || is_infinite($total_sales)) ? 0 : $total_sales;
                                $variance_of_sales = (is_nan($variance_of_sales) || is_infinite($variance_of_sales)) ? 0 : $variance_of_sales;
                                
                                $remark = $row_2['remark'];
                                


                                if ($variance < 1000 && $variance > -1000) {
                                    // echo "Variance is less than 1000 and greater than -1000.";
                                    $tank_beharior = true;
                                } else {

                                    $tank_beharior = false;


                                    if ($book_value > $physical_stock) {
                                        // echo "Variance is less than 1000 and greater than -1000.";
                                        $external_dumping = true;
                                    } else {

                                        $external_dumping = false;
                                    }

                                    if ($physical_stock > $book_value) {
                                        // echo "Variance is less than 1000 and greater than -1000.";
                                        $external_upliftment = true;
                                    } else {

                                        $external_upliftment = false;
                                    }
                                }



                                $record_data = [
                                    'task_id' => $task_id,
                                    'total_days' => $total_days,
                                    'created_at' => $created_at,
                                    'site' => $name,
                                    'dealer_sap' => $dealer_sap,
                                    'tm' => $tm_name,
                                    'territory' => $terr,
                                    'region' => $region,
                                    'product_name' => $product_name,
                                    'opening_date' => date('Y-m-d', strtotime($last_recon_date)),
                                    'closing_date' => date('Y-m-d', strtotime($created_at)),
                                    'no_os_days' => $total_days,
                                    'daily_sales' => $average_daily_sales,
                                    'opening_stock' => $sum_of_opening,
                                    'physical_stock' => $sum_of_closing,
                                    'receipts' => $total_recipt,
                                    'sales' => $total_sales,
                                    'book_stock' => $book_value,
                                    'variance' => $variance,
                                    'variance_percentage' => round($variance_of_sales, 2),
                                    'remark' => $remark,
                                    'tank_beharior' => $tank_beharior,
                                    'external_dumping' => $external_dumping,
                                    'external_upliftment' => $external_upliftment



                                ];

                                // Append the record data to the formatted_data array
                                $formatted_data[] = $record_data;
                            }
                        } else {
                            echo "Error fetching stock recon data: " . $db->error;
                        }
                    }

                    // Convert the array to a JSON string
                    // $jsonData = json_encode($formatted_data);
                    header('Content-Type: application/json');

                    $formatted_data = utf8ize($formatted_data);
                    $json = json_encode($formatted_data, JSON_PRETTY_PRINT);

                    if ($json === false) {
                        echo json_encode(["error" => "JSON encoding failed", "details" => json_last_error_msg()]);
                    } else {
                        echo $json;
                    }



                    // Set the response header to indicate JSON content

                    // Output the JSON string
                    // echo $jsonData;

                } else {
                    echo "Error fetching inspector task data: " . $db->error;
                }
            } else {
                echo "No tasks found for the specified dealer and date range.";
            }
        } else {
            echo "Error executing the task ID query.";
        }
    } else {
        echo 'Wrong Key...';
    }
} else {
    echo 'Key is Required';
}

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