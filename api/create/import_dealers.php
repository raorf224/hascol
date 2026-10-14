<?php
// ============================================
// Import Dealers from SAP CPI
// Batch-based for progress tracking
// ============================================
header('Content-Type: application/json');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include("../../config.php");
session_start();

// ============================================
// DB Connection Check
// ============================================
if (!isset($db) || !$db) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// ============================================
// SAP CPI Config
// ============================================
define('SAP_URL', 'https://hascol-is-hm2e0cuf.it-cpi033-rt.cfapps.eu10-005.hana.ondemand.com/http/ZDD_DEALER_MASTER_INT');
define('SAP_AUTH', 'Basic c2ItNmIwNjc0ZmItNzJkYS00Y2M0LWJlYWYtYmNlMjgxODE3OGEzIWI2MTUyMjZ8aXQtcnQtaGFzY29sLWlzLWhtMmUwY3VmIWI1NDMwOTE6YzFmMjRkZTktNGFiNC00ZTAxLTkxZjItMDU4OGMyNTAwYTU2JDR6S1dNci1mLXVINGJHa0E1UXNDdU1KLUUyN2NMeFZWeTJCUUVXT0tjR2M9');

// ============================================
// Region Short → Full Mapping
// ============================================
function mapRegion($short) {
    $map = [
        'SD'  => 'Sindh',
        'BA'  => 'Balochistan',
        'PB'  => 'Punjab',
        'KP'  => 'Khyber Pakhtunkhwa',
        'KPK' => 'Khyber Pakhtunkhwa',
        'GB'  => 'Gilgit Baltistan',
        'AJK' => 'Azad Jammu & Kashmir',
        'ICT' => 'Islamabad Capital Territory',
    ];
    $short = strtoupper(trim($short));
    return isset($map[$short]) ? $map[$short] : $short;
}

// ============================================
// Fetch SAP Data (with cURL)
// ============================================
function fetchSapDealers() {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => SAP_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPHEADER     => [
            'Authorization: ' . SAP_AUTH,
            'Cookie: JSESSIONID=9AF4CC7CDABDFBDE008C2ADEF304529E; __VCAP_ID_META__=secure; __VCAP_ID__=f9de578b-f052-4330-6c95-aba0',
        ],
    ]);
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) return ['error' => 'cURL Error: ' . $err];
    if ($httpCode !== 200) return ['error' => "SAP HTTP $httpCode response"];

    $json = json_decode($resp, true);
    if (!$json || !isset($json['ZDD_DEALER_MASTER_INT']['ZDD_DEALER_MASTER_INTType'])) {
        return ['error' => 'Invalid SAP response structure'];
    }
    return ['data' => $json['ZDD_DEALER_MASTER_INT']['ZDD_DEALER_MASTER_INTType']];
}

// ============================================
// Main Handler
// ============================================
$action = isset($_POST['action']) ? $_POST['action'] : 'fetch';

// ---------------------------------------------
// ACTION: fetch — SAP data pull karke unique list banaye
// ---------------------------------------------
if ($action === 'fetch') {
    $result = fetchSapDealers();
    if (isset($result['error'])) {
        echo json_encode(['status' => 'error', 'message' => $result['error']]);
        exit;
    }

    $sapDealers = $result['data'];
    $seen = [];
    $unique = [];

    foreach ($sapDealers as $row) {
        $sapNo = isset($row['DealerStationCode']) ? trim($row['DealerStationCode']) : '';
        if ($sapNo === '') continue;
        if (isset($seen[$sapNo])) continue;   // skip duplicate from SAP
        $seen[$sapNo] = true;
        $unique[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'total'  => count($unique),
        'dealers' => $unique
    ]);
    exit;
}

// ---------------------------------------------
// ACTION: import_batch — ek batch insert kare
// ---------------------------------------------
if ($action === 'import_batch') {
    $batchJson = isset($_POST['batch']) ? $_POST['batch'] : '';
    if (empty($batchJson)) {
        echo json_encode(['status' => 'error', 'message' => 'No batch data provided']);
        exit;
    }

    $dealers = json_decode($batchJson, true);
    if (!is_array($dealers)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid batch JSON']);
        exit;
    }

    $inserted = 0;
    $skipped  = 0;
    $errors   = [];

    foreach ($dealers as $d) {
        try {
            // -------- SAP Fields --------
            $name          = isset($d['DealerStationName'])      ? trim($d['DealerStationName'])      : '';
            $sapNo         = isset($d['DealerStationCode'])      ? trim($d['DealerStationCode'])      : '';
            $city          = isset($d['City'])                   ? trim($d['City'])                   : '';
            $region        = isset($d['Region'])                 ? mapRegion($d['Region'])            : '';
            $depo          = isset($d['DepoName'])               ? trim($d['DepoName'])               : '';
            $rettype       = isset($d['DistributionChannelName'])? trim($d['DistributionChannelName']): '';
            $acount        = isset($d['TotalAmtInCoCdCrcy'])     ? trim($d['TotalAmtInCoCdCrcy'])     : '0';

            if ($name === '' || $sapNo === '') {
                $skipped++;
                continue;
            }

            // -------- Duplicate Check (by sap_no) --------
            $sapNoEsc = mysqli_real_escape_string($db, $sapNo);
            $check = mysqli_query($db, "SELECT id FROM `dealers` WHERE `sap_no` = '$sapNoEsc' LIMIT 1");
            if ($check && mysqli_num_rows($check) > 0) {
                $skipped++;
                continue;
            }

            // -------- Escape All Values --------
            $nameEsc    = mysqli_real_escape_string($db, $name);
            $cityEsc    = mysqli_real_escape_string($db, $city);
            $regionEsc  = mysqli_real_escape_string($db, $region);
            $depoEsc    = mysqli_real_escape_string($db, $depo);
            $rettypeEsc = mysqli_real_escape_string($db, $rettype);
            $acountEsc  = mysqli_real_escape_string($db, $acount);

            $privilege   = 'Dealer';
            $creditLimit = '1500000';
            $sapFlag     = '1';
            $createdBy   = '1';
            $now         = date('Y-m-d H:i:s');

            // -------- INSERT --------
            $sql = "INSERT INTO `dealers`
                (`name`, `privilege`, `sap_no`, `credit_limit`, `city`, `region`,
                 `depo`, `rettype`, `rettype_desc`, `acount`, `is_found_in_sap_api`,
                 `created_by`, `created_at`, `updated_at`)
                VALUES
                ('$nameEsc', '$privilege', '$sapNoEsc', '$creditLimit', '$cityEsc', '$regionEsc',
                 '$depoEsc', '$rettypeEsc', '$rettypeEsc', '$acountEsc', '$sapFlag',
                 '$createdBy', '$now', '$now')";

            if (mysqli_query($db, $sql)) {
                $inserted++;
            } else {
                $errors[] = "Failed: $name ($sapNo)";
            }

        } catch (mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $skipped++;
            } else {
                $errors[] = $e->getMessage();
            }
        }
    }

    echo json_encode([
        'status'   => 'success',
        'inserted' => $inserted,
        'skipped'  => $skipped,
        'errors'   => $errors
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
?>