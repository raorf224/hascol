<?php
// cache_watcher.php
// Run this in terminal: php cache_watcher.php

echo "========================================\n";
echo "  HASCOL DASHBOARD CACHE WATCHER\n";
echo "  Running continuously... Press Ctrl+C to stop\n";
echo "========================================\n\n";

$counter = 0;
$logFile = __DIR__ . '/logs/watcher.log';

// Create logs directory
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0777, true);
}

while (true) {
    $counter++;
    $timestamp = date('Y-m-d H:i:s');
    echo "[$timestamp] #$counter - Updating cache... ";

    // Call cache manager with better error handling
    $url = 'localhost/hascol_dashboard/api/cache_manager.php?action=update_all';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    // Log to file
    $logEntry = "[$timestamp] #$counter - ";
    if ($httpCode === 200 && $response) {
        echo "✅ SUCCESS\n";
        $logEntry .= "SUCCESS - HTTP: $httpCode\n";

        // Parse response to see how many caches updated
        $data = json_decode($response, true);
        if ($data && isset($data['data']['updated'])) {
            echo "   Updated: " . $data['data']['updated'] . " of " . $data['data']['total'] . " caches\n";
            $logEntry .= "   Updated: " . $data['data']['updated'] . " of " . $data['data']['total'] . " caches\n";
        }
    } else {
        echo "❌ FAILED (HTTP: $httpCode)\n";
        if ($curlError) {
            echo "   Error: $curlError\n";
            $logEntry .= "FAILED - HTTP: $httpCode - Error: $curlError\n";
        } else {
            $logEntry .= "FAILED - HTTP: $httpCode\n";
        }
    }

    file_put_contents($logFile, $logEntry, FILE_APPEND);

    // Wait 5 minutes before next update
    echo "   Next update in 5 minutes...\n";
    echo "   Press Ctrl+C to stop\n\n";

    for ($i = 300; $i > 0; $i--) {
        echo "\r   Waiting... " . gmdate("i:s", $i) . " remaining  ";
        sleep(1);
    }
    echo "\n";
}
?>