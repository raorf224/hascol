<?php
    session_start();
    include("../config.php");
    if(isset($_GET)){
        $vehicle = $_GET['vehicle'];
        $from = $_GET['from_date'];
        $to = $_GET['to_date'];
        if($vehicle!="" && $from!="" && $to!=""){
            $users_arr = array();
            $sql="SELECT address,latitude,longitude,vehicle_name,time,speed FROM positions_log where vehicle_name='$vehicle' and time >='$from' and time <='$to' order by time asc;";
            $result = mysqli_query($db,$sql);
            
            while( $row = mysqli_fetch_array($result) ){
                // $userid = $row['id'];
                
            
                $users_arr[] = $row;
                // $users_arr[] = array('name' =>$name,'lat' =>$lat,'lng' =>$lng,'speed' =>$speed,'time' =>$time);

            }
            // print_r($users_arr);

            // echo 'True '.$data;
            
                echo json_encode($users_arr);
                
        }else{
            echo 'False';
        }
    }
?>