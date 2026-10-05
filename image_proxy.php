<?php
// image_proxy.php
// Ye file images ko CORS-safe banane ke liye proxy karti hai

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, OPTIONS");
// header("Cross-Origin-Resource-Policy: cross-origin");

// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit;
// }

// $url = isset($_GET['url']) ? $_GET['url'] : '';

// if (empty($url)) {
//     http_response_code(400);
//     echo "Missing url parameter";
//     exit;
// }

// // Security: sirf allowed domain se images allow karein
// $allowed_host = '151.106.17.246';
// $parsed = parse_url($url);
// if (!isset($parsed['host']) || $parsed['host'] !== $allowed_host) {
//     http_response_code(403);
//     echo "Forbidden host";
//     exit;
// }

// // Image fetch karein
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// curl_setopt($ch, CURLOPT_TIMEOUT, 30);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

// $data = curl_exec($ch);
// $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
// $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// curl_close($ch);

// if ($httpCode !== 200 || $data === false) {
//     http_response_code(502);
//     echo "Failed to fetch image";
//     exit;
// }

// header("Content-Type: " . ($contentType ?: 'image/jpeg'));
// header("Cache-Control: public, max-age=86400");
// echo $data;