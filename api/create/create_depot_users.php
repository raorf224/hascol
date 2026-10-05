<?php 
include("../config.php");
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ["success" => false, "message" => "Unknown error"];

    // Safely fetch and escape values
    $user_id    = isset($_POST['user_id']) && !is_array($_POST['user_id']) ? mysqli_real_escape_string($db, $_POST['user_id']) : '';
    $name       = isset($_POST['name']) && !is_array($_POST['name']) ? mysqli_real_escape_string($db, $_POST['name']) : '';
    $email      = isset($_POST['email']) && !is_array($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : '';
    $password   = isset($_POST['confirm_password']) && !is_array($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $number     = isset($_POST['number']) && !is_array($_POST['number']) ? mysqli_real_escape_string($db, $_POST['number']) : '';
    $role       = isset($_POST['role']) && !is_array($_POST['role']) ? mysqli_real_escape_string($db, $_POST['role']) : '';
    $sales_role = isset($_POST['sales_role']) && !is_array($_POST['sales_role']) ? mysqli_real_escape_string($db, $_POST['sales_role']) : '';
    $depots     = isset($_POST['depots']) && !is_array($_POST['depots']) ? mysqli_real_escape_string($db, $_POST['depots']) : '';
    $row_id     = isset($_POST['row_id']) && !is_array($_POST['row_id']) ? mysqli_real_escape_string($db, $_POST['row_id']) : '';
    $emails_array = isset($_POST['emails']) && is_array($_POST['emails']) ? $_POST['emails'] : [];

    // If Depot, force sales_role
    if ($role === 'Depot') {
        $sales_role = $role;
    }

    $password_hash = $password !== '' ? password_hash($password, PASSWORD_DEFAULT) : '';

    if (empty($row_id)) {
        // CREATE
        $parent_id = '';

        $insert_user_query = "
            INSERT INTO users (
                name, privilege, login, password, usersettings_id, status,
                description, email, telephone, subacc_id, image
            ) VALUES (
                '$name', '$sales_role', '$email', '$password_hash', '1', '1',
                '$password', '$email', '$number', '$parent_id', '$depots'
            )
        ";

        if (mysqli_query($db, $insert_user_query)) {
            $main_id = mysqli_insert_id($db);

            // If depot, insert additional emails
            if ($sales_role === 'Depot' && !empty($emails_array)) {
                foreach ($emails_array as $email_entry) {
                    if (!is_array($email_entry)) {
                        $safe_email = mysqli_real_escape_string($db, $email_entry);
                        $insert_email_query = "
                            INSERT INTO depot_users_emails (main_id, user_email, created_by)
                            VALUES ('$main_id', '$safe_email', '$user_id')
                        ";
                        if (!mysqli_query($db, $insert_email_query)) {
                            echo json_encode(["success" => false, "message" => "Email insert failed: " . mysqli_error($db)]);
                            exit;
                        }
                    }
                }
            }

            echo json_encode(["success" => true, "message" => "User created successfully"]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "User insert failed: " . mysqli_error($db)]);
            exit;
        }

    } else {
        // UPDATE
        $update_parts = "
            name = '$name',
            login = '$email',
            email = '$email',
            telephone = '$number',
            description = '$password',
            image = '$depots'
        ";

        if (!empty($password_hash)) {
            $update_parts .= ", password = '$password_hash'";
        }

        $update_query = "UPDATE users SET $update_parts WHERE id = '$row_id'";

        if (mysqli_query($db, $update_query)) {
            // Clear old emails
            mysqli_query($db, "DELETE FROM depot_users_emails WHERE main_id = '$row_id'");

            // Re-insert emails
            if ($sales_role === 'Depot' && !empty($emails_array)) {
                foreach ($emails_array as $email_entry) {
                    if (!is_array($email_entry)) {
                        $safe_email = mysqli_real_escape_string($db, $email_entry);
                        $insert_email_query = "
                            INSERT INTO depot_users_emails (main_id, user_email, created_by)
                            VALUES ('$row_id', '$safe_email', '$user_id')
                        ";
                        if (!mysqli_query($db, $insert_email_query)) {
                            echo json_encode(["success" => false, "message" => "Depot email insert failed: " . mysqli_error($db)]);
                            exit;
                        }
                    }
                }
            }

            echo json_encode(["success" => true, "message" => "User updated successfully"]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "User update failed: " . mysqli_error($db)]);
            exit;
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}
?>
