<?php
// Hascol OMC - Session Guard
// Har protected page ke TOP pe include hoga

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// 0. Base URL dynamically calculate karo
// ============================================
$__project_root_fs = str_replace('\\', '/', realpath(dirname(__DIR__)));
$__doc_root_fs = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));

$__base_url = '';
if ($__project_root_fs && $__doc_root_fs) {
    $__base_url = str_replace($__doc_root_fs, '', $__project_root_fs);
    $__base_url = rtrim($__base_url, '/');
}

// ============================================
// 1. Login check
// ============================================
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: ' . $__base_url . '/login.php');
    exit;
}

// ============================================
// 2. Topbar ke liye user data
// ============================================
$topbar_user_name      = $_SESSION['user_name'] ?? 'User';
$topbar_user_privilege = $_SESSION['privilege'] ?? '';
$topbar_user_initial   = strtoupper(substr($topbar_user_name, 0, 1));

// ============================================
// 3. Current page ki permission check
// ============================================
// POORA path nikaalo (jaise "Customers/dealers.php" ya "dashboard.php")
$current_page_url = str_replace('\\', '/', $_SERVER['PHP_SELF']);

// Base URL ko hata dein
if ($__base_url !== '' && strpos($current_page_url, $__base_url) === 0) {
    $current_page_url = substr($current_page_url, strlen($__base_url));
}
$current_page_url = ltrim($current_page_url, '/');

$allowed_pages = $_SESSION['allowed_pages'] ?? [];

// Admin ko sab allow (bypass)
if ($topbar_user_privilege !== 'Admin') {

    // Agar current page allowed list mein nahi hai
    if (!in_array($current_page_url, $allowed_pages)) {

        // Pehla allowed page pe redirect
        if (!empty($allowed_pages)) {
            header('Location: ' . $__base_url . '/' . $allowed_pages[0]);
        } else {
            // Koi page allowed nahi → logout
            header('Location: ' . $__base_url . '/api/auth/logout.php');
        }
        exit;
    }
}

// ============================================
// 4. Helper function — sidebar ke liye
// ============================================
function canSeePage($page_url) {
    global $topbar_user_privilege, $allowed_pages;

    // Admin sab dekh sakta hai
    if ($topbar_user_privilege === 'Admin') return true;

    return in_array($page_url, $allowed_pages);
}