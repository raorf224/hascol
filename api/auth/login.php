<?php
// Hascol OMC - Login API
header('Content-Type: application/json');
session_start();

include("../../config.php");

$API_KEY = '2170';

// Validate API key
if (!isset($_GET['key']) || $_GET['key'] !== $API_KEY) {
    echo json_encode(['status' => 0, 'message' => 'Invalid API key']);
    exit;
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 0, 'message' => 'Invalid request method']);
    exit;
}

$login = isset($_POST['login']) ? trim($_POST['login']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($login === '' || $password === '') {
    echo json_encode(['status' => 0, 'message' => 'Username and password required']);
    exit;
}

// Fetch user by login
$stmt = $db->prepare("SELECT id, name, privilege, login, description, status FROM users WHERE login = ? LIMIT 1");
$stmt->bind_param('s', $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 0, 'message' => 'Invalid username or password']);
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Verify password against `description` field (hashed)
$storedHash = $user['description'];
$passwordOk = false;

if (password_verify($password, $storedHash)) {
    $passwordOk = true;
} elseif (md5($password) === $storedHash) {
    $passwordOk = true;
} elseif (sha1($password) === $storedHash) {
    $passwordOk = true;
} elseif ($password === $storedHash) {
    $passwordOk = true;
}

if (!$passwordOk) {
    echo json_encode(['status' => 0, 'message' => 'Invalid username or password']);
    exit;
}

// Check status
if (isset($user['status']) && strtolower($user['status']) !== 'active' && $user['status'] !== '1') {
    echo json_encode(['status' => 0, 'message' => 'Account is not active']);
    exit;
}

// Insert login log
$logStmt = $db->prepare("INSERT INTO user_login_logs (user_id, login_at) VALUES (?, NOW())");
$logStmt->bind_param('i', $user['id']);
$logStmt->execute();
$logStmt->close();

// Set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['privilege'] = $user['privilege'];
$_SESSION['login'] = $user['login'];

// ✅ Load privilege ki permissions
$userPrivilege = $user['privilege'];
$allowedPages = [];

$permStmt = $db->prepare("
    SELECT p.page_url 
    FROM pages p
    INNER JOIN privilege_permissions pp ON pp.page_id = p.id
    WHERE pp.privilege = ? AND p.status = 1
    ORDER BY p.id ASC
");
$permStmt->bind_param('s', $userPrivilege);
$permStmt->execute();
$permResult = $permStmt->get_result();

while ($row = $permResult->fetch_assoc()) {
    $allowedPages[] = $row['page_url'];
}
$permStmt->close();

$_SESSION['allowed_pages'] = $allowedPages;

// ✅ Redirect: pehla allowed page
if (!empty($allowedPages)) {
    $redirectUrl = $allowedPages[0];
} else {
    echo json_encode([
        'status'  => 0,
        'message' => 'Your account has no page permissions assigned. Please contact the administrator.'
    ]);
    exit;
}

echo json_encode([
    'status'   => 1,
    'message'  => 'Login successful',
    'redirect' => $redirectUrl,
    'user'     => [
        'id'        => $user['id'],
        'name'      => $user['name'],
        'privilege' => $user['privilege']
    ]
]);
exit;
