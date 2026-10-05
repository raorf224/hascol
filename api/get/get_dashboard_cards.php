<?php
include("../../config.php");
session_start();
header("Content-Type: application/json");

// Get and sanitize input parameters
$from_date = isset($_GET['from_date']) ? $db->real_escape_string($_GET['from_date']) : '';
$to_date = isset($_GET['to_date']) ? $db->real_escape_string($_GET['to_date']) : '';
$dealers = isset($_GET['dealers']) ? $_GET['dealers'] : [];
$response = isset($_GET['response']) ? $db->real_escape_string($_GET['response']) : '';
$categories = isset($_GET['categories']) ? $_GET['categories'] : [];
$questions = isset($_GET['questions']) ? $_GET['questions'] : [];

$whereSurvey = "WHERE 1=1";

// Apply date filter with proper validation
if ($from_date && $to_date) {
    // Validate date format (assuming Y-m-d format)
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $from_date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $to_date)) {
        $whereSurvey .= " AND DATE(sr.created_at) BETWEEN '$from_date' AND '$to_date'";
    }
} elseif ($from_date && preg_match('/^\d{4}-\d{2}-\d{2}$/', $from_date)) {
    $whereSurvey .= " AND DATE(sr.created_at) >= '$from_date'";
} elseif ($to_date && preg_match('/^\d{4}-\d{2}-\d{2}$/', $to_date)) {
    $whereSurvey .= " AND DATE(sr.created_at) <= '$to_date'";
}

// Dealer filter
if (!empty($dealers) && is_array($dealers)) {
    $dealerList = implode(",", array_map('intval', $dealers));
    $whereSurvey .= " AND sr.dealer_id IN ($dealerList)";
}

// Response filter
if ($response) {
    $responseValue = ucfirst(strtolower($response));
    // Only apply if it's a valid response value
    if (in_array($responseValue, ['Yes', 'No', 'N/A'])) {
        $whereSurvey .= " AND sr.response = '$responseValue'";
    }
}

// Category filter
if (!empty($categories) && is_array($categories)) {
    $categoryList = implode(",", array_map('intval', $categories));
    $whereSurvey .= " AND sr.category_id IN ($categoryList)";
}

// Question filter
if (!empty($questions) && is_array($questions)) {
    $questionList = implode(",", array_map('intval', $questions));
    $whereSurvey .= " AND sr.question_id IN ($questionList)";
}

// Total Inspections (distinct main_id count)
$sql = "SELECT COUNT(DISTINCT sr.main_id) as inspections FROM survey_response sr $whereSurvey";
$res = $db->query($sql);
$inspections = $res ? $res->fetch_assoc()['inspections'] : 0;

// YES Responses
$sql = "SELECT COUNT(*) as yesCount FROM survey_response sr $whereSurvey AND sr.response = 'Yes'";
$res = $db->query($sql);
$yesCount = $res ? $res->fetch_assoc()['yesCount'] : 0;

// NO Responses
$sql = "SELECT COUNT(*) as noCount FROM survey_response sr $whereSurvey AND sr.response = 'No'";
$res = $db->query($sql);
$noCount = $res ? $res->fetch_assoc()['noCount'] : 0;

// N/A Responses (Added this section)
$sql = "SELECT COUNT(*) as naCount FROM survey_response sr $whereSurvey AND sr.response = 'N/A'";
$res = $db->query($sql);
$naCount = $res ? $res->fetch_assoc()['naCount'] : 0;

// Calculate total responses (optional)
$totalResponses = $yesCount + $noCount + $naCount;

echo json_encode([
    'inspections' => (int)$inspections,
    'yes'         => (int)$yesCount,
    'no'          => (int)$noCount,
    'na'          => (int)$naCount,  // Added N/A count
    'total_responses' => (int)$totalResponses, // Optional: total of all responses
    'status'      => 'success'
]);

// Close database connection (optional - if not using persistent connection)
if (isset($db)) {
    $db->close();
}
?>