<?php
include("../config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name    = mysqli_real_escape_string($db, $_POST["name"]);
    $co      = mysqli_real_escape_string($db, $_POST["co"]);
    $date    = date('Y-m-d H:i:s');

    if (!empty($_POST["row_id"])) {
        // yahan update ka code aayega agar zarurat ho
        $output = ["status" => "error", "message" => "Update feature not implemented yet."];
    } else {
     

        // if ($row) {
            $zm_id  = '2';
            $tm_id  = '0';
            $asm_id = '0';

            // Insert into dealers table
            $query = "INSERT INTO `dealers`
                (`name`, `privilege`, `co-ordinates`, `zm`, `tm`, `asm`, `created_at`, `created_by`)
                VALUES
                ('$name', 'Stops', '$co', '$zm_id', '$tm_id', '$asm_id', '$date', '$user_id')";

            if (mysqli_query($db, $query)) {
                $last_id = mysqli_insert_id($db);

                // Insert into dealers_stages table with default values (0)
                $stages_query = "INSERT INTO `dealers_stages`
                    (`dealer_id`, 
                     `scouting_lead_generation`, 
                     `suspect`, 
                     `qualification`, 
                     `prospect`, 
                     `negotiation`, 
                     `management_approval`, 
                     `loi_mou_a2l_lease`, 
                     `dc_noc`, 
                     `form_k`, 
                     `commissioned`, 
                     `created_at`, 
                     `updated_at`, 
                     `created_by`)
                    VALUES
                    ('$last_id', 
                     0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                     '$date', 
                     '$date', 
                     '$user_id')";

                if (mysqli_query($db, $stages_query)) {
                    // naya dealer ka data fetch karo
                    $dealer_sql = "SELECT * FROM dealers WHERE id = '$last_id'";
                    $dealer_res = mysqli_query($db, $dealer_sql);
                    $dealer_row = mysqli_fetch_assoc($dealer_res);

                    // Fetch stages data as well
                    $stages_sql = "SELECT * FROM dealers_stages WHERE dealer_id = '$last_id'";
                    $stages_res = mysqli_query($db, $stages_sql);
                    $stages_row = mysqli_fetch_assoc($stages_res);

                    $output = [
                        "status" => "success",
                        "message" => "Dealer created successfully",
                        "dealer" => $dealer_row,
                        "stages" => $stages_row
                    ];
                } else {
                    // If stages insertion fails, still return success but with warning
                    $dealer_sql = "SELECT * FROM dealers WHERE id = '$last_id'";
                    $dealer_res = mysqli_query($db, $dealer_sql);
                    $dealer_row = mysqli_fetch_assoc($dealer_res);

                    $output = [
                        "status" => "success",
                        "message" => "Dealer created but stages entry failed",
                        "dealer" => $dealer_row,
                        "stages_error" => mysqli_error($db)
                    ];
                }
            } else {
                $output = [
                    "status" => "error",
                    "message" => mysqli_error($db)
                ];
            }
        // } else {
        //     $output = [
        //         "status" => "error",
        //         "message" => "User mapping not found!"
        //     ];
        // }
    }

    echo json_encode($output);
}
?>