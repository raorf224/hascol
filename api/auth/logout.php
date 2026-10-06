<?php
// Hascol OMC - Logout API
session_start();

// Destroy session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login
header('Location: ../../login.php');
exit;