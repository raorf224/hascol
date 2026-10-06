<?php
// Hascol OMC - Session Guard
// Har protected page ke TOP pe include hoga

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// 1. Login check
// ============================================
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: /hascol/login.php');
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
// ✅ POORA path nikaalo (jaise "Customers/dealers.php" ya "dashboard.php")
$current_page_url = str_replace('/hascol/', '', $_SERVER['PHP_SELF']);
$current_page_url = ltrim($current_page_url, '/');

$allowed_pages = $_SESSION['allowed_pages'] ?? [];

// Admin ko sab allow (bypass)
if ($topbar_user_privilege !== 'Admin') {

    // Agar current page allowed list mein nahi hai
    if (!in_array($current_page_url, $allowed_pages)) {

        // ✅ Pehla allowed page pe redirect
        if (!empty($allowed_pages)) {
            header('Location: /hascol/' . $allowed_pages[0]);
        } else {
            // Koi page allowed nahi → logout
            header('Location: /hascol/api/auth/logout.php');
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