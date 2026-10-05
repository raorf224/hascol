<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config.php';

// No time limits
set_time_limit(0);
ini_set('max_execution_time', 0);

$response = [
    'success' => false,
    'message' => '',
    'data' => []
];

$action = isset($_GET['action']) ? $_GET['action'] : 'read';
$cacheFile = isset($_GET['file']) ? $_GET['file'] : '';

// Get filter parameters for cache key
$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-01');
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$region = isset($_GET['region']) ? $_GET['region'] : 'all';
$territory = isset($_GET['territory']) ? $_GET['territory'] : 'all';
$tm = isset($_GET['tm']) ? $_GET['tm'] : 'all';
$site = isset($_GET['site']) ? $_GET['site'] : 'all';
$product = isset($_GET['product']) ? $_GET['product'] : 'all';

// Create a unique cache key based on filters
$cacheKey = $cacheFile . '_' . md5($dateFrom . $dateTo . $region . $territory . $tm . $site . $product);

$allowedFiles = [
    'dashboard_data',
    'map_data',
    'alerts_data',
    'trends_data',
    'variance_data',
    'recon_efficiency',
    'tm_performance',
    'top_sites',
    'site_details',
    'filter_options'
];

// Create logs directory
$logDir = __DIR__ . '/../logs/';
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

// Log function
function writeLog($message, $type = 'INFO')
{
    global $logDir;
    $logFile = $logDir . 'cache_manager.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] [$type] $message\n", FILE_APPEND);
}

try {
    if ($action === 'read') {
        writeLog("READ: $cacheFile - Filters: date_from=$dateFrom, date_to=$dateTo, region=$region");

        if (empty($cacheFile) || !in_array($cacheFile, $allowedFiles)) {
            throw new Exception('Invalid cache file');
        }

        // Use filter-aware cache path
        $cachePath = __DIR__ . '/../cache/' . $cacheKey . '.json';

        if (!file_exists($cachePath)) {
            writeLog("Cache file not found, generating: $cacheKey");
            $data = generateCacheData($cacheFile, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);
            saveCache($cacheKey, $data);
            $response['data'] = $data;
            $response['cached'] = false;
            $response['filters'] = ['date_from' => $dateFrom, 'date_to' => $dateTo, 'region' => $region];
        } else {
            // Read from cache
            $content = file_get_contents($cachePath);
            $data = json_decode($content, true);

            // Check if cache is expired (older than 5 minutes)
            $cacheAge = time() - filemtime($cachePath);
            if ($cacheAge > 300) {
                writeLog("Cache stale (age: {$cacheAge}s), returning stale data for: $cacheKey");
                $response['data'] = $data;
                $response['cached'] = true;
                $response['stale'] = true;
                // Trigger background update with same filters
                triggerBackgroundUpdate($cacheFile, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);
            } else {
                $response['data'] = $data;
                $response['cached'] = true;
                $response['stale'] = false;
            }
        }

        $response['success'] = true;
        $response['message'] = 'Data loaded from cache';
        $response['filters'] = ['date_from' => $dateFrom, 'date_to' => $dateTo, 'region' => $region];

    } elseif ($action === 'update') {
        writeLog("UPDATE: $cacheFile - Filters: date_from=$dateFrom, date_to=$dateTo");

        if (empty($cacheFile) || !in_array($cacheFile, $allowedFiles)) {
            throw new Exception('Invalid cache file');
        }

        $data = generateCacheData($cacheFile, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);
        saveCache($cacheKey, $data);

        writeLog("UPDATE completed: $cacheKey");

        $response['success'] = true;
        $response['message'] = 'Cache updated successfully';
        $response['data'] = $data;
        $response['cached'] = false;
        $response['filters'] = ['date_from' => $dateFrom, 'date_to' => $dateTo, 'region' => $region];

    } elseif ($action === 'update_all') {
        writeLog("UPDATE_ALL started");

        $updated = 0;
        $failed = 0;
        $errors = [];

        foreach ($allowedFiles as $file) {
            writeLog("Updating: $file with filters: date_from=$dateFrom, date_to=$dateTo");
            $data = generateCacheData($file, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);
            if ($data && isset($data['success']) && $data['success'] === true) {
                $fileKey = $file . '_' . md5($dateFrom . $dateTo . $region . $territory . $tm . $site . $product);
                saveCache($fileKey, $data);
                $updated++;
                writeLog("Updated: $file - SUCCESS");
            } else {
                $failed++;
                $errorMsg = $data['message'] ?? 'Unknown error';
                $errors[] = "$file: $errorMsg";
                writeLog("Updated: $file - FAILED - $errorMsg");
            }
        }

        writeLog("UPDATE_ALL completed. Updated: $updated, Failed: $failed");

        $response['success'] = true;
        $response['message'] = "Cache updated: $updated success, $failed failed";
        $response['data'] = [
            'updated' => $updated,
            'failed' => $failed,
            'total' => count($allowedFiles),
            'errors' => $errors,
            'filters' => ['date_from' => $dateFrom, 'date_to' => $dateTo, 'region' => $region]
        ];

    } else {
        throw new Exception('Invalid action');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    writeLog("ERROR: " . $e->getMessage(), 'ERROR');
}

echo json_encode($response);

// ============================================
// Helper Functions
// ============================================

function saveCache($key, $data)
{
    $cacheDir = __DIR__ . '/../cache/';

    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0777, true);
    }

    $cachePath = $cacheDir . $key . '.json';
    file_put_contents($cachePath, json_encode($data, JSON_PRETTY_PRINT));
}

