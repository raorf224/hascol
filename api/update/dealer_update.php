<?php
header('Content-Type: application/json');

include("../../config.php");
session_start();

$response = ['status' => 'error', 'message' => 'Unknown error'];

if (!isset($db) || !$db) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if (!empty($_POST)) {

    $logo = "";
    $banner = "";

    // ============================================
    // Safely Read All POST Values
    // ============================================
    $logo_img_hidden    = isset($_POST['logo_img_hidden']) ? mysqli_real_escape_string($db, $_POST['logo_img_hidden']) : '';
    $banner_img_hidden  = isset($_POST['banner_img_hidden']) ? mysqli_real_escape_string($db, $_POST['banner_img_hidden']) : '';
    $dealer_id          = isset($_POST['row_id']) ? mysqli_real_escape_string($db, $_POST['row_id']) : '';
    $user_id            = isset($_POST['user_id']) ? mysqli_real_escape_string($db, $_POST['user_id']) : '1';
    $dealer_name        = isset($_POST['dealer_name']) ? mysqli_real_escape_string($db, $_POST['dealer_name']) : '';
    $dealer_sap_no      = isset($_POST['dealer_sap_no']) ? mysqli_real_escape_string($db, $_POST['dealer_sap_no']) : '';
    $emails             = isset($_POST['emails']) ? mysqli_real_escape_string($db, $_POST['emails']) : '';
    $password           = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : '';
    $call_no            = isset($_POST['call_no']) ? mysqli_real_escape_string($db, $_POST['call_no']) : '';
    $location           = isset($_POST['location']) ? mysqli_real_escape_string($db, $_POST['location']) : '';
    $lati               = isset($_POST['lati']) ? mysqli_real_escape_string($db, $_POST['lati']) : '';
    $account_balanced   = isset($_POST['account_balanced']) ? mysqli_real_escape_string($db, $_POST['account_balanced']) : '0';
    $housekeeping       = isset($_POST['housekeeping']) ? mysqli_real_escape_string($db, $_POST['housekeeping']) : '';
    $zm                 = isset($_POST['zm']) ? mysqli_real_escape_string($db, $_POST['zm']) : '';
    $tm                 = isset($_POST['tm']) ? mysqli_real_escape_string($db, $_POST['tm']) : '';
    $asm                = isset($_POST['asm']) ? mysqli_real_escape_string($db, $_POST['asm']) : '';
    $district           = isset($_POST['district']) ? mysqli_real_escape_string($db, $_POST['district']) : '';
    $city               = isset($_POST['city']) ? mysqli_real_escape_string($db, $_POST['city']) : '';
    $province           = isset($_POST['province']) ? mysqli_real_escape_string($db, $_POST['province']) : '';
    $region             = isset($_POST['region']) ? mysqli_real_escape_string($db, $_POST['region']) : '';
    $poly               = isset($_POST['poly']) ? mysqli_real_escape_string($db, $_POST['poly']) : '';

    // ✅ Depots safely read karein
    $depots = isset($_POST['depots']) ? $_POST['depots'] : [];

    // ============================================
    // Validate Dealer ID
    // ============================================
    if (empty($dealer_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Dealer ID is required for update']);
        exit;
    }

    // ============================================
    // Upload Folder Check & Create
    // ============================================
    $folder = "../../hascolBridge_files/uploads/";
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    // ============================================
    // Handle Banner Image (Safely)
    // ============================================
    $banner = $banner_img_hidden; // Default: purani image rakhein

    if (isset($_FILES['banner_img']) && !empty($_FILES['banner_img']['name'])) {
        $banner = rand(1000, 100000) . "-" . basename($_FILES['banner_img']['name']);
        $file_loc = $_FILES['banner_img']['tmp_name'];
        if (!move_uploaded_file($file_loc, $folder . $banner)) {
            $banner = $banner_img_hidden; // Upload fail -> purani rakhein
        }
    }

    // ============================================
    // Handle Logo Image (Safely)
    // ============================================
    $logo = $logo_img_hidden; // Default: purani image rakhein

    if (isset($_FILES['logo_img']) && !empty($_FILES['logo_img']['name'])) {
        $logo = rand(1000, 100000) . "-" . basename($_FILES['logo_img']['name']);
        $file_loc1 = $_FILES['logo_img']['tmp_name'];
        if (!move_uploaded_file($file_loc1, $folder . $logo)) {
            $logo = $logo_img_hidden; // Upload fail -> purani rakhein
        }
    }

    // ============================================
    // Update Dealer Details
    // ============================================
    $query = "UPDATE `dealers` SET 
        `name` = '$dealer_name',
        `sap_no` = '$dealer_sap_no',
        `contact` = '$call_no',
        `email` = '$emails',
        `password` = '$password',
        `location` = '$location',
        `co-ordinates` = '$lati',
        `housekeeping` = '$housekeeping',
        `zm` = '$zm',
        `tm` = '$tm',
        `asm` = '$asm',
        `district` = '$district',
        `city` = '$city',
        `region` = '$region',
        `province` = '$province',
        `banner` = '$banner',
        `logo` = '$logo',
        `acount` = '$account_balanced',
        `form_status` = '$poly'
        WHERE `id` = '$dealer_id'";

    $start_time = date("Y-m-d H:i:s");

    try {
        if (mysqli_query($db, $query)) {

            // ============================================
            // Handle Depots (Delete + Re-insert)
            // ============================================
            if (!empty($depots) && is_array($depots)) {

                $delete_depot = "DELETE FROM `dealers_depots` WHERE dealers_id='$dealer_id'";
                mysqli_query($db, $delete_depot);

                foreach ($depots as $assign) {
                    $assign_safe = mysqli_real_escape_string($db, $assign);
                    $sql1 = "INSERT INTO `dealers_depots`
                        (`dealers_id`, `depot_id`, `created_at`, `created_by`)
                        VALUES
                        ('$dealer_id', '$assign_safe', '$start_time', '$user_id')";
                    mysqli_query($db, $sql1);
                }
            }

            $response = [
                'status'  => 'success',
                'message' => 'Dealer updated successfully',
                'id'      => $dealer_id
            ];

        } else {
            $response = [
                'status'  => 'error',
                'message' => 'DB Error: ' . mysqli_error($db)
            ];
        }
    } catch (mysqli_sql_exception $e) {
        $errMsg = $e->getMessage();
        if (strpos($errMsg, 'Duplicate entry') !== false) {
            $response = [
                'status'  => 'duplicate',
                'message' => 'This record conflicts with an existing dealer. Please use a unique Site Name, SAP No, and Contact.'
            ];
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Database error: ' . $errMsg
            ];
        }
    }

    echo json_encode($response);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'No data received']);
exit;
?>