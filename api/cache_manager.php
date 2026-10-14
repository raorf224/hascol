<?php
header('Access-Control-Allow-Origin: *');

require_once '../config.php';

set_time_limit(0);
ini_set('max_execution_time', 0);

$action    = isset($_GET['action']) ? $_GET['action'] : 'read';
$cacheFile = isset($_GET['file']) ? $_GET['file'] : '';

// Get filter parameters
$dateFrom  = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-01');
$dateTo    = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$region    = isset($_GET['region']) ? $_GET['region'] : 'all';
$territory = isset($_GET['territory']) ? $_GET['territory'] : 'all';
$tm        = isset($_GET['tm']) ? $_GET['tm'] : 'all';
$site      = isset($_GET['site']) ? $_GET['site'] : 'all';
$product   = isset($_GET['product']) ? $_GET['product'] : 'all';

// ✅ Cache version
define('CACHE_VERSION', 'v1');

$cacheKey = $cacheFile . '_' . CACHE_VERSION . '_' . md5($dateFrom . $dateTo . $region . $territory . $tm . $site . $product);

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

$cacheDir = __DIR__ . '/cache/';
$logDir   = __DIR__ . '/logs/';

if (!is_dir($cacheDir)) mkdir($cacheDir, 0777, true);
if (!is_dir($logDir))   mkdir($logDir, 0777, true);

// ============================================
// Logging
// ============================================
function writeLog($message, $type = 'INFO')
{
    global $logDir;
    $logFile = $logDir . 'cache_manager.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] [$type] $message\n", FILE_APPEND);
}

// ============================================
// Auto-purge stale cache files
// ============================================
function cleanOldCache($currentBasePath)
{
    $cacheDir = __DIR__ . '/cache/';
    if (!is_dir($cacheDir)) return;

    $files = glob($cacheDir . '*.json');
    $deleted = 0;

    foreach ($files as $file) {
        $content = @file_get_contents($file);
        if ($content === false) continue;

        $data = json_decode($content, true);
        if (!$data) continue;

        $cachedUrl = $data['data']['_meta']['api_url'] ?? ($data['_meta']['api_url'] ?? '');
        if (!empty($cachedUrl) && strpos($cachedUrl, $currentBasePath) === false) {
            @unlink($file);
            $deleted++;
        }
    }

    if ($deleted > 0) {
        writeLog("Auto-purged $deleted stale cache files (basePath changed)");
    }
}

$__currentBasePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
cleanOldCache($__currentBasePath);

// ============================================
// AUTO MODE — HTML page with JS auto-refresher
// ============================================
if ($action === 'auto') {
    // Is request mein pehle refresh chala do
    $autoRefreshResult = doRefreshAll($allowedFiles, $cacheDir, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);

    // Cache status nikaalo
    $cacheStatus = getCacheStatus($allowedFiles, $cacheDir, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);

    // HTML page render karo
    renderAutoRefresherPage($autoRefreshResult, $cacheStatus, $dateFrom, $dateTo);
    exit;
}

// ============================================
// JSON RESPONSE MODE
// ============================================
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'data'    => []
];