function generateCacheData($fileName, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $apiUrl = $protocol . $host . "/hascol_dashboard/api/" . $fileName . ".php";

    // Build params
    $params = [
        'date_from' => $dateFrom,
        'date_to' => $dateTo,
        'region' => $region,
        'territory' => $territory,
        'tm' => $tm,
        'site' => $site,
        'product' => $product
    ];

    $apiUrl .= '?' . http_build_query($params);

    writeLog("Calling API: $apiUrl");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $startTime = microtime(true);
    $response = curl_exec($ch);
    $duration = round(microtime(true) - $startTime, 2);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    writeLog("API Response: $fileName - HTTP: $httpCode, Duration: {$duration}s");

    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        if ($data && isset($data['success'])) {
            $data['filters'] = $params;
            $data['_meta'] = [
                'generated_at' => date('Y-m-d H:i:s'),
                'duration' => $duration,
                'api_url' => $apiUrl
            ];
            return $data;
        } else {
            writeLog("API returned error: $fileName - " . ($data['message'] ?? 'Unknown error'), 'ERROR');
        }
    }

    return [
        'success' => false,
        'data' => [],
        'message' => 'Failed to fetch data: ' . $curlError . ' (HTTP: ' . $httpCode . ')',
        'filters' => $params,
        '_meta' => [
            'generated_at' => date('Y-m-d H:i:s'),
            'duration' => $duration,
            'api_url' => $apiUrl,
            'error' => $curlError
        ]
    ];
}

function triggerBackgroundUpdate($fileName, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $url = $protocol . $host . "/hascol_dashboard/api/cache_manager.php?action=update&file=" . $fileName .
        "&date_from=" . $dateFrom . "&date_to=" . $dateTo .
        "&region=" . $region . "&territory=" . $territory .
        "&tm=" . $tm . "&site=" . $site . "&product=" . $product;

    $parts = parse_url($url);
    $host = $parts['host'];
    $port = isset($parts['port']) ? $parts['port'] : 80;
    $path = isset($parts['path']) ? $parts['path'] : '/';
    if (isset($parts['query'])) {
        $path .= '?' . $parts['query'];
    }

    $fp = @fsockopen($host, $port, $errno, $errstr, 1);
    if ($fp) {
        $out = "GET $path HTTP/1.1\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        fclose($fp);
        writeLog("Background update triggered: $fileName with filters");
    } else {
        writeLog("Background update failed: $fileName - $errstr", 'ERROR');
    }
}
?>