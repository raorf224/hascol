pupdate<?php 
date_default_timezone_set('Asia/Karachi');

// === STEP 1: Fetch data from API ===
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://151.106.17.246:8080/hascolBridgeApis/get/get_last_updated_record.php?key=2170',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_FOLLOWLOCATION => true,
));
$response = curl_exec($curl);
curl_close($curl);

// === STEP 2: Decode API response ===
$data = json_decode($response, true);

// 🔍 Debug check — print the API response so we know the actual structure
if (!$data) {
    die(json_encode(["status" => "error", "message" => "API returned invalid JSON", "raw_response" => $response]));
}

// === Identify time field dynamically ===
$lastUpdated = null;

// Try common possible keys
$possibleKeys = ['time', 'last_updated_time', 'lastUpdated', 'updated_time', 'timestamp', 'last_update'];

foreach ($possibleKeys as $key) {
    if (isset($data[$key]) && !empty($data[$key])) {
        $lastUpdated = $data[$key];
        break;
    }
}

// If still not found, check nested JSON (like $data[0]['time'])
if (!$lastUpdated && isset($data[0]) && is_array($data[0])) {
    foreach ($possibleKeys as $key) {
        if (isset($data[0][$key]) && !empty($data[0][$key])) {
            $lastUpdated = $data[0][$key];
            break;
        }
    }
}

// === Error if not found ===
if (!$lastUpdated) {
    die(json_encode([
        "status" => "error", 
        "message" => "Could not find time field in API response.",
        "raw_data" => $data
    ]));
}

// === STEP 3: Calculate time difference (in minutes) ===
$currentTime = new DateTime();
$updatedTime = new DateTime($lastUpdated);
$diffMinutes = round(abs($currentTime->getTimestamp() - $updatedTime->getTimestamp()) / 60);

echo "Last updated: $lastUpdated\n";
echo "Current time: " . $currentTime->format('Y-m-d H:i:s') . "\n";
echo "Time difference: {$diffMinutes} minutes\n";

// === STEP 4: Define call function ===
function triggerCall($numbers = []) {
    foreach ($numbers as $num) {
        $url = "http://example.com/call_api.php?phone=" . urlencode($num); // replace with real API
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ));
        $res = curl_exec($curl);
        curl_close($curl);
        echo "Call triggered to $num | Response: $res\n";
    }
}

// === STEP 5: Decide who to call based on time difference ===
if ($diffMinutes > 10 && $diffMinutes <= 60) {
    $numbers = ["03001234567", "03017654321"]; // 2 numbers
    triggerCall($numbers);
    echo "Condition: Between 10 and 60 minutes -> 2 calls triggered.\n";
} elseif ($diffMinutes > 60) {
    $numbers = ["03001234567", "03017654321", "03019876543", "03025553333"]; // 4 numbers
    triggerCall($numbers);
    echo "Condition: Greater than 60 minutes -> 4 calls triggered.\n";
} else {
    echo "Condition: Within 10 minutes -> No call triggered.\n";
}
?>
