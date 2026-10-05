<?php
include("../config.php");
session_start();
header("Content-Type: application/json");

$from_date = $_GET['from_date'] ?? '';
$to_date = $_GET['to_date'] ?? '';
$dealers = $_GET['dealers'] ?? [];
$response = $_GET['response'] ?? '';
$categories = $_GET['categories'] ?? [];
$questions = $_GET['questions'] ?? [];

$where = "WHERE 1=1";

// Date filter
if ($from_date && $to_date) {
    $where .= " AND DATE(sr.created_at) BETWEEN '$from_date' AND '$to_date'";
} elseif ($from_date) {
    $where .= " AND DATE(sr.created_at) >= '$from_date'";
} elseif ($to_date) {
    $where .= " AND DATE(sr.created_at) <= '$to_date'";
}

// Dealer filter
if (!empty($dealers) && is_array($dealers)) {
    $dealerList = implode(",", array_map('intval', $dealers));
    $where .= " AND sr.dealer_id IN ($dealerList)";
}

// Response filter
if ($response) {
    $responseValue = ucfirst(strtolower($response));
    $where .= " AND sr.response = '$responseValue'";
}

// Category filter
if (!empty($categories) && is_array($categories)) {
    $categoryList = implode(",", array_map('intval', $categories));
    $where .= " AND sr.category_id IN ($categoryList)";
}

// Question filter
if (!empty($questions) && is_array($questions)) {
    $questionList = implode(",", array_map('intval', $questions));
    $where .= " AND sr.question_id IN ($questionList)";
}

// Count Yes
$yesSQL = "SELECT COUNT(*) as count FROM survey_response_eng sr $where AND sr.response = 'Yes'";
$res = $db->query($yesSQL);
$yes = $res ? (int)$res->fetch_assoc()['count'] : 0;

// Count No
$noSQL = "SELECT COUNT(*) as count FROM survey_response_eng sr $where AND sr.response = 'No'";
$res = $db->query($noSQL);
$no = $res ? (int)$res->fetch_assoc()['count'] : 0;

// -------- Issue Chart --------
$issueSQL = "
    SELECT 
        DATE(sr.created_at) as issue_date,
        COUNT(*) as count
    FROM survey_response_eng sr
    $where AND sr.response = 'No' AND sr.comment IS NOT NULL AND sr.comment != ''
    GROUP BY DATE(sr.created_at)
    ORDER BY issue_date DESC
    LIMIT 10
";

$res = $db->query($issueSQL);
$labels = [];
$data = [];
$details = [];

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $date = $row['issue_date'];
        $labels[] = $date;
        $data[] = (int)$row['count'];

        $detailSQL = "
            SELECT 
                DATE(sr.created_at) as date,
                sr.comment,
                sr.response,
                COALESCE(d.name, CONCAT('Unknown Dealer (ID: ', sr.dealer_id, ')')) as site_name
            FROM survey_response_eng sr
            LEFT JOIN dealers d ON d.id = sr.dealer_id
            $where AND DATE(sr.created_at) = '$date'
            AND sr.comment IS NOT NULL AND sr.comment != ''
            ORDER BY sr.created_at DESC
            LIMIT 100
        ";

        $subres = $db->query($detailSQL);
        $details[$date] = [];

        if ($subres && $subres->num_rows > 0) {
            while ($subrow = $subres->fetch_assoc()) {
                $details[$date][] = [
                    'date' => $subrow['date'],
                    'site_name' => $subrow['site_name'],
                    'response' => $subrow['response'],
                    'comment' => $subrow['comment']
                ];
            }
        }
    }
}

// -------- Timeline Chart (Category-wise trends) --------
$timelineSQL = "
    SELECT 
        DATE(sr.created_at) as date,
        sc.name as category,
        COUNT(*) as total
    FROM survey_response sr
    LEFT JOIN survey_category_eng sc ON sc.id = sr.category_id
    $where
    GROUP BY DATE(sr.created_at), sc.name
    ORDER BY DATE(sr.created_at)
";

$timelineRes = $db->query($timelineSQL);
$timeline = [];

if ($timelineRes) {
    while ($row = $timelineRes->fetch_assoc()) {
        $date = $row['date'];
        $category = $row['category'] ?? 'Uncategorized';
        $count = (int)$row['total'];

        if (!isset($timeline[$category])) {
            $timeline[$category] = [];
        }
        $timeline[$category][$date] = $count;
    }
}

// Build timeline data
$allDates = [];
foreach ($timeline as $dates) {
    $allDates = array_merge($allDates, array_keys($dates));
}
$allDates = array_unique($allDates);
sort($allDates);

$timelineData = [
    'labels' => $allDates,
    'datasets' => []
];

$colors = ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997'];
$colorIndex = 0;

foreach ($timeline as $category => $dateCounts) {
    $dataPoints = [];

    foreach ($allDates as $date) {
        $dataPoints[] = $dateCounts[$date] ?? 0;
    }

    $timelineData['datasets'][] = [
        'label' => $category,
        'data' => $dataPoints,
        'borderColor' => $colors[$colorIndex % count($colors)],
        'backgroundColor' => 'transparent',
        'tension' => 0.4,
        'fill' => false
    ];

    $colorIndex++;
}

// Final Response
echo json_encode([
    'yes' => $yes,
    'no' => $no,
    'issues' => [
        'labels' => $labels,
        'data' => $data,
        'details' => $details
    ],
    'timeline' => $timelineData
]);
?>
