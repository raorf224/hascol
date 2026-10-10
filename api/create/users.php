<?php
include("../../config.php");
session_start();

header('Content-Type: application/json');

if (isset($_POST)) {

    $user_id      = $_POST['user_id'] ?? '';
    $name         = mysqli_real_escape_string($db, $_POST['name'] ?? '');
    $email        = mysqli_real_escape_string($db, $_POST['email'] ?? '');
    $password     = mysqli_real_escape_string($db, $_POST['confirm_password'] ?? '');
    $password_enc = mysqli_real_escape_string($db, $_POST['confirm_password'] ?? '');
    $encriped     = md5($password_enc);
    $number       = mysqli_real_escape_string($db, $_POST['number'] ?? '');
    $role         = mysqli_real_escape_string($db, $_POST['role'] ?? '');
    $sales_role   = mysqli_real_escape_string($db, $_POST['sales_role'] ?? '');
    $depots       = '';

    if (in_array($role, ['Order','Logistics','Forward_order','App_order','Back_orders','Reporting','Finance','tracker','Cartraige','Eng','Depot'])) {
        $sales_role = $role;
    }

    // ✅ UPDATE CASE (future)
    if (isset($_POST['row_id']) && $_POST['row_id'] != '') {
        echo json_encode(['success' => false, 'message' => 'Update not implemented yet']);
        exit;
    }

    // ✅ Duplicate check — login (email) se
    $check_dup = mysqli_query($db, "SELECT id FROM users WHERE login = '$email' LIMIT 1");
    if (mysqli_num_rows($check_dup) > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'User already exists with this email/login'
        ]);
        exit;
    }

    // ✅ NAYA USER — users table mein INSERT
    // password column = hashed ($encriped)
    // description column = plain ($password) — login verify ke liye
    $query = "INSERT INTO users 
        (`name`, `privilege`, `login`, `password`, `userSettings_id`, `status`, `description`, `email`, `telephone`, `subacc_id`)
        VALUES 
        ('$name', '$sales_role', '$email', '$encriped', '1', '1', '$password', '$email', '$number', '$user_id')";

    if (mysqli_query($db, $query)) {
        $main_id = mysqli_insert_id($db);

        echo json_encode([
            'success' => true,
            'message' => 'User created successfully',
            'id'      => $main_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'DB Error: ' . mysqli_error($db)
        ]);
    }
}
?>