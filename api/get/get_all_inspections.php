<?php
include("../../config.php");
session_start();
header("Content-Type: application/json");

// Get filters with defaults
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
$dealers = isset($_GET['dealers']) ? $_GET['dealers'] : [];
$response = isset($_GET['response']) ? $_GET['response'] : '';
$categories = isset($_GET['categories']) ? $_GET['categories'] : [];
$questions = isset($_GET['questions']) ? $_GET['questions'] : [];

// Build WHERE clause with proper escaping
$where = "WHERE 1=1";

// Date filter
if (!empty($from_date) && !empty($to_date)) {
    $where .= " AND DATE(sr.created_at) BETWEEN '" . $db->real_escape_string($from_date) . "' AND '" . $db->real_escape_string($to_date) . "'";
} elseif (!empty($from_date)) {
    $where .= " AND DATE(sr.created_at) >= '" . $db->real_escape_string($from_date) . "'";
} elseif (!empty($to_date)) {
    $where .= " AND DATE(sr.created_at) <= '" . $db->real_escape_string($to_date) . "'";
}

// Dealer filter - convert to comma separated
if (!empty($dealers) && is_array($dealers)) {
    $dealerList = implode(",", array_map('intval', $dealers));
    if (!empty($dealerList)) {
        $where .= " AND sr.dealer_id IN ($dealerList)";
    }
}

// Response filter
if (!empty($response)) {
    $responseValue = ucfirst(strtolower($response));
    $where .= " AND sr.response = '" . $db->real_escape_string($responseValue) . "'";
}

// Category filter
if (!empty($categories) && is_array($categories)) {
    $categoryList = implode(",", array_map('intval', $categories));
    if (!empty($categoryList)) {
        $where .= " AND sr.category_id IN ($categoryList)";
    }
}

// Question filter
if (!empty($questions) && is_array($questions)) {
    $questionList = implode(",", array_map('intval', $questions));
    if (!empty($questionList)) {
        $where .= " AND sr.question_id IN ($questionList)";
    }
}

// Main Query with LIMIT for performance
$sql = "
    SELECT 
        ROW_NUMBER() OVER (ORDER BY sr.created_at DESC) as sr_no,
        DATE(sr.created_at) as date,
        d.name as dealer_name,
        d.sap_no as sap_no,
        d.name as site_name,
        sc.name as category_name,
        ca.question as question_text,
        sr.response,
        '' as description
    FROM survey_response sr
    LEFT JOIN dealers d ON d.id = sr.dealer_id
    LEFT JOIN survey_category sc ON sc.id = sr.category_id
    LEFT JOIN survey_category_questions ca ON ca.id = sr.question_id
    $where
    ORDER BY sr.created_at DESC
    LIMIT 500
";

$result = $db->query($sql);
$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'sr_no' => $row['sr_no'],
            'date' => $row['date'],
            'dealer_name' => $row['dealer_name'] ?? 'N/A',
            'sap_no' => $row['sap_no'] ?? 'N/A',
            'site_name' => $row['site_name'] ?? 'N/A',
            'category_name' => $row['category_name'] ?? 'N/A',
            'question_text' => $row['question_text'] ?? 'N/A',
            'response' => $row['response'] ?? 'N/A',
            'description' => $row['description'] ?? 'N/A'
        ];
    }
}

echo json_encode($data);
?>