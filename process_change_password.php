<?php

declare(strict_types=1);

session_start();

/** Helper: consistent error response */
function bad_request(string $message, int $code = 400): void {
    http_response_code($code);
    echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    exit;
}

/** Validate required fields */
$required = ['username', 'old_password', 'new_password', 'confirm_password'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        bad_request('Missing required fields.');
    }
}

$username        = trim((string)$_POST['username']);
$oldPassword     = (string)$_POST['old_password'];
$newPassword     = (string)$_POST['new_password'];
$confirmPassword = (string)$_POST['confirm_password'];

/** Optional: CSRF check if you embedded a token on the form page */
// if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     bad_request('Invalid request (CSRF).');
// }

/** Basic validation */
//if (strlen($newPassword) < 8) {
//    bad_request('New password must be at least 8 characters.');
//}
if ($newPassword !== $confirmPassword) {
    bad_request('New password and confirmation do not match.');
}
if ($newPassword === $oldPassword) {
    bad_request('New password cannot be the same as the old password.');
}

// OPTIONAL: Strength policy (uncomment if needed)
// if (!preg_match('/[A-Z]/', $newPassword) || !preg_match('/[a-z]/', $newPassword) || !preg_match('/\d/', $newPassword)) {
//     bad_request('Password must include uppercase, lowercase, and a number.');
// }

/** --- Database config --- */
$dbHost = "10.2.0.57";
$dbUser = "git_training";
$dbPass = "nVnr93?c";
$dbName = "git_training";

/** Connect to MySQL (MySQLi) */
$mysqli = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$mysqli) {
    bad_request('Database connection error.', 500);
}
mysqli_set_charset($mysqli, 'utf8mb4');

$sql  = 'SELECT id, password_hash FROM users WHERE username = ? LIMIT 1';
$stmt = mysqli_prepare($mysqli, $sql);
if (!$stmt) {
    bad_request('Server error (prepare).', 500);
}
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result) {
    bad_request('Server error (result).', 500);
}
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    bad_request('Invalid username or password.');
}

if (!password_verify($oldPassword, $user['password_hash'])) {
    bad_request('Invalid username or password.');
}

$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

$updSql = 'UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?';
$updStmt = mysqli_prepare($mysqli, $updSql);
if (!$updStmt) {
    bad_request('Server error (prepare update).', 500);
}
mysqli_stmt_bind_param($updStmt, 'si', $newHash, $user['id']);

if (!mysqli_stmt_execute($updStmt)) {
    mysqli_stmt_close($updStmt);
    bad_request('Failed to update the password. Please try again.', 500);
}

mysqli_stmt_close($updStmt);

echo 'Password updated successfully.';

mysqli_close($mysqli);
