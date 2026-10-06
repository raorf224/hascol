<?php
ini_set('max_execution_time', 0);
set_time_limit(5000);

include("../../config.php");

$url1 = $_SERVER['REQUEST_URI'];
header("Refresh: 20; URL=$url1");

$access_key = '2170';
$pass = '2170';

$date = date('Y-m-d H:i:s');
echo "<h1>Sap Trip ETA Check service .</h1><br>";

if ($access_key != '') {
    if ($pass == $access_key) {

        // Fetch trips with vehicles
        $sql_query1 = "SELECT oi.*, dc.id AS vehicle_id, dc.name AS vehicle_name 
                       FROM order_info AS oi
                       LEFT JOIN devicesnew AS dc ON TRIM(REPLACE(dc.organisation, ' ', '')) = TRIM(REPLACE(oi.vehicle, ' ', ''))
                       WHERE oi.status=0 and oi.created_at>=curdate()
                       ORDER BY oi.id DESC";

        $result1 = $db->query($sql_query1) or die("Error in SQL query: " . $db->error);

        while ($user = $result1->fetch_assoc()) {
            $id = $user['id'];
            $customer_id = trim($user['customer_id']);
            $carrier_code = trim($user['carrier_code']);
            $vehicle_id = $user['vehicle_id'];

            $is_tracker = ($vehicle_id != '') ? "1" : "0";

            // Query dealers with sap_no after removing spaces
            $sql = "SELECT * FROM dealers WHERE REPLACE(sap_no, ' ', '') = '$customer_id' LIMIT 1";
            $result = mysqli_query($db, $sql);
            $dealer_co = '';
            if ($row = mysqli_fetch_assoc($result)) {
                $dealer_co = $row['co-ordinates']; // may be circle or polygon points
            }

            // Query geofence with code after removing spaces and geotype = 'depot'
            $sql2 = "SELECT * FROM geofenceing WHERE REPLACE(code, ' ', '') = '$carrier_code' AND geotype='depot' LIMIT 1";
            $result2 = mysqli_query($db, $sql2);
            $geo_co = '';
            $geo_type = '';
            if ($row2 = mysqli_fetch_assoc($result2)) {
                $geo_co = $row2['Coordinates']; // Could be circle (lat,lng) or polygon (lat,lng;lat,lng;...)
                $geo_type = strtolower($row2['type']); // assuming 'circle' or 'polygon' or similar
            }

            if ($geo_co != '' && $dealer_co != '') {
                // Parse geo_co and dealer_co coordinates
                $inside_geo = false;
                $threshold = 0.155; // 155 meters in km for circle check

                // Dealer coordinates (assumed circle center or a point)
                $dealer_coords = explode(',', str_replace(' ', '', $dealer_co));
                if (count($dealer_coords) != 2) {
                    echo "⚠️ Invalid dealer coordinates for ID $id<br>";
                    continue;
                }
                $dealer_lat = floatval($dealer_coords[0]);
                $dealer_lng = floatval($dealer_coords[1]);
                echo $geo_type;
                // Handle geofence by type
                if ($geo_type == 'polygon') {
                    // Polygon geofence - multiple points separated by ';'
                    $points = [];
                    foreach (explode(';', $geo_co) as $point) {
                        $coords = explode(',', str_replace(' ', '', $point));
                        if (count($coords) == 2) {
                            $points[] = [floatval($coords[1]), floatval($coords[0])];
                        }
                    }
                    if (count($points) < 3) {
                        echo "⚠️ Invalid polygon geofence for carrier code $carrier_code<br>";
                        continue;
                    }
                    // Check if dealer point inside polygon
                    $inside_geo = is_in_polygon($dealer_lat, $dealer_lng, $points);
                    echo "Polygon geofence check for trip $id: " . ($inside_geo ? "INSIDE" : "OUTSIDE") . "<br>";

                    // If outside polygon, calculate distance to polygon first point (or nearest point)
                    if (!$inside_geo) {
                        $distance = map_api($dealer_lat, $dealer_lng, $points[0][0], $points[0][1]);
                    } else {
                        $distance = 0;
                    }

                } elseif ($geo_type == 'circle') {
                    // Circle geofence - single point (lat,lng)
                    $circle_coords = explode(',', str_replace(' ', '', $geo_co));
                    if (count($circle_coords) != 2) {
                        echo "⚠️ Invalid circle geofence coordinates for carrier code $carrier_code<br>";
                        continue;
                    }
                    $circle_lat = floatval($circle_coords[0]);
                    $circle_lng = floatval($circle_coords[1]);

                    // Calculate distance dealer -> circle center
                    $distance = map_api($dealer_lat, $dealer_lng, $circle_lat, $circle_lng);

                    // Inside circle if distance less than threshold
                    $inside_geo = ($distance !== null && $distance <= $threshold);
                    echo "Circle geofence check for trip $id: " . ($inside_geo ? "INSIDE" : "OUTSIDE") . ", distance: $distance km<br>";

                } else {
                    // Unknown geofence type - fallback to circle coords check
                    $circle_coords = explode(',', str_replace(' ', '', $geo_co));
                    if (count($circle_coords) == 2) {
                        $circle_lat = floatval($circle_coords[0]);
                        $circle_lng = floatval($circle_coords[1]);
                        $distance = map_api($dealer_lat, $dealer_lng, $circle_lat, $circle_lng);
                        $inside_geo = ($distance !== null && $distance <= $threshold);
                        echo "Fallback circle geofence check for trip $id: " . ($inside_geo ? "INSIDE" : "OUTSIDE") . ", distance: $distance km<br>";
                    } else {
                        echo "⚠️ Unknown geofence format for trip $id<br>";
                        continue;
                    }
                }

                if ($distance !== null) {
                    // Calculate ETA based on distance
                    $sql_query2 = "SELECT *, DATE_ADD(DATE_ADD(created_at, INTERVAL ($distance/30) HOUR), INTERVAL 20 MINUTE) as eta_time 
                                   FROM order_info WHERE id='$id' LIMIT 1";
                    $result_eta = $db->query($sql_query2);
                    if ($user2 = $result_eta->fetch_assoc()) {
                        $eta_time = $user2['eta_time'];
                        $created_at = $user2['created_at'];

                        $update = "UPDATE order_info SET 
                                   status = '1',
                                   start_time = '$created_at',
                                   eta = '$eta_time',
                                   distance = '$distance',
                                   is_tracker = '$is_tracker'
                                   WHERE id = '$id'";

                        if ($db->query($update)) {
                            echo "✅ ETA Updated for trip $id<br>";
                        } else {
                            echo "❌ Error updating ETA for trip $id: " . $db->error . "<br>";
                        }
                    }
                } else {
                    echo "❌ Error calculating distance for trip $id<br>";
                }
            } else {
                echo "⚠️ Missing geofence or dealer coordinates for trip $id<br>";
            }
        }

        firebase_log('HascolBridge', 'order_info_eta_service.php', 'Success', "Run successfully.");

    } else {
        echo "Wrong Key...";
    }
} else {
    echo "Key is Required";
}


