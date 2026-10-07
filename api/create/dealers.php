<?php
// ============================================
// JSON Response Header
// ============================================
header('Content-Type: application/json');

// ============================================
// Config Include
// ============================================
include("../../config.php");
session_start();

$response = ['status' => 'error', 'message' => 'Unknown error'];

// ============================================
// DB Connection Check
// ============================================
if (!isset($db) || !$db) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if (isset($_POST)) {

    // ============================================
    // Safely Read All POST Values
    // ============================================
    $user_id          = isset($_POST['user_id']) ? $_POST['user_id'] : '1';
    $datetime         = date('Y-m-d H:i:s');
    $dealer_name      = isset($_POST["dealer_name"]) ? $_POST["dealer_name"] : '';
    $emails           = isset($_POST["emails"]) ? $_POST["emails"] : '';
    $call_no          = isset($_POST["call_no"]) ? $_POST["call_no"] : '';
    $location         = isset($_POST["location"]) ? $_POST["location"] : '';
    $lati             = isset($_POST["lati"]) ? $_POST["lati"] : '';
    $housekeeping     = isset($_POST["housekeeping"]) ? $_POST["housekeeping"] : '';
    $password         = isset($_POST["password"]) ? $_POST["password"] : '';
    $type             = isset($_POST["type"]) ? $_POST["type"] : 'Dealer';
    $dealer_sap_no    = isset($_POST['dealer_sap_no']) ? $_POST['dealer_sap_no'] : '';
    $account_balanced = isset($_POST["account_balanced"]) ? $_POST["account_balanced"] : '0';
    $carss            = isset($_POST['depots']) ? $_POST['depots'] : [];
    $district         = isset($_POST['district']) ? $_POST['district'] : '';
    $city             = isset($_POST['city']) ? $_POST['city'] : '';
    $province         = isset($_POST['province']) ? $_POST['province'] : '';
    $region           = isset($_POST['region']) ? $_POST['region'] : '';
    $poly             = isset($_POST['poly']) ? $_POST['poly'] : '';
    $zm               = isset($_POST['zm']) ? $_POST['zm'] : '';
    $tm               = isset($_POST['tm']) ? $_POST['tm'] : '';
    $asm              = isset($_POST['asm']) ? $_POST['asm'] : '';
    $row_id           = isset($_POST["row_id"]) ? $_POST["row_id"] : '';

    // ============================================
    // Escape All Values
    // ============================================
    $dealer_name      = mysqli_real_escape_string($db, $dealer_name);
    $emails           = mysqli_real_escape_string($db, $emails);
    $call_no          = mysqli_real_escape_string($db, $call_no);
    $location         = mysqli_real_escape_string($db, $location);
    $lati             = mysqli_real_escape_string($db, $lati);
    $housekeeping     = mysqli_real_escape_string($db, $housekeeping);
    $password         = mysqli_real_escape_string($db, $password);
    $dealer_sap_no    = mysqli_real_escape_string($db, $dealer_sap_no);
    $account_balanced = mysqli_real_escape_string($db, $account_balanced);
    $district         = mysqli_real_escape_string($db, $district);
    $city             = mysqli_real_escape_string($db, $city);
    $province         = mysqli_real_escape_string($db, $province);
    $region           = mysqli_real_escape_string($db, $region);
    $poly             = mysqli_real_escape_string($db, $poly);
    $zm               = mysqli_real_escape_string($db, $zm);
    $tm               = mysqli_real_escape_string($db, $tm);
    $asm              = mysqli_real_escape_string($db, $asm);
    $type             = mysqli_real_escape_string($db, $type);

    // ============================================
    // DUPLICATE CHECK — Same Name + SAP No + Contact
    // ============================================
    $checkQuery = "SELECT id FROM `dealers` 
                   WHERE `name` = '$dealer_name' 
                     AND `sap_no` = '$dealer_sap_no' 
                     AND `contact` = '$call_no' 
                   LIMIT 1";
    $checkResult = mysqli_query($db, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Record already exists
        $existingRow = mysqli_fetch_assoc($checkResult);
        echo json_encode([
            'status'  => 'duplicate',
            'message' => 'This dealer already exists (ID: ' . $existingRow['id'] . '). A new record cannot be created with the same Site Name, SAP No, and Contact. Please use a different SAP No or Contact.',
            'existing_id' => $existingRow['id']
        ]);
        exit;
    }

    // ============================================
    // SECONDARY CHECK — SAP No Only
    // ============================================
    $checkSapQuery = "SELECT id, name FROM `dealers` 
                      WHERE `sap_no` = '$dealer_sap_no' 
                      LIMIT 1";
    $checkSapResult = mysqli_query($db, $checkSapQuery);

    if ($checkSapResult && mysqli_num_rows($checkSapResult) > 0) {
        $existingSapRow = mysqli_fetch_assoc($checkSapResult);
        echo json_encode([
            'status'  => 'duplicate',
            'message' => 'This SAP No (' . $dealer_sap_no . ') is already registered with dealer "' . $existingSapRow['name'] . '" (ID: ' . $existingSapRow['id'] . '). Each dealer must have a unique SAP No.',
            'existing_id' => $existingSapRow['id']
        ]);
        exit;
    }

    // ============================================
    // TERTIARY CHECK — Contact Only
    // ============================================
    $checkContactQuery = "SELECT id, name FROM `dealers` 
                          WHERE `contact` = '$call_no' 
                          LIMIT 1";
    $checkContactResult = mysqli_query($db, $checkContactQuery);

    if ($checkContactResult && mysqli_num_rows($checkContactResult) > 0) {
        $existingContactRow = mysqli_fetch_assoc($checkContactResult);
        echo json_encode([
            'status'  => 'duplicate',
            'message' => 'This Contact No (' . $call_no . ') is already registered with dealer "' . $existingContactRow['name'] . '" (ID: ' . $existingContactRow['id'] . '). Each dealer must have a unique contact number.',
            'existing_id' => $existingContactRow['id']
        ]);
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
    // Banner Upload
    // ============================================
    $file = '';
    if (isset($_FILES['banner_img']) && !empty($_FILES['banner_img']['name'])) {
        $file = rand(1000, 100000) . "-" . basename($_FILES['banner_img']['name']);
        $file_loc = $_FILES['banner_img']['tmp_name'];
        if (!move_uploaded_file($file_loc, $folder . $file)) {
            $file = '';
        }
    }

    // ============================================
    // Logo Upload
    // ============================================
    $file1 = '';
    if (isset($_FILES['logo_img']) && !empty($_FILES['logo_img']['name'])) {
        $file1 = rand(1000, 100000) . "-" . basename($_FILES['logo_img']['name']);
        $file_loc1 = $_FILES['logo_img']['tmp_name'];
        if (!move_uploaded_file($file_loc1, $folder . $file1)) {
            $file1 = '';
        }
    }

    $tdate = date('Y-m-d H:i:s');

    // ============================================
    // Insert or Update
    // ============================================
    if ($row_id != '') {
        $response = ['status' => 'error', 'message' => 'Update not implemented yet'];
    } else {

        $query_main = "INSERT INTO `dealers`
            (`name`, `contact`, `email`, `password`, `location`, `co-ordinates`,
             `housekeeping`, `no_lorries`, `sap_no`, `type`, `zm`, `tm`, `asm`,
             `district`, `city`, `region`, `province`, `banner`, `logo`,
             `acount`, `form_status`, `created_at`, `created_by`)
            VALUES
            ('$dealer_name', '$call_no', '$emails', '$password', '$location', '$lati',
             '$housekeeping', '0', '$dealer_sap_no', '$type', '$zm', '$tm', '$asm',
             '$district', '$city', '$region', '$province', '$file', '$file1',
             '$account_balanced', '$poly', '$datetime', '$user_id')";

        try {
            $insertResult = mysqli_query($db, $query_main);

            if ($insertResult) {
                $active = mysqli_insert_id($db);

                // Depots insert
                if (!empty($carss) && is_array($carss)) {
                    $start_time = date("Y-m-d H:i:s");
                    foreach ($carss as $assign) {
                        $assign_safe = mysqli_real_escape_string($db, $assign);
                        $sql1 = "INSERT INTO `dealers_depots`
                            (`dealers_id`, `depot_id`, `created_at`, `created_by`)
                            VALUES ('$active', '$assign_safe', '$start_time', '$user_id')";
                        mysqli_query($db, $sql1);
                    }
                }

                $response = [
                    'status'  => 'success',
                    'message' => 'Dealer created successfully',
                    'id'      => $active
                ];
            } else {
                $response = [
                    'status'  => 'error',
                    'message' => 'DB Error: ' . mysqli_error($db)
                ];
            }
        } catch (mysqli_sql_exception $e) {
            // Duplicate entry error catch
            $errMsg = $e->getMessage();
            if (strpos($errMsg, 'Duplicate entry') !== false) {
                $response = [
                    'status'  => 'duplicate',
                    'message' => 'This record already exists. Please use a unique Site Name, SAP No, and Contact.'
                ];
            } else {
                $response = [
                    'status'  => 'error',
                    'message' => 'Database error: ' . $errMsg
                ];
            }
        }
    }

    echo json_encode($response);
    exit;
}
?>