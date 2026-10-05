<?php
//fetch.php  
include("../config.php");

$access_key = '03201232927';

$pass = isset($_GET["key"]) ? $_GET["key"] : '';

if ($pass != '') {
    if ($pass == $access_key) {
        $sql_query1 = "SELECT distinct(PLANT_CODE),PLANT_NAME FROM pitb_depot;";

        $result1 = $db->query($sql_query1) or die("Error :" . mysqli_error());

        $data = array();
        
        while ($user = $result1->fetch_assoc()) {
            // Clean all fields by trimming spaces
            foreach ($user as $key => $value) {
                if (is_string($value)) {
                    $user[$key] = trim($value);
                }
            }
            
            $plant_code = isset($user['PLANT_CODE']) ? $user['PLANT_CODE'] : 'WH001';
            $whs_name = isset($user['PLANT_NAME']) ? $user['PLANT_NAME'] : 'Warehouse ' . $plant_code;
            
            // Use plant_code directly to create unique seed
            // Convert plant code to a number for seeding
            $seed = 0;
            for ($i = 0; $i < strlen($plant_code); $i++) {
                $seed += ord($plant_code[$i]) * ($i + 1);
            }
            // Add the counter to ensure uniqueness
            $seed = abs($seed + rand(1, 99999));
            
            // Generate unique values using the seed
            mt_srand($seed);
            
            $cities = ['Lahore', 'Karachi', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan', 'Peshawar', 'Quetta'];
            $districts = ['Lahore', 'Karachi Central', 'Rawalpindi', 'Faisalabad', 'Multan', 'Peshawar', 'Quetta', 'Islamabad'];
            $provinces = ['Punjab', 'Sindh', 'KPK', 'Balochistan', 'Islamabad'];
            $depo_types = ['Standalone', 'Integrated', 'Primary', 'Secondary'];
            $addresses = [
                'Main Road, Near PSO Depot',
                'Industrial Area, Sector 12',
                'G.T Road, Opposite OMC Office',
                'National Highway, Near Motorway',
                'Commercial Zone, City Center',
                'Defence Housing Authority',
                'Gulberg Area, Main Boulevard'
            ];
            
            // Generate unique values using mt_rand
            $city_index = mt_rand(0, count($cities) - 1);
            $district_index = mt_rand(0, count($districts) - 1);
            $province_index = mt_rand(0, count($provinces) - 1);
            $depo_index = mt_rand(0, count($depo_types) - 1);
            $type_index = mt_rand(0, count($depo_types) - 1);
            $address_index = mt_rand(0, count($addresses) - 1);
            
            // Generate unique tank capacity
            $tank_capacity = mt_rand(50000, 600000);
            
            // Generate unique stock
            $db_stock = isset($user['AVAIL_QTY']) ? $user['AVAIL_QTY'] : null;
            $stock_value = $db_stock !== null ? $db_stock : mt_rand(0, $tank_capacity);
            
            // Generate unique license number using plant_code and random
            $license_num = mt_rand(100, 999);
            $license_no = 'OGRA-9-(3)/(112)2016-' . $license_num;
            
            // Generate unique license expiry
            $exp_years = mt_rand(1, 5);
            $license_exp = date('Y-m-d H:i:s.000', strtotime('+' . $exp_years . ' years'));
            
            // Generate unique coordinates
            $latitude = number_format(24.8607 + (mt_rand(0, 1000) / 1000), 6, '.', '');
            $longitude = number_format(67.0011 + (mt_rand(0, 1000) / 1000), 6, '.', '');
            
            $formatted_data = array(
                "WhsCode" => $plant_code,
                "WhsName" => $whs_name,
                "U_Address" => $whs_name . ', ' . $addresses[$address_index],
                "U_City" => $cities[$city_index],
                "U_DepoType" => $depo_types[$depo_index],
                "U_District" => $districts[$district_index],
                "U_latitude" => $latitude,
                "U_longitude" => $longitude,
                "U_LicenseNo" => $license_no,
                "U_LicenseExp" => $license_exp,
                "U_Province" => $provinces[$province_index],
                "U_Type" => $depo_types[$type_index],
                "U_Tank_1_HSD" => $tank_capacity,
                "U_Tank_2_HSD" => $tank_capacity,
                "U_Tank_2_PMG" => $tank_capacity,
                "U_Tank_3_PMG" => $tank_capacity,
                "U_Tank_3_RON95" => $tank_capacity,
                "U_Tank_4_PMG" => $tank_capacity,
                "U_Tank_5_PMG" => $tank_capacity,
                "U_Tank_6_PMG" => $tank_capacity,
                "U_Tank_7_PMG" => $tank_capacity,
                "U_Tank_1_HSD_Stock" => $stock_value,
                "U_Tank_2_HSD_Stock" => $stock_value,
                "U_Tank_2_PMG_Stock" => $stock_value,
                "U_Tank_3_PMG_Stock" => $stock_value,
                "U_Tank_3_RON95_Stock" => $stock_value,
                "U_Tank_4_PMG_Stock" => $stock_value,
                "U_Tank_5_PMG_Stock" => $stock_value,
                "U_Tank_6_PMG_Stock" => $stock_value,
                "U_Tank_7_PMG_Stock" => $stock_value
            );
            
            $data[] = $formatted_data;
        }
        
        // Return in the same format as your example
        $response = array(
            "status" => "success",
            "data" => $data
        );
        
        echo json_encode($response);

    } else {
        echo json_encode(array("status" => "error", "message" => "Wrong Key..."));
    }

} else {
    echo json_encode(array("status" => "error", "message" => "Key is Required"));
}
?>