// Function: point-in-polygon using ray casting algorithm
function is_in_polygon($lat, $lng, $polygon) {
    $inside = false;
    $j = count($polygon) - 1;
    for ($i = 0; $i < count($polygon); $i++) {
        if ((($polygon[$i][1] > $lng) != ($polygon[$j][1] > $lng)) &&
            ($lat < ($polygon[$j][0] - $polygon[$i][0]) * ($lng - $polygon[$i][1]) / ($polygon[$j][1] - $polygon[$i][1]) + $polygon[$i][0])
        ) {
            $inside = !$inside;
        }
        $j = $i;
    }
    return $inside;
}

function map_api($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
    $url = "http://localhost:8989/route?point=$latitudeFrom,$longitudeFrom&point=$latitudeTo,$longitudeTo&profile=car&locale=en&instructions=false";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['paths'][0]['distance'])) {
        return $data['paths'][0]['distance'] / 1000;
    } else {
        return null;
    }
}

echo 'Service Last Run => ' . date('Y-m-d H:i:s');

function firebase_log($company, $service, $status, $message) {

    $payload = json_encode([
        'company' => $company,
        'service' => $service,
        'status' => $status,
        'message' => $message
    ]);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://151.106.17.246:8080/firebase_systems_logs/firebase_bridge.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $payload, // Data ko JSON string ke roop mein bhejein
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json', // Yeh header ab data format se match karega
        'Content-Length: ' . strlen($payload)
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
}
?>
