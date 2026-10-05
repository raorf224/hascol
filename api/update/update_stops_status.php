<?php
include("../config.php");
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['row_id'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Dealer ID required"
        ]);
        exit;
    }

    if (!isset($_POST['status'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Status required"
        ]);
        exit;
    }


    $row_id = intval($_POST['row_id']);

    // status number (0,1,2,3)
    $status = intval($_POST['status']);

    // status text
    $status_value = isset($_POST['status_value']) 
                    ? trim($_POST['status_value']) 
                    : "";

    $comment = isset($_POST['comment']) 
                    ? trim($_POST['comment']) 
                    : "";

    $times = date('Y-m-d H:i:s');


    /*
       Existing data get karein
       taake purana comment maintain rahe
    */

    $old_query = mysqli_query(
        $db,
        "SELECT last_baldate, rettype_desc, rettype 
         FROM dealers 
         WHERE id='$row_id'"
    );


    if(mysqli_num_rows($old_query) == 0){

        echo json_encode([
            "status"=>"error",
            "message"=>"Dealer not found"
        ]);
        exit;
    }


    $old = mysqli_fetch_assoc($old_query);


    // Existing values maintain
    $last_baldate = $old['last_baldate'];
    $rettype_desc = $old['rettype_desc'];
    $rettype      = $old['rettype'];



    /*
       Sirf current status ka comment update hoga
       purana data safe rahega
    */

    switch($status){

        case 1:
            // On Hold
            $last_baldate = $comment;
            break;


        case 2:
            // Rejected
            $rettype_desc = $comment;
            break;


        case 3:
            // Lose Competition
            $rettype = $comment;
            break;

    }



    $query="
    UPDATE dealers SET

        status=?,
        status_value=?,
        status_time=?,

        last_baldate=?,
        rettype_desc=?,
        rettype=?

    WHERE id=?
    ";


    $stmt=mysqli_prepare($db,$query);


    mysqli_stmt_bind_param(
        $stmt,
        "isssssi",
        $status,
        $status_value,
        $times,
        $last_baldate,
        $rettype_desc,
        $rettype,
        $row_id
    );


    if(mysqli_stmt_execute($stmt)){


        echo json_encode([

            "status"=>"success",

            "message"=>"Dealer status updated",

            "data"=>[

                "id"=>$row_id,

                "status"=>$status,

                "status_value"=>$status_value,

                "comment"=>$comment,

                "time"=>$times

            ]

        ]);


    }else{


        echo json_encode([

            "status"=>"error",

            "message"=>mysqli_stmt_error($stmt)

        ]);

    }


    mysqli_stmt_close($stmt);



}else{


    http_response_code(405);


    echo json_encode([

        "status"=>"error",

        "message"=>"Only POST allowed"

    ]);

}


mysqli_close($db);

?>