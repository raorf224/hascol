<?php
// view_logs.php - View error logs

header('Content-Type: text/plain');

$logFile = __DIR__ . '/logs/cache_manager.log';

if (!file_exists($logFile)) {
    echo "No logs found yet. Run cache_manager.php first.";
    exit;
}

echo "=== CACHE MANAGER LOGS ===\n\n";
echo file_get_contents($logFile);
?>