try {
    if ($action === 'read') {
        writeLog("READ: $cacheFile - Filters: date_from=$dateFrom, date_to=$dateTo, region=$region");

        if (empty($cacheFile) || !in_array($cacheFile, $allowedFiles)) {
            throw new Exception('Invalid cache file');
        }

        $cachePath = $cacheDir . $cacheKey . '.json';

        if (!file_exists($cachePath)) {
            writeLog("Cache file not found, generating: $cacheKey");
            $data = generateCacheData($cacheFile, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);
            saveCache($cacheKey, $data);
            $response['data']   = $data;
            $response['cached'] = false;
            $response['stale']  = false;
        } else {
            $content = file_get_contents($cachePath);
            $data = json_decode($content, true);

            $cacheAge = time() - filemtime($cachePath);
            if ($cacheAge > 300) {
                writeLog("Cache stale (age: {$cacheAge}s), returning stale data for: $cacheKey");
                $response['data']   = $data;
                $response['cached'] = true;
                $response['stale']  = true;
                triggerBackgroundUpdate($cacheFile, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);
            } else {
                $response['data']   = $data;
                $response['cached'] = true;
                $response['stale']  = false;
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
        $response['data']    = $data;
        $response['cached']  = false;

    } elseif ($action === 'update_all') {
        writeLog("UPDATE_ALL started");

        $updated = 0;
        $failed  = 0;
        $errors  = [];

        foreach ($allowedFiles as $file) {
            writeLog("Updating: $file with filters: date_from=$dateFrom, date_to=$dateTo");
            $data = generateCacheData($file, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);

            if ($data && isset($data['success']) && $data['success'] === true) {
                $fileKey = $file . '_' . CACHE_VERSION . '_' . md5($dateFrom . $dateTo . $region . $territory . $tm . $site . $product);
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
            'failed'  => $failed,
            'total'   => count($allowedFiles),
            'errors'  => $errors
        ];

    } elseif ($action === 'refresh_all') {
        $result = doRefreshAll($allowedFiles, $cacheDir, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);

        $response['success'] = true;
        $response['message'] = "Refreshed: {$result['refreshed']}, Skipped: {$result['skipped']}, Failed: {$result['failed']}";
        $response['data']    = $result;

    } elseif ($action === 'status') {
        $status = getCacheStatus($allowedFiles, $cacheDir, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);

        $response['success'] = true;
        $response['message'] = 'Cache status retrieved';
        $response['data']    = $status;

    } else {
        throw new Exception('Invalid action. Allowed: read, update, update_all, refresh_all, status, auto');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    writeLog("ERROR: " . $e->getMessage(), 'ERROR');
}

echo json_encode($response, JSON_PRETTY_PRINT);


// ============================================
// Helper Functions
// ============================================

function doRefreshAll($allowedFiles, $cacheDir, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product)
{
    writeLog("REFRESH_ALL triggered");

    $refreshed = 0;
    $skipped   = 0;
    $failed    = 0;
    $errors    = [];

    foreach ($allowedFiles as $file) {
        $fileKey   = $file . '_' . CACHE_VERSION . '_' . md5($dateFrom . $dateTo . $region . $territory . $tm . $site . $product);
        $cachePath = $cacheDir . $fileKey . '.json';

        $needsRefresh = true;
        if (file_exists($cachePath)) {
            $cacheAge = time() - filemtime($cachePath);
            if ($cacheAge < 120) { // 2 min se fresh
                $needsRefresh = false;
            }
        }

        if (!$needsRefresh) {
            $skipped++;
            continue;
        }

        $data = generateCacheData($file, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product);

        if ($data && isset($data['success']) && $data['success'] === true) {
            saveCache($fileKey, $data);
            $refreshed++;
        } else {
            $failed++;
            $errors[] = $file;
        }
    }

    writeLog("REFRESH_ALL completed. Refreshed: $refreshed, Skipped: $skipped, Failed: $failed");

    return [
        'refreshed' => $refreshed,
        'skipped'   => $skipped,
        'failed'    => $failed,
        'total'     => count($allowedFiles),
        'errors'    => $errors,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

function getCacheStatus($allowedFiles, $cacheDir, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product)
{
    $status = [];

    foreach ($allowedFiles as $file) {
        $fileKey   = $file . '_' . CACHE_VERSION . '_' . md5($dateFrom . $dateTo . $region . $territory . $tm . $site . $product);
        $cachePath = $cacheDir . $fileKey . '.json';

        if (file_exists($cachePath)) {
            $age = time() - filemtime($cachePath);
            $status[$file] = [
                'exists'    => true,
                'age'       => $age,
                'age_human' => round($age / 60, 1) . ' min',
                'stale'     => $age > 300,
                'size'      => filesize($cachePath),
                'updated'   => date('Y-m-d H:i:s', filemtime($cachePath))
            ];
        } else {
            $status[$file] = [
                'exists'    => false,
                'stale'     => true,
                'age_human' => 'N/A'
            ];
        }
    }

    return $status;
}

function saveCache($key, $data)
{
    global $cacheDir;
    $cachePath = $cacheDir . $key . '.json';
    file_put_contents($cachePath, json_encode($data, JSON_PRETTY_PRINT));
}

function generateCacheData($fileName, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];

    $basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
    $apiUrl = $protocol . $host . $basePath . "/api/" . $fileName . ".php";

    $params = [
        'date_from' => $dateFrom,
        'date_to'   => $dateTo,
        'region'    => $region,
        'territory' => $territory,
        'tm'        => $tm,
        'site'      => $site,
        'product'   => $product
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
    curl_setopt($ch, CURLOPT_USERAGENT, 'Hascol-CacheManager/1.0');

    $startTime = microtime(true);
    $response  = curl_exec($ch);
    $duration  = round(microtime(true) - $startTime, 2);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    writeLog("API Response: $fileName - HTTP: $httpCode, Duration: {$duration}s");

    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        if ($data && isset($data['success'])) {
            $data['filters'] = $params;
            $data['_meta'] = [
                'generated_at' => date('Y-m-d H:i:s'),
                'duration'     => $duration,
                'api_url'      => $apiUrl
            ];
            return $data;
        } else {
            $rawPreview = substr($response, 0, 300);
            writeLog("API returned invalid JSON: $fileName - Preview: $rawPreview", 'ERROR');
        }
    }

    return [
        'success' => false,
        'data'    => [],
        'message' => 'Failed to fetch data: ' . $curlError . ' (HTTP: ' . $httpCode . ')',
        'filters' => $params,
        '_meta'   => [
            'generated_at' => date('Y-m-d H:i:s'),
            'duration'     => $duration,
            'api_url'      => $apiUrl,
            'error'        => $curlError
        ]
    ];
}

function triggerBackgroundUpdate($fileName, $dateFrom, $dateTo, $region, $territory, $tm, $site, $product)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');

    $url = $protocol . $host . $basePath . "/api/cache_manager.php?action=update&file=" . $fileName .
        "&date_from=" . $dateFrom . "&date_to=" . $dateTo .
        "&region=" . $region . "&territory=" . $territory .
        "&tm=" . $tm . "&site=" . $site . "&product=" . $product;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    writeLog("Background update triggered: $fileName (HTTP: $httpCode)");
}

// ============================================
// HTML Page Renderer for AUTO mode
// ============================================
function renderAutoRefresherPage($result, $cacheStatus, $dateFrom, $dateTo)
{
    $totalFiles   = count($cacheStatus);
    $freshFiles   = 0;
    $staleFiles   = 0;
    $missingFiles = 0;

    foreach ($cacheStatus as $file => $info) {
        if (!$info['exists']) {
            $missingFiles++;
        } elseif ($info['stale']) {
            $staleFiles++;
        } else {
            $freshFiles++;
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ✅ Meta Refresh — 3 minute (180 seconds) -->
        <meta http-equiv="refresh" content="180">
        <title>Hascol Cache Auto-Refresher</title>
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: linear-gradient(135deg, #0f2440 0%, #1d4ed8 100%);
                color: #fff;
                min-height: 100vh;
                padding: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                max-width: 900px;
                width: 100%;
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 16px;
                padding: 30px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }
            .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 25px;
                padding-bottom: 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
            .logo {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .logo-icon {
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, #f97316, #ea580c);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }
            .title h1 {
                font-size: 20px;
                font-weight: 700;
                letter-spacing: -0.02em;
            }
            .title p {
                font-size: 12px;
                color: rgba(255, 255, 255, 0.6);
                margin-top: 2px;
            }
            .live-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 14px;
                background: rgba(16, 185, 129, 0.15);
                border: 1px solid rgba(16, 185, 129, 0.3);
                border-radius: 999px;
                font-size: 11px;
                font-weight: 600;
                color: #10b981;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .pulse {
                width: 8px;
                height: 8px;
                background: #10b981;
                border-radius: 50%;
                animation: pulse 1.5s infinite;
            }
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
                100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
            }
            .stats {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 12px;
                margin-bottom: 25px;
            }
            .stat {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                padding: 16px;
                text-align: center;
            }
            .stat-value {
                font-size: 28px;
                font-weight: 700;
                letter-spacing: -0.03em;
                margin-bottom: 4px;
            }
            .stat-label {
                font-size: 10px;
                color: rgba(255, 255, 255, 0.5);
                text-transform: uppercase;
                letter-spacing: 0.08em;
                font-weight: 600;
            }
            .stat.green .stat-value { color: #10b981; }
            .stat.orange .stat-value { color: #f59e0b; }
            .stat.red .stat-value { color: #ef4444; }
            .stat.blue .stat-value { color: #60a5fa; }
            .files-list {
                background: rgba(0, 0, 0, 0.2);
                border-radius: 10px;
                padding: 6px;
                max-height: 380px;
                overflow-y: auto;
            }
            .file-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 14px;
                border-radius: 8px;
                margin-bottom: 2px;
                font-size: 13px;
                transition: background 0.15s;
            }
            .file-item:hover { background: rgba(255, 255, 255, 0.05); }
            .file-name {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 500;
            }
            .status-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
            }
            .status-dot.fresh { background: #10b981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.6); }
            .status-dot.stale { background: #f59e0b; box-shadow: 0 0 8px rgba(245, 158, 11, 0.6); }
            .status-dot.missing { background: #ef4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.6); }
            .file-meta {
                font-size: 11px;
                color: rgba(255, 255, 255, 0.5);
                font-family: 'Monaco', monospace;
            }
            .footer {
                margin-top: 25px;
                padding-top: 20px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 12px;
                color: rgba(255, 255, 255, 0.5);
            }
            .countdown {
                font-family: 'Monaco', monospace;
                font-weight: 700;
                color: #60a5fa;
            }
            .result-box {
                background: rgba(16, 185, 129, 0.1);
                border: 1px solid rgba(16, 185, 129, 0.2);
                border-radius: 10px;
                padding: 14px;
                margin-bottom: 25px;
                font-size: 13px;
            }
            .result-box .msg {
                font-weight: 600;
                color: #10b981;
                margin-bottom: 4px;
            }
            .result-box .details {
                color: rgba(255, 255, 255, 0.7);
                font-size: 12px;
            }
            @media (max-width: 600px) {
                .stats { grid-template-columns: repeat(2, 1fr); }
                .file-item { flex-direction: column; align-items: flex-start; gap: 4px; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="logo">
                    <div class="logo-icon">⚡</div>
                    <div class="title">
                        <h1>Cache Auto-Refresher</h1>
                        <p>Hascol OMC — Background Cache Manager</p>
                    </div>
                </div>
                <span class="live-badge">
                    <span class="pulse"></span> Active
                </span>
            </div>

            <!-- Last refresh result -->
            <div class="result-box">
                <div class="msg">✅ Last Refresh: <?php echo htmlspecialchars($result['timestamp']); ?></div>
                <div class="details">
                    Refreshed: <strong><?php echo $result['refreshed']; ?></strong> |
                    Skipped (fresh): <strong><?php echo $result['skipped']; ?></strong> |
                    Failed: <strong><?php echo $result['failed']; ?></strong> |
                    Total: <strong><?php echo $result['total']; ?></strong>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats">
                <div class="stat blue">
                    <div class="stat-value"><?php echo $totalFiles; ?></div>
                    <div class="stat-label">Total Files</div>
                </div>
                <div class="stat green">
                    <div class="stat-value"><?php echo $freshFiles; ?></div>
                    <div class="stat-label">Fresh</div>
                </div>
                <div class="stat orange">
                    <div class="stat-value"><?php echo $staleFiles; ?></div>
                    <div class="stat-label">Stale</div>
                </div>
                <div class="stat red">
                    <div class="stat-value"><?php echo $missingFiles; ?></div>
                    <div class="stat-label">Missing</div>
                </div>
            </div>

            <!-- Cache Files List -->
            <div class="files-list">
                <?php foreach ($cacheStatus as $file => $info): ?>
                    <?php
                    $dotClass = 'missing';
                    if ($info['exists']) {
                        $dotClass = $info['stale'] ? 'stale' : 'fresh';
                    }
                    ?>
                    <div class="file-item">
                        <div class="file-name">
                            <span class="status-dot <?php echo $dotClass; ?>"></span>
                            <span><?php echo htmlspecialchars($file); ?></span>
                        </div>
                        <div class="file-meta">
                            <?php if ($info['exists']): ?>
                                Age: <?php echo $info['age_human']; ?> |
                                Updated: <?php echo $info['updated']; ?>
                            <?php else: ?>
                                Not found
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="footer">
                <div>
                    Filters: <?php echo htmlspecialchars($dateFrom); ?> → <?php echo htmlspecialchars($dateTo); ?>
                </div>
                <div>
                    Next refresh in: <span class="countdown" id="countdown">180</span> sec
                </div>
            </div>
        </div>

        <script>
            // Countdown timer (visual only — actual refresh meta tag se hota hai)
            (function () {
                var seconds = 180;
                var el = document.getElementById('countdown');

                setInterval(function () {
                    seconds--;
                    if (seconds < 0) seconds = 180;
                    el.textContent = seconds;
                }, 1000);

                // Log
                console.log('[Cache Refresher] Page will auto-refresh in 180 seconds');
            })();
        </script>
    </body>
    </html>
    <?php
}
?>