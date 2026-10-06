<?php
// Hascol OMC - Session Guard
// Har protected page ke TOP pe include hoga

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: /hascol/login.php');
    exit;
}

// ============================================
// Topbar ke liye user data (ready to use)
// ============================================
$topbar_user_name      = $_SESSION['name']  ?? 'User';
$topbar_user_privilege = $_SESSION['privilege']  ?? '';
$topbar_user_initial   = strtoupper(substr($topbar_user_name, 0, 1));