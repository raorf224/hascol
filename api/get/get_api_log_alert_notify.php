<?php
// session_start();
include("../config.php");
if (isset($_GET)) {
    $id = $_GET['id'];
    if ($id != "") {
        $users_arr = array();
        $sql_query = "SELECT * FROM apis_log 
        where date(created_at)>=curdate() and result='error' and status=0  ";

        $result = $db->query($sql_query) or die("Error :" . mysqli_error($db));

        $users_arr = array();
        while ($user_data = $result->fetch_assoc()) {
            $users_arr[] = $user_data;
        }

        // create json output
        $output = json_encode($users_arr);
        $update_query = "UPDATE apis_log 
        SET status = '1' 
        WHERE status = '0'";

        mysqli_query($db, $update_query);



        echo json_encode($users_arr);

    } else {
        echo 'False';
    }
}
?>