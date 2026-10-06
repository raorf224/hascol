<?php
include("../../config.php");
session_start();

header('Content-Type: application/json');

if (isset($_POST)) {

    $user_id    = $_POST['user_id'];
    $name       = mysqli_real_escape_string($db, $_POST['name']);
    $email      = mysqli_real_escape_string($db, $_POST['email']);
    $password   = mysqli_real_escape_string($db, $_POST['confirm_password']);
    $password_enc = mysqli_real_escape_string($db, $_POST['confirm_password']);
    $encriped   = md5($password_enc);
    $number     = mysqli_real_escape_string($db, $_POST['number']);
    $role       = mysqli_real_escape_string($db, $_POST['role']);
    $sales_role = mysqli_real_escape_string($db, $_POST['sales_role']);

    // $depots = mysqli_real_escape_string($db, $_POST['depots']); // Future use
    $depots = '';

    if ($role == 'Order' || $role == 'Logistics' || $role == 'Forward_order' || $role == 'App_order' || $role == 'Back_orders' || $role == 'Reporting' || $role == 'Finance' || $role == 'tracker' || $role == 'Cartraige' || $role == 'Eng' || $role == 'Depot' || $role == 'Cartraige') {
        $sales_role = $role;
    }

    function sales_role($main_id, $db, $user_id)
    {
        $date = date('Y-m-d H:i:s');
        $sales_role = mysqli_real_escape_string($db, $_POST['sales_role']);

        if ($sales_role == 'TM') {
            $zm = mysqli_real_escape_string($db, $_POST['zm']);

            $query = "INSERT INTO `users_zm_tm`
            (`zm_id`,
            `tm_id`,
            `created_by`,
            `created_at`)
            VALUES
            ('$zm',
            '$main_id',
            '$date',
            '$user_id');";

            if (mysqli_query($db, $query)) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($sales_role == 'ASM') {
                $tm = mysqli_real_escape_string($db, $_POST['tm']);

                $query = "INSERT INTO `users_asm_tm`
                (`tm_id`,
                `asm_id`,
                `created_by`,
                `created_at`)
                VALUES
                ('$tm',
                '$main_id',
                '$date',
                '$user_id');";

                if (mysqli_query($db, $query)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    function logistics($main_id, $db, $user_id)
    {
        $role = mysqli_real_escape_string($db, $_POST['logistics_role']);
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO `users_logistics`
        (`role`,
        `logistics_id`,
        `created_by`,
        `created_at`)
        VALUES
        ('$role',
        '$main_id',
        '$date',
        '$user_id');";

        if (mysqli_query($db, $query)) {
            return true;
        } else {
            return false;
        }
    }

    if (isset($_POST['row_id']) && $_POST['row_id'] != '') {

        // Update working (future)

    } else {

        // ✅ Duplicate check — login (email) already exists?
        $check_dup = mysqli_query($db, "SELECT id FROM users WHERE login = '$email' LIMIT 1");
        if (mysqli_num_rows($check_dup) > 0) {
            echo json_encode([
                'status'  => 0,
                'message' => 'User already exists with this email/login'
            ]);
            exit;
        }

        $parent_id = '';
        $check = mysqli_real_escape_string($db, $_POST['sales_role']);

        if ($check == 'BSO') {
            $parent_id = mysqli_real_escape_string($db, $_POST['tm']);
        }

        $query = "INSERT INTO users (`name`,`privilege`,`login`, `password`,`usersettings_id`,`status`,`description`,`email`,`telephone`,`subacc_id`,`image`)
        VALUES ('$name', '$sales_role', '$email', '$encriped','1','1','$password','$email','$number','$parent_id','$depots')";

        if (mysqli_query($db, $query)) {
            $main_id = mysqli_insert_id($db);

            if ($role == 'Logistics') {
                logistics($main_id, $db, $user_id);
            } elseif ($role == 'Sales') {
                sales_role($main_id, $db, $user_id);
            }

            // Roles wali working (as-is)
            $success = false;

            if ($sales_role == 'ZM') {
                $success = true;
            } elseif ($sales_role == 'Order') {
                $success = true;
            } elseif ($sales_role == 'Forward_order') {
                $success = true;
            } elseif ($sales_role == 'App_order') {
                $success = true;
            } elseif ($sales_role == 'Back_orders') {
                $success = true;
            } elseif ($sales_role == 'BSO') {
                $success = true;
            } elseif ($sales_role == 'Reporting') {
                $success = true;
            } elseif ($sales_role == 'Finance') {
                $success = true;
            } elseif ($sales_role == 'tracker') {
                $success = true;
            } elseif ($sales_role == 'Cartraige') {
                $success = true;
            } elseif ($sales_role == 'Eng') {
                $success = true;
            } elseif ($sales_role == 'Depot') {
                $success = true;
            } elseif ($sales_role == 'Cartraige') {
                $success = true;
            } elseif ($sales_role == 'TM') {
                $success = true;
            } elseif ($sales_role == 'ASM') {
                $success = true;
            } else {
                // Koi bhi other role
                $success = true;
            }

            if ($success) {
                echo json_encode([
                    'status'  => 1,
                    'message' => 'User created successfully',
                    'id'      => $main_id
                ]);
            } else {
                echo json_encode([
                    'status'  => 0,
                    'message' => 'User not created'
                ]);
            }

        } else {
            echo json_encode([
                'status'  => 0,
                'message' => 'DB Error: ' . mysqli_error($db)
            ]);
        }
    }
}
